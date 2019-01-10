<?php

namespace backend\controllers;

use backend\models\AccountForm;
use backend\models\LoginForm;
use core\models\User;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SignInController extends Controller
{
    public $defaultAction = 'login';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post']
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'   => true,
                        'roles'   => ['?'],
                        'actions' => ['login'],
                    ],
                    [
                        'allow'   => true,
                        'roles'   => ['@'],
                        'actions' => ['logout', 'profile', 'account'],
                    ]
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'avatar-upload' => [
                'class'        => UploadAction::class,
                'deleteRoute'  => 'avatar-delete',
                'on afterSave' => function ($event) {
                    /* @var $file \League\Flysystem\File */
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                    $file->put($img->encode());
                }
            ],
            'avatar-delete' => [
                'class' => DeleteAction::class
            ]
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionLogin()
    {
        $this->layout = 'base';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

            return $this->render('login', [
                'model' => $model
            ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity->userProfile;
        if ($model->load($_POST) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body'    => Yii::t('backend', 'Your profile has been successfully saved', [], $model->locale)
            ]);

            return $this->refresh();
        }

        return $this->render('profile', ['model' => $model]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAccount()
    {
        $user = Yii::$app->user->identity;
        $model = new AccountForm();
        $model->email = $user->email;
        if ($model->load($_POST) && $model->validate()) {
            if($user->email !== $model->email && $model->email) {
                $user->email = $model->email;
                $user->relationGameAccount->email = $model->email;
                $user->relationGameAccount->save();
            }
            if ($model->password) {
                $user->setPassword($model->password);
            }
            if($model->external_account !== $user->external_id) {
                $user->external_id = $model->external_account;
            }
            $user->save();
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body'    => Yii::t('backend', 'Your account has been successfully saved')
            ]);

            return $this->refresh();
        }

        return $this->render('account', ['model' => $model]);
    }
}
