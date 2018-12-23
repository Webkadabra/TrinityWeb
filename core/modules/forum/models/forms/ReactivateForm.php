<?php

namespace core\modules\forum\models\forms;

use core\modules\forum\models\Content;
use core\modules\forum\models\Email;
use core\modules\forum\models\User;
use core\modules\forum\Podium;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Reactivate Form model
 * Calls for new activation link.
 *
 * @property User $user
 */
class ReactivateForm extends Model
{
    /**
     * @var string Username or email
     */
    public $username;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [['username', 'required']];
    }

    /**
     * Returns user.
     * @param int $status
     * @return User
     */
    public function getUser($status = User::STATUS_ACTIVE)
    {
        if ($this->_user === false) {
            $this->_user = User::findByKeyfield($this->username, $status);
        }

        return $this->_user;
    }

    /**
     * Generates new activation token.
     * @return array $error flag, $message text, $back flag
     */
    public function run()
    {
        $user = $this->getUser(User::STATUS_REGISTERED);
        if (empty($user)) {
            return [
                true,
                Yii::t('podium/flash', 'Sorry! We can not find the account with that user name or e-mail address.'),
                false
            ];
        }
        $user->scenario = 'token';
        if (!$user->save()) {
            return [true, null, false];
        }
        if (empty($user->email)) {
            return [
                true,
                Yii::t('podium/flash', 'Sorry! There is no e-mail address saved with your account. Contact administrator about reactivating.'),
                true
            ];
        }

        return [
            false,
            Yii::t('podium/flash', 'The account activation link has been sent to your e-mail address.'),
            true
        ];
    }
}
