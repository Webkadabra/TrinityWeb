<?php

namespace frontend\controllers;

use frontend\base\controllers\SystemController;
use frontend\models\forms\LoginForm;
use frontend\models\forms\PasswordResetRequestForm;
use frontend\models\forms\ResetPasswordForm;
use frontend\models\forms\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class AuthController extends SystemController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'sign-up', 'sign-in', 'request-password-reset', 'reset-password'
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'sign-up', 'sign-in', 'request-password-reset', 'reset-password'
                        ],
                        'allow'        => false,
                        'roles'        => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['/main/index']);
                        }
                    ],
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    /**
     * @throws \yii\base\Exception
     * @return string
     */
    public function actionSignIn()
    {
        if(!Yii::$app->request->isPjax) return $this->goHome ();
        $theme = Yii::$app->view->theme->getCurrentTheme();
        $model = new LoginForm();
        if($post = Yii::$app->request->post()) {
            $model->load($post);
            if($model->validate() && $model->login()) {
                return $this->goBack();
            }
            if(Yii::$app->request->isPjax) {
                return $this->renderAjax("@frontend/themes/$theme/widgets/Auth/views/sign-in", [
                    'model' => $model
                ]);
            }
        }

        return $this->renderAjax("@frontend/themes/$theme/widgets/Auth/views/sign-in", [
            'model' => $model
        ]);
    }

    /**
     * @throws \yii\base\Exception
     * @return string
     */
    public function actionSignUp()
    {
        if(!Yii::$app->request->isPjax) return $this->goHome ();
        $theme = Yii::$app->view->theme->getCurrentTheme();
        $model = new SignupForm();
        if($post = Yii::$app->request->post()) {
            $model->load($post);
            $user = $model->signup();
            if($user !== null) {
                if (!$user->hasErrors()) {
                    Yii::$app->getUser()->login($user);
                    Yii::$app->DBHelper->setDefault();

                    return $this->goHome();
                }
            }

            return $this->renderAjax("@frontend/themes/$theme/widgets/Auth/views/sign-up", [
                'model' => $model
            ]);
        }

        return $this->renderAjax("@frontend/themes/$theme/widgets/Auth/views/sign-up", [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @throws \trntv\bus\exceptions\MissingHandlerException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @return string|Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('frontend', 'Check your email for further instructions.'));

                return $this->goHome();
            }  
                Yii::$app->getSession()->setFlash('danger', Yii::t('frontend', 'Sorry, we are unable to reset password for email provided.'));
        }

        return $this->render('request-password-reset-token', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @throws BadRequestHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return string|Response
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('frontend', 'New password was saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
