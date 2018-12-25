<?php

namespace core\modules\forum\controllers;

use core\modules\forum\filters\AccessControl;
use core\modules\forum\log\Log;
use core\modules\forum\models\Content;
use core\modules\forum\models\Email;
use core\modules\forum\models\Meta;
use core\modules\forum\models\Subscription;
use core\modules\forum\models\User;
use core\modules\forum\Podium;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Podium Profile controller
 * All actions concerning member profile.
 */
class ProfileController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class'        => AccessControl::class,
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['/auth/sign-in']);
                },
                'rules' => [
                    ['class' => 'core\modules\forum\filters\InstallRule'],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        $parentReturn = parent::init();
        $this->layout = 'main';
        return $parentReturn;
    }

    /**
     * Showing the subscriptions.
     * @return string|Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionSubscriptions()
    {
        $postData = Yii::$app->request->post();
        if ($postData) {
            if (Subscription::remove(!empty($postData['selection']) ? $postData['selection'] : [])) {
                $this->success(Yii::t('podium/flash', 'Subscription list has been updated.'));
            } else {
                $this->error(Yii::t('podium/flash', 'Sorry! There was an error while unsubscribing the thread list.'));
            }

            return $this->refresh();
        }

        return $this->render('subscriptions', [
            'dataProvider' => (new Subscription())->search(Yii::$app->request->get())
        ]);
    }

    /**
     * Marking the subscription of given ID.
     * @param int $id
     * @return Response
     */
    public function actionMark($id = null)
    {
        $model = Subscription::find()->where(['id' => $id, 'user_id' => User::loggedId()])->limit(1)->one();
        if (empty($model)) {
            $this->error(Yii::t('podium/flash', 'Sorry! We can not find Subscription with this ID.'));

            return $this->redirect(['profile/subscriptions']);
        }
        if ($model->post_seen === Subscription::POST_SEEN) {
            if ($model->unseen()) {
                $this->success(Yii::t('podium/flash', 'Thread has been marked unseen.'));
            } else {
                Log::error('Error while marking thread', $model->id, __METHOD__);
                $this->error(Yii::t('podium/flash', 'Sorry! There was some error while marking the thread.'));
            }

            return $this->redirect(['profile/subscriptions']);
        }
        if ($model->post_seen === Subscription::POST_NEW) {
            if ($model->seen()) {
                $this->success(Yii::t('podium/flash', 'Thread has been marked seen.'));
            } else {
                Log::error('Error while marking thread', $model->id, __METHOD__);
                $this->error(Yii::t('podium/flash', 'Sorry! There was some error while marking the thread.'));
            }

            return $this->redirect(['profile/subscriptions']);
        }
        $this->error(Yii::t('podium/flash', 'Sorry! Subscription has got the wrong status.'));

        return $this->redirect(['profile/subscriptions']);
    }

    /**
     * Deleting the subscription of given ID.
     * @param int $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id = null)
    {
        $model = Subscription::find()->where(['id' => (int)$id, 'user_id' => User::loggedId()])->limit(1)->one();
        if (empty($model)) {
            $this->error(Yii::t('podium/flash', 'Sorry! We can not find Subscription with this ID.'));

            return $this->redirect(['profile/subscriptions']);
        }
        if ($model->delete()) {
            $this->module->podiumCache->deleteElement('user.subscriptions', User::loggedId());
            $this->success(Yii::t('podium/flash', 'Thread has been unsubscribed.'));
        } else {
            Log::error('Error while deleting subscription', $model->id, __METHOD__);
            $this->error(Yii::t('podium/flash', 'Sorry! There was some error while deleting the subscription.'));
        }

        return $this->redirect(['profile/subscriptions']);
    }

    /**
     * Subscribing the thread of given ID.
     * @param int $id
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionAdd($id = null)
    {
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['forum/index']);
        }

        $data = [
            'error' => 1,
            'msg'   => Html::tag('span',
                Html::tag('span', '', ['class' => 'glyphicon glyphicon-warning-sign'])
                . ' ' . Yii::t('podium/view', 'Error while adding this subscription!'),
                ['class' => 'text-danger']
            ),
        ];

        if (Podium::getInstance()->user->isGuest) {
            $data['msg'] = Html::tag('span',
                Html::tag('span', '', ['class' => 'glyphicon glyphicon-warning-sign'])
                . ' ' . Yii::t('podium/view', 'Please sign in to subscribe to this thread'),
                ['class' => 'text-info']
            );
        }

        if (is_numeric($id) && $id > 0) {
            $subscription = Subscription::find()->where(['thread_id' => $id, 'user_id' => User::loggedId()])->limit(1)->one();
            if (!empty($subscription)) {
                $data['msg'] = Html::tag('span',
                    Html::tag('span', '', ['class' => 'glyphicon glyphicon-warning-sign'])
                    . ' ' . Yii::t('podium/view', 'You are already subscribed to this thread.'),
                    ['class' => 'text-info']
                );
            } else {
                if (Subscription::add((int)$id)) {
                    $data = [
                        'error' => 0,
                        'msg'   => Html::tag('span',
                            Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok-circle'])
                            . ' ' . Yii::t('podium/view', 'You have subscribed to this thread!'),
                            ['class' => 'text-success']
                        ),
                    ];
                }
            }
        }

        return Json::encode($data);
    }
}
