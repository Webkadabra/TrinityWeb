<?php

namespace core\modules\forum\models;

use core\modules\forum\db\Query;
use core\modules\forum\helpers\Helper;
use core\modules\forum\log\Log;
use core\modules\forum\models\db\UserActiveRecord;
use core\modules\forum\Podium;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

/**
 * User model
 */
class User extends UserActiveRecord
{
    /**
     * Responses.
     */
    const RESP_ERR = 0;
    const RESP_OK = 1;
    const RESP_EMAIL_SEND_ERR = 2;
    const RESP_NO_EMAIL_ERR = 3;

    /**
     * @var string CAPTCHA.
     */
    public $captcha;

    /**
     * @var int Terms of service agreement flag (write-only).
     */
    public $tos;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = [
            'installation' => [],
            'token' => [],
            'ban' => [],
            'role' => [],
        ];
        return $scenarios;
    }

    /**
     * Activates account.
     * @return bool
     * @throws \yii\db\Exception
     */
    public function activate()
    {
        if ($this->status == self::STATUS_REGISTERED) {
            $transaction = static::getDb()->beginTransaction();
            try {
                $this->status = self::STATUS_ACTIVE;
                if (!$this->save()) {
                    throw new Exception('User saving error!');
                }
                if (!Podium::getInstance()->rbac->assign(Podium::getInstance()->rbac->getRole(User::ROLE_USER), $this->id)) {
                    throw new Exception('User role assigning error!');
                }
                $transaction->commit();
                return true;
            } catch (Exception $e) {
                $transaction->rollBack();
                Log::error($e->getMefssage(), null, __METHOD__);
            }
        }
        return false;
    }

    /**
     * Changes email address.
     * @return bool
     */
    public function changeEmail()
    {
        $this->email = $this->new_email;
        $this->new_email = null;
        $this->removeEmailToken();
        return $this->save();
    }

    /**
     * Returns number of new user messages.
     * @return int
     */
    public function getNewMessagesCount()
    {
        $cache = Podium::getInstance()->podiumCache->getElement('user.newmessages', $this->id);
        if ($cache === false) {
            $cache = (new Query())->from(MessageReceiver::tableName())->where([
                    'receiver_id' => $this->id,
                    'receiver_status' => Message::STATUS_NEW
                ])->count();
            Podium::getInstance()->podiumCache->setElement('user.newmessages', $this->id, $cache);
        }
        return $cache;
    }

    /**
     * Returns Podium username.
     * @return string
     */
    public function getPodiumName()
    {
        return $this->username ?: 'user_' . $this->id;
    }

    /**
     * Returns Podium name tag.
     * @param bool $simple
     * @return string
     */
    public function getPodiumTag($simple = false)
    {
        return Helper::podiumUserTag($this->podiumName, $this->role, $this->id, $this->podiumSlug, $simple);
    }

    /**
     * Returns Podium member slug.
     * @return string
     */
    public function getPodiumSlug()
    {
        return $this->slug ?: 'forum-' . $this->id;
    }

    /**
     * Returns number of active posts added by user.
     * @return int
     */
    public function getPostsCount()
    {
        return static::findPostsCount($this->id);
    }

    /**
     * Returns number of active posts added by user of given ID.
     * @param int $id
     * @return int
     */
    public static function findPostsCount($id)
    {
        $cache = Podium::getInstance()->podiumCache->getElement('user.postscount', $id);
        if ($cache === false) {
            $cache = (new Query)->from(Post::tableName())->where(['author_id' => $id])->count();
            Podium::getInstance()->podiumCache->setElement('user.postscount', $id, $cache);
        }
        return $cache;
    }

    /**
     * Returns number of active threads added by user.
     * @return int
     */
    public function getThreadsCount()
    {
        return static::findThreadsCount($this->id);
    }

    /**
     * Returns number of active threads added by user of given ID.
     * @param int $id
     * @return int
     */
    public static function findThreadsCount($id)
    {
        $cache = Podium::getInstance()->podiumCache->getElement('user.threadscount', $id);
        if ($cache === false) {
            $cache = (new Query)->from(Thread::tableName())->where(['author_id' => $id])->count();
            Podium::getInstance()->podiumCache->setElement('user.threadscount', $id, $cache);
        }
        return $cache;
    }

    /**
     * Returns list of roles.
     * @return array
     */
    public static function getRoles()
    {
        return [
            self::ROLE_USER => Yii::t('podium/view', 'Member'),
            self::ROLE_MODERATOR => Yii::t('podium/view', 'Moderator'),
            self::ROLE_ADMINISTRATOR => Yii::t('podium/view', 'Admin'),
        ];
    }

    /**
     * Returns list of moderators roles.
     * @return array
     */
    public static function getModRoles()
    {
        return [
            self::ROLE_MODERATOR => Yii::t('podium/view', 'Moderator'),
            self::ROLE_ADMINISTRATOR => Yii::t('podium/view', 'Admin'),
        ];
    }

    /**
     * Returns list of statuses.
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('podium/view', 'Active'),
            self::STATUS_BANNED => Yii::t('podium/view', 'Banned'),
            self::STATUS_REGISTERED => Yii::t('podium/view', 'Registered'),
        ];
    }

    /**
     * Returns number of user subscribed threads with new posts.
     * @return int
     */
    public function getSubscriptionsCount()
    {
        $cache = Podium::getInstance()->podiumCache->getElement('user.subscriptions', $this->id);
        if ($cache === false) {
            $cache = (new Query)->from(Subscription::tableName())->where([
                    'user_id' => $this->id,
                    'post_seen' => Subscription::POST_NEW
                ])->count();
            Podium::getInstance()->podiumCache->setElement('user.subscriptions', $this->id, $cache);
        }
        return $cache;
    }

    /**
     * Finds out if user is befriended by another.
     * @param int $userId user ID
     * @return bool
     * @since 0.2
     */
    public function isBefriendedBy($userId)
    {
        if ((new Query)->select('id')->from('{{%user_friend}}')->where([
                'user_id' => $userId,
                'friend_id' => $this->id
            ])->exists()) {
            return true;
        }
        return false;
    }

    /**
     * Finds out if user is befriending another.
     * @param int $userId user ID
     * @return bool
     * @since 0.2
     */
    public function isFriendOf($userId)
    {
        if ((new Query)->select('id')->from('{{%user_friend}}')->where([
                'user_id' => $this->id,
                'friend_id' => $userId
            ])->exists()) {
            return true;
        }
        return false;
    }

    /**
     * Finds out if user is ignored by another.
     * @param int $userId user ID
     * @return bool
     */
    public function isIgnoredBy($userId)
    {
        if ((new Query)->select('id')->from('{{%user_ignore}}')->where([
                'user_id' => $userId,
                'ignored_id' => $this->id
            ])->exists()) {
            return true;
        }
        return false;
    }

    /**
     * Finds out if user is ignoring another.
     * @param int $user_id user ID
     * @return bool
     */
    public function isIgnoring($user_id)
    {
        if ((new Query)->select('id')->from('{{%user_ignore}}')->where([
                'user_id' => $this->id,
                'ignored_id' => $user_id
            ])->exists()) {
            return true;
        }
        return false;
    }

    /**
     * Returns ID of current logged user.
     * @return int
     */
    public static function loggedId()
    {
        if (Podium::getInstance()->user->isGuest) {
            return null;
        }
        if (Podium::getInstance()->userComponent !== true) {
            $user = static::findMe();
            if (empty($user)) {
                return null;
            }
            return $user->id;
        }
        return Podium::getInstance()->user->id;
    }

    /**
     * Bans account.
     * @return bool
     */
    public function ban()
    {
        $this->scenario = 'ban';
        $this->status = self::STATUS_BANNED;
        return $this->save();
    }

    /**
     * Demotes user to given role.
     * @param int $role
     * @return bool
     * @throws \yii\db\Exception
     */
    public function demoteTo($role)
    {
        $transaction = static::getDb()->beginTransaction();
        try {
            $this->scenario = 'role';
            $this->role = $role;
            if (!$this->save()) {
                throw new Exception('User saving error!');
            }
            if (Podium::getInstance()->rbac->getRolesByUser($this->id)
                && !Podium::getInstance()->rbac->revoke(Podium::getInstance()->rbac->getRole(User::ROLE_MODERATOR), $this->id)) {
                throw new Exception('User role revoking error!');
            }
            if (!Podium::getInstance()->rbac->assign(Podium::getInstance()->rbac->getRole(User::ROLE_USER), $this->id)) {
                throw new Exception('User role assigning error!');
            }
            if ((new Query())->from(Mod::tableName())->where(['user_id' => $this->id])->exists()
                && !Podium::getInstance()->db->createCommand()->delete(Mod::tableName(), ['user_id' => $this->id])->execute()) {
                throw new Exception('Moderator deleting error!');
            }
            Activity::updateRole($this->id, User::ROLE_USER);

            $transaction->commit();
            Log::info('User demoted', $this->id, __METHOD__);
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Log::error($e->getMessage(), null, __METHOD__);
        }
        return false;
    }

    /**
     * Promotes user to given role.
     * Only moderator supported now.
     * @param int $role
     * @return bool
     * @throws \yii\db\Exception
     */
    public function promoteTo($role)
    {
        $transaction = static::getDb()->beginTransaction();
        try {
            $this->scenario = 'role';
            $this->role = $role;
            if (!$this->save()) {
                throw new Exception('User saving error!');
            }
            if (Podium::getInstance()->rbac->getRolesByUser($this->id)
                && !Podium::getInstance()->rbac->revoke(Podium::getInstance()->rbac->getRole(User::ROLE_USER), $this->id)) {
                throw new Exception('User role revoking error!');
            }
            if (!Podium::getInstance()->rbac->assign(Podium::getInstance()->rbac->getRole(User::ROLE_MODERATOR), $this->id)) {
                throw new Exception('User role assigning error!');
            }
            Activity::updateRole($this->id, User::ROLE_MODERATOR);

            $transaction->commit();
            Log::info('User promoted', $this->id, __METHOD__);
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Log::error($e->getMessage(), null, __METHOD__);
        }
        return false;
    }

    /**
     * Unbans account.
     * @return bool
     */
    public function unban()
    {
        $this->setScenario('ban');
        $this->status = self::STATUS_ACTIVE;
        return $this->save();
    }

    /**
     * Saves user account details changes.
     * @return bool
     */
    public function saveChanges()
    {
        if (!empty($this->newPassword)) {
            $this->setPassword($this->newPassword);
        }
        if (!empty($this->new_email)) {
            $this->generateEmailToken();
        }
        $updateActivityName = $this->isAttributeChanged('username');
        if (!$this->save(false)) {
            return false;
        }
        if ($updateActivityName) {
            Activity::updateName($this->id, $this->podiumName, $this->podiumSlug);
        }
        return true;
    }

    private $_access = [];

    /**
     * Implementation of \yii\web\User::can().
     * @param string $permissionName the name of the permission.
     * @param array $params name-value pairs that would be passed to the rules.
     * @param bool $allowCaching whether to allow caching the result.
     * @return bool
     */
    public static function can($permissionName, $params = [], $allowCaching = true)
    {
        if (Podium::getInstance()->userComponent === true) {
            return Podium::getInstance()->user->can($permissionName, $params, $allowCaching);
        }
        if (!Podium::getInstance()->user->isGuest) {
            $user = static::findMe();
            if (empty($user)) {
                return false;
            }
            if ($allowCaching && empty($params) && isset($user->_access[$permissionName])) {
                return $user->_access[$permissionName];
            }
            $access = Podium::getInstance()->rbac->checkAccess($user->id, $permissionName, $params);
            if ($allowCaching && empty($params)) {
                $user->_access[$permissionName] = $access;
            }
            return $access;
        }
        return false;
    }

    /**
     * Returns list of friends for dropdown.
     * @return array
     * @since 0.2
     */
    public static function friendsList()
    {
        if (Podium::getInstance()->user->isGuest) {
            return null;
        }
        $logged = static::loggedId();
        $cache = Podium::getInstance()->podiumCache->getElement('user.friends', $logged);
        if ($cache === false) {
            $cache = [];
            $friends = static::findMe()->friends;
            if ($friends) {
                /* @var $friend User */
                foreach ($friends as $friend) {
                    $cache[$friend->id] = $friend->getPodiumTag(true);
                }
            }
            Podium::getInstance()->podiumCache->setElement('user.friends', $logged, $cache);
        }
        return $cache;
    }

    /**
     * Updates moderator assignment for given forum.
     * @param int $forumId forum ID
     * @return bool
     * @since 0.2
     */
    public function updateModeratorForOne($forumId = null)
    {
        try {
            if ((new Query())->from(Mod::tableName())->where([
                    'forum_id' => $forumId,
                    'user_id' => $this->id
                ])->exists()) {
                Podium::getInstance()->db->createCommand()->delete(Mod::tableName(), [
                    'forum_id' => $forumId,
                    'user_id' => $this->id
                ])->execute();
            } else {
                Podium::getInstance()->db->createCommand()->insert(Mod::tableName(), [
                    'forum_id' => $forumId,
                    'user_id' => $this->id
                ])->execute();
            }
            Podium::getInstance()->podiumCache->deleteElement('forum.moderators', $forumId);
            Log::info('Moderator updated', $this->id, __METHOD__);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage(), null, __METHOD__);
        }
        return false;
    }

    /**
     * Updates moderator assignment for given forums.
     * @param array $newForums new assigned forum IDs
     * @param array $oldForums old assigned forum IDs
     * @return bool
     * @throws \yii\db\Exception
     * @since 0.2
     */
    public function updateModeratorForMany($newForums = [], $oldForums = [])
    {
        $transaction = static::getDb()->beginTransaction();
        try {
            $add = [];
            foreach ($newForums as $forum) {
                if (!in_array($forum, $oldForums, true) && (new Query)->from(Forum::tableName())->where(['id' => $forum])->exists()
                        && (new Query)->from(Mod::tableName())->where(['forum_id' => $forum, 'user_id' => $this->id])->exists() === false) {
                    $add[] = [$forum, $this->id];
                }
            }
            $remove = [];
            foreach ($oldForums as $forum) {
                if (!in_array($forum, $newForums, true) && (new Query)->from(Mod::tableName())->where(['forum_id' => $forum, 'user_id' => $this->id])->exists()) {
                    $remove[] = $forum;
                }
            }
            if (!empty($add) && !Podium::getInstance()->db->createCommand()->batchInsert(Mod::tableName(), ['forum_id', 'user_id'], $add)->execute()) {
                throw new Exception('Moderators adding error!');
            }
            if (!empty($remove) && !Podium::getInstance()->db->createCommand()->delete(Mod::tableName(), ['forum_id' => $remove, 'user_id' => $this->id])->execute()) {
                throw new Exception('Moderators deleting error!');
            }
            Podium::getInstance()->podiumCache->delete('forum.moderators');
            Log::info('Moderators updated', null, __METHOD__);
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Log::error($e->getMessage(), null, __METHOD__);
        }
        return false;
    }

    /**
     * Generates username for inherited account.
     * @throws Exception
     * @since 0.7
     */
    protected function generateUsername()
    {
        $userNameField = Podium::getInstance()->userNameField;
        if ($userNameField !== null) {
            if (empty(Podium::getInstance()->user->identity->$userNameField)) {
                throw new InvalidConfigException("Non-existing or empty '$userNameField' field!");
            }
            $username = Podium::getInstance()->user->identity->$userNameField;
        } else {
            $try = 0;
            do {
                $username = 'user_' . time() . mt_rand(1000, 9999);
                if ($try++ > 10) {
                    throw new Exception('Failed to generate unique username!');
                }
            } while ((new Query)->from(static::tableName())->where(['username' => $username])->exists());
        }
        $this->username = $username;
    }

    /**
     * Returns JSON list of members matching query.
     * @param string $query
     * @return string
     * @since 0.2
     */
    public static function getMembersList($query = null)
    {
        if (null === $query || !is_string($query)) {
            return Json::encode(['results' => []]);
        }

        $cache = Podium::getInstance()->podiumCache->getElement('members.fieldlist', $query);
        if ($cache === false) {
            $users = static::find()->where(['and',
                ['status' => self::STATUS_ACTIVE],
                ['!=', 'id', static::loggedId()],
                ['like', 'username', $query]
            ]);
            $users->orderBy(['username' => SORT_ASC, 'id' => SORT_ASC]);
            $results = ['results' => []];
            foreach ($users->each() as $user) {
                $results['results'][] = ['id' => $user->id, 'text' => $user->getPodiumTag(true)];
            }
            if (empty($results['results'])) {
                return Json::encode(['results' => []]);
            }
            $cache = Json::encode($results);
            Podium::getInstance()->podiumCache->setElement('members.fieldlist', $query, $cache);
        }
        return $cache;
    }

    /**
     * Updates ignore status for the user.
     * @param int $member
     * @return bool
     * @since 0.2
     */
    public function updateIgnore($member)
    {
        try {
            if ($this->isIgnoredBy($member)) {
                if (!Podium::getInstance()->db->createCommand()->delete('{{%user_ignore}}', [
                        'user_id' => $member,
                        'ignored_id' => $this->id
                    ])->execute()) {
                    return false;
                }
                Log::info('User unignored', $this->id, __METHOD__);
            } else {
                if (!Podium::getInstance()->db->createCommand()->insert('{{%user_ignore}}', ['user_id' => $member, 'ignored_id' => $this->id])->execute()) {
                    return false;
                }
                Log::info('User ignored', $this->id, __METHOD__);
            }
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage(), null, __METHOD__);
        }
        return false;
    }

    /**
     * Updates friend status for the user.
     * @param int $friend
     * @return bool
     * @since 0.2
     */
    public function updateFriend($friend)
    {
        try {
            if ($this->isBefriendedBy($friend)) {
                if (!Podium::getInstance()->db->createCommand()->delete('{{%user_friend}}', [
                        'user_id' => $friend,
                        'friend_id' => $this->id
                    ])->execute()) {
                    return false;
                }
                Log::info('User unfriended', $this->id, __METHOD__);
            } else {
                if (!Podium::getInstance()->db->createCommand()->insert('{{%user_friend}}', ['user_id' => $friend, 'friend_id' => $this->id])->execute()) {
                    return false;
                }
                Log::info('User befriended', $this->id, __METHOD__);
            }
            Podium::getInstance()->podiumCache->deleteElement('user.friends', $friend);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage(), null, __METHOD__);
        }
        return false;
    }

    private static $_identity;

    /**
     * Returns current user based on module configuration.
     * @return \core\models\User
     */
    public static function findMe()
    {
        if(!Yii::$app->user->isGuest) {
            return self::findOne(Yii::$app->user->identity->getId());
        }
        return null;
    }
}
