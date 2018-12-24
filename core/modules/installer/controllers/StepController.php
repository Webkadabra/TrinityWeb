<?php

namespace core\modules\installer\controllers;

use core\components\settings\Settings;
use core\modules\installer\helpers\Configuration;
use core\modules\installer\helpers\SystemCheck;
use core\modules\installer\helpers\TourHelper;
use core\modules\installer\models\config\AppSettingsForm;
use core\modules\installer\models\config\MailerForm;
use core\modules\installer\models\config\RecaptchaForm;
use core\modules\installer\models\setup\DatabaseForm;
use core\modules\installer\models\setup\MultyDatabaseForm;
use core\modules\installer\models\setup\SignUpForm;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\db\Connection;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Step Controller shows a simple GUI installation
 */
class StepController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Initiates application setup
     */
    public function actionPrerequisites()
    {
        $checks = SystemCheck::getResults();
        $hasError = FALSE;
        foreach ($checks as $check) {
            if ($check['state'] === 'ERROR') $hasError = TRUE;
        }
        if($post = Yii::$app->request->post()) {
            TourHelper::setStep('web-database');

            return $this->redirect(['web-database']);
        }

        return $this->render('prerequisites', ['checks' => $checks, 'hasError' => $hasError]);
    }

    public function actionWebDatabase()
    {
        $result_data = [
            'config' => null,
            'error'  => null
        ];
        $model = new DatabaseForm(['_name' => 'TrinitWeb']);

        if($post = Yii::$app->request->post()) {
            if ($model->load($post)) {
                if ($model->validate()) {
                    $result_data = Configuration::buildConfigurationDatabase($model, 'db');
                    if($result_data['error'] === null) {
                        Configuration::setConfig(Yii::getAlias('@core/config/app/database-web.php'), $result_data['config']);
                        Configuration::initConfigForComponents();
                        TourHelper::setStep('install-database');

                        return $this->redirect(['install-database']);
                    }
                }
            }
        }

        return $this->render('_single_db_form',[
            'model'    => $model,
            'errorMsg' => $result_data['error']
        ]);
    }

    public function actionInstallDatabase()
    {
        $command_list = [
            0 => [
                'command'     => 'app/set-writable --interactive=0',
                'success_msg' => []
            ],
            5 => [
                'command'     => 'app/set-executable --interactive=0',
                'success_msg' => []
            ],
            15 => [
                'command'     => 'app/set-keys --interactive=0',
                'success_msg' => []
            ],
            33 => [
                'command'     => 'migrate/up --interactive=0',
                'success_msg' => [
                    'Migrated up successfully.',
                    'No new migrations found. Your system is up-to-date.'
                ]
            ],
            95 => [
                'command'     => 'rbac-migrate/up --interactive=0',
                'success_msg' => [
                    'Migrated up successfully.',
                    'No new migrations found. Your system is up-to-date.'
                ]
            ],
            100 => false
        ];

        if($post = Yii::$app->request->post()) {
            $percent = $post['percent'];
            if ($percent !== null && Yii::$app->request->isAjax) {
                $command = $command_list[$percent];
                $keys = array_keys($command_list);
                $set_percent = $keys[array_search($percent, $keys) + 1];
                if($command) {
                    $data = Yii::$app->TrinityWeb::executeCommand($command['command']);
                    if(in_array($data['last_line'], $command['success_msg'], true) || empty($command['success_msg'])) {
                        if($set_percent === TourHelper::FINISHED) {
                            Yii::$app->settings->set(Yii::$app->settings::DB_STATUS, Yii::$app->settings::INSTALLED);

                            TourHelper::setStep('auth-database');

                            return Json::encode([
                                'percent' => 100
                            ]);
                        }

                        return Json::encode([
                            'percent' => $set_percent
                        ]);
                    }
  
                        return Json::encode([
                            'percent'    => $percent,
                            'error_data' => json_encode($data['output'])
                        ]);
                }

                return Json::encode([
                    'percent'    => $percent,
                    'error_data' => json_encode(['Wrong command!'])
                ]);
            }
        }

        return $this->render('install-database');
    }

    /**
     * @return string|\yii\web\Response
     * @throws InvalidConfigException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionAuthDatabase()
    {
        $errorMsg = [];
        $success = false;
        $form = new MultyDatabaseForm();
        $form->_name = 'Auth';
        $databaseFormName = (new DatabaseForm())->formName();
        $form->setDefault();
        $config = [];
        if ($form->load(Yii::$app->request->post($databaseFormName))) {
            if ($form->validate()) {
                foreach($form->dbs as $index => $db) {
                    $success = false;
                    $key_name = "auth_$index";
                    $dsn = "mysql:host=" . $db['host'] . ";port=" . $db['port'] . ";dbname=" . $db['database'];
                    Yii::$app->set($key_name, [
                        'class'    => Connection::class,
                        'dsn'      => $dsn,
                        'username' => $db['login'],
                        'password' => $db['password'],
                        'charset'  => 'utf8'
                    ]);
                    try {
                        $err = Yii::$app->TrinityWeb::checkDBConnection($key_name);
                        if ($err === true) {
                            $config['components'][$key_name]['class'] = Connection::class;
                            $config['components'][$key_name]['dsn'] = $dsn;
                            $config['components'][$key_name]['username'] = $db['login'];
                            $config['components'][$key_name]['password'] = $db['password'];
                            $config['components'][$key_name]['charset'] = 'utf8';
                            $config['components'][$key_name]['enableSchemaCache'] = true;
                            $success = true;
                        } else {
                            $errorMsg[$key_name] = Yii::t('installer','Connection {host}:{port} to {database} return with error {err}',[
                                'host'     => $db['host'],
                                'port'     => $db['port'],
                                'database' => $db ['database'],
                                'err'      => $err instanceof \Exception ? $err->getMessage() : null
                            ]);
                        }
                    } catch (InvalidConfigException $e) {
                        $errorMsg[$key_name] = $e->getMessage();
                    }
                }
                if(!$errorMsg) {
                    Configuration::setConfig(Yii::getAlias('@core/config/app/database-auth.php'), $config);

                    Yii::$app->settings->set(Settings::DB_AUTH_STATUS, Settings::INSTALLED);
                    Yii::$app->TrinityWeb::executeCommand('app/sync-servers --interactive=0');
                    TourHelper::setStep('characters-database');

                    return $this->redirect(['characters-database']);
                }
            }
        }

        return $this->render('auth_multiple_dbs_form', [
            'model'    => $form,
            'success'  => $success,
            'errorMsg' => $errorMsg
        ]);
    }

    /**
     * @return string
     * @throws InvalidConfigException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCharactersDatabase()
    {
        $errorMsg = [];
        $success = false;
        $form = new MultyDatabaseForm();
        $form->_name = 'Characters';
        $databaseFormName = (new DatabaseForm())->formName();
        $form->setDefault();
        $config = [];
        if ($form->load(Yii::$app->request->post($databaseFormName))) {
            if ($form->validate()) {
                foreach($form->dbs as $db) {
                    $success = false;
                    $key_name = $db['name'];
                    $dsn = "mysql:host=" . $db['host'] . ";port=" . $db['port'] . ";dbname=" . $db['database'];
                    Yii::$app->set($key_name, [
                        'class'    => Connection::class,
                        'dsn'      => $dsn,
                        'username' => $db['login'],
                        'password' => $db['password'],
                        'charset'  => 'utf8'
                    ]);
                    try {
                        $err = Yii::$app->TrinityWeb::checkDBConnection($key_name);
                        if ($err === true) {
                            $config['components'][$key_name]['class'] = Connection::class;
                            $config['components'][$key_name]['dsn'] = $dsn;
                            $config['components'][$key_name]['username'] = $db['login'];
                            $config['components'][$key_name]['password'] = $db['password'];
                            $config['components'][$key_name]['charset'] = 'utf8';
                            $config['components'][$key_name]['enableSchemaCache'] = true;
                            $success = true;
                        } else {
                            $errorMsg[$key_name] = Yii::t('installer','Connection {host}:{port} to {database} return with error {err}',[
                                'host'     => $db['host'],
                                'port'     => $db['port'],
                                'database' => $db ['database'],
                                'err'      => $err instanceof \Exception ? $err->getMessage() : null
                            ]);
                        }
                    } catch (Exception $e) {
                        $errorMsg[$key_name] = $e->getMessage();
                    }
                }
                if(!$errorMsg) {
                    Configuration::setConfig(Yii::getAlias('@core/config/app/database-characters.php'), $config);

                    Yii::$app->settings->set(Yii::$app->settings::DB_CHARS_STATUS, Yii::$app->settings::INSTALLED);
                    Yii::$app->TrinityWeb::executeCommand('app/sync-servers --interactive=0');
                    TourHelper::setStep('armory-database');

                    return $this->redirect(['armory-database']);
                }
            }
        }

        return $this->render('chars_multiple_dbs_form', [
            'model'    => $form,
            'success'  => $success,
            'errorMsg' => $errorMsg
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionArmoryDatabase()
    {
        //TODO
        TourHelper::setStep('install-armory-database');

        return $this->redirect(['install-armory-database']);
        $result_data = [
            'config' => null,
            'error'  => null
        ];
        $model = new DatabaseForm(['_name' => 'ARMORY']);
        $model->scenario = DatabaseForm::SCENARIO_ARMORY;
        if($post = Yii::$app->request->post()) {
            if ($model->load($post)) {
                $defaultModel = new DatabaseForm(['_name' => 'ARMORY']);
                if ($model->validate()) {
                    if(
                        $defaultModel->host !== $model->host ||
                        $defaultModel->port !== $model->port ||
                        $defaultModel->database !== $model->database ||
                        $defaultModel->login !== $model->login
                    ) {
                        $result_data = Configuration::buildConfigurationDatabase($model, 'db_armory');
                        if ($result_data['error'] === null) {
                            Configuration::setConfig(Yii::getAlias('@core/config/app/database-armory.php'), $result_data['config']);

                            //TODO
                            //Yii::$app->settings->set(TrinityWeb::CONF_DB_ARMORY, TrinityWeb::ENABLED);
                            //Yii::$app->settings->set(TrinityWeb::CONF_DB_ARMORY_DATA, TrinityWeb::INSTALLED);
                            //Yii::$app->settings->set(TrinityWeb::MODULE_ARMORY_STATUS, TrinityWeb::ENABLED);
                        }
                    }  

                        /*
                        TODO
                        Yii::$app->settings->set(TrinityWeb::CONF_DB_ARMORY, TrinityWeb::DISABLED);
                        Yii::$app->settings->set(TrinityWeb::CONF_DB_ARMORY_DATA, TrinityWeb::NOT_INSTALLED);
                        Yii::$app->settings->set(TrinityWeb::MODULE_ARMORY_STATUS, TrinityWeb::DISABLED);
                        */
                    
                    TourHelper::setStep('install-armory-database');

                    return $this->redirect(['install-armory-database']);
                }
            }
        }

        return $this->render('_single_db_form',[
            'model'    => $model,
            'errorMsg' => $result_data['error']
        ]);
    }

    public function actionInstallArmoryDatabase() {
        //TODO
        TourHelper::setStep('recaptcha');

        return $this->redirect(['recaptcha']);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionRecaptcha() {
        $model = new RecaptchaForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->siteKey && $model->secret) {
                    Yii::$app->settings->setAll([
                        Settings::APP_CAPTCHA_KEY    => $model->siteKey,
                        Settings::APP_CAPTCHA_SECRET => $model->secret,
                        Settings::APP_CAPTCHA_STATUS => Settings::ENABLED
                    ]);
                } else {
                    Yii::$app->settings->setAll([
                        Settings::APP_CAPTCHA_KEY    => '',
                        Settings::APP_CAPTCHA_SECRET => '',
                        Settings::APP_CAPTCHA_STATUS => Settings::DISABLED
                    ]);
                }
                TourHelper::setStep('admin-account');

                return $this->redirect(['admin-account']);
            }
        }

        return $this->render('recaptcha', ['model' => $model]);
    }

    /**
     * Setup Administrative User
     *
     * This should be the last step, before the user is created also the
     * application secret will created.
     */
    public function actionAdminAccount()
    {
        $model = new SignUpForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup(env('ADMIN_GAME_ACCOUNT'));
            if($user !== null) {
                if (!$user->hasErrors()) {
                    TourHelper::setStep('mailer');

                    return $this->redirect(['mailer']);
                }
            }
        }

        return $this->render('admin', ['model' => $model]);
    }

    public function actionMailer() {
        $model = new MailerForm();
        if($post = Yii::$app->request->post()) {
            if($model->load($post) && $model->validate()) {
                $config['components']['mailer']['class'] = 'yii\swiftmailer\Mailer';
                $config['components']['mailer']['htmlLayout'] = '@core/mail/layouts/html';
                $config['components']['mailer']['viewPath'] = '@core/mail';
                $config['components']['mailer']['useFileTransport'] = false;
                $config['components']['mailer']['transport'] = [
                    'class'      => 'Swift_SmtpTransport',
                    'host'       => $model->smtp_host,
                    'username'   => $model->smtp_username,
                    'password'   => $model->smtp_password,
                    'port'       => $model->smtp_port,
                    'encryption' => $model->smtp_encrypt,
                ];

                Configuration::setConfig(Yii::getAlias('@core/config/app/mailer.php'), $config);

                Yii::$app->settings->setAll([
                    Settings::APP_MAILER_ADMIN  => $model->email,
                    Settings::APP_MAILER_ROBOT  => $model->robot_email,
                    Settings::APP_MAILER_STATUS => Settings::ENABLED
                ]);

                TourHelper::setStep('app-settings');

                return $this->redirect(['app-settings']);
            }
        }

        return $this->render('mailer', [
            'model' => $model
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAppSettings() {
        $model = new AppSettingsForm();

        if($post = Yii::$app->request->post()) {
            if($model->load($post) && $model->validate()) {
                Yii::$app->settings->setAll([
                    Settings::APP_NAME     => $model->app_name,
                    Settings::APP_ANNOUNCE => $model->app_announce
                ]);

                TourHelper::setStep('finished');

                return $this->redirect(['finished']);
            }
        }

        return $this->render('app-settings',[
            'model' => $model,
        ]);
    }

    /**
     * Last Step, finish up the installation
     */
    public function actionFinished()
    {
        if($post = Yii::$app->request->post()) {
            TourHelper::setInstalled();
            Yii::$app->session->destroySession(TourHelper::SESSION_NAME);

            return $this->redirect(['/']);
        }

        return $this->render('finished');
    }
}