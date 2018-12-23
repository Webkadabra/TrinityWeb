<?php
namespace frontend\components;

use Yii;
use yii\base\Component;

class MenuHelper extends Component
{
    public static function get_items_for_left_side_menu() {
        return [
            [
                'label' => Yii::t('frontend', 'Home'),
                'url'   => ['/main/index'],
            ],
            [
                'label'   => Yii::t('ladder', 'Ladder'),
                'visible' => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_LADDER_STATUS) === Yii::$app->settings::ENABLED,
                'url'     => ['/ladder/default/index'],
            ],
            [
                'label'   => Yii::t('forum', 'Forum'),
                'visible' => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_FORUM_STATUS) === Yii::$app->settings::ENABLED,
                'url'     => ['/forum/forum/index'],
            ],
        ];
    }

    public static function get_items_for_right_side_menu() {
        return [
            [
                'label'       => Yii::t('frontend', 'Login'),
                'linkOptions' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-auth-login'
                ],
                'visible' => Yii::$app->user->isGuest,
            ],
            [
                'label'       => Yii::t('frontend', 'Signup'),
                'linkOptions' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-auth-signup'
                ],
                'visible' => Yii::$app->user->isGuest,
            ],
            [
                'label'   => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity(),
                'visible' => !Yii::$app->user->isGuest,
                'items'   => [
                    [
                        'label' => Yii::t('frontend', 'Личный кабинет'),
                        'url'   => ['/profile/default/index']
                    ],
                    [
                        'label'   => Yii::t('frontend', 'Backend'),
                        'url'     => Yii::getAlias('@backendUrl'),
                        'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_TO_BACKEND)
                    ]
                ]
            ],
            [
                'label'       => Yii::t('frontend', 'Logout'),
                'url'         => ['/auth/logout'],
                'visible'     => !Yii::$app->user->isGuest,
                'linkOptions' => [
                    'data-method' => 'post',
                    'data-hover'  => Yii::t('frontend', 'Logout')
                ],
            ],
            [
                'label' => Yii::t('frontend', 'Language'),
                'items' => array_map(function ($lang) {
                    return [
                        'label'       => $lang['name'],
                        'url'         => ['/main/set-locale', 'locale' => $lang['language_id']],
                        'active'      => Yii::$app->language === $lang['language_id'],
                        'linkOptions' => ['class' => Yii::$app->language === $lang['language_id'] ? 'active' : null]
                    ];
                }, Yii::$app->i18nHelper::getLocales())
            ]
        ];
    }
}