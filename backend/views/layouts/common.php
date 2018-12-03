<?php
/**
 * @var $this    yii\web\View
 * @var $content string
 */

use backend\assets\BackendAsset;
use backend\modules\system\models\SystemLog;
use backend\widgets\Menu;
use yii\helpers\Html;
use yii\log\Logger;
use core\widgets\Alert;
use core\widgets\Breadcrumbs;

$bundle = BackendAsset::register($this);

?>

<?php $this->beginContent('@backend/views/layouts/base.php'); ?>

<div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper">
            <a class="navbar-brand brand-logo" href="index.html">TrinityWeb</a>
            <a class="navbar-brand brand-logo-mini" href="index.html">TW</a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav ml-lg-auto">
                <li class="nav-item dropdown notification-dropdown">
                    <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        <span class="count"></span>
                    </a>
                    <div class="dropdown-menu navbar-dropdown preview-list notification-drop-down dropdownAnimation" aria-labelledby="notificationDropdown">
                        <?php foreach (SystemLog::find()->orderBy(['log_time' => SORT_DESC])->limit(5)->all() as $logEntry): ?>
                            <a class="dropdown-item preview-item" href="<?php echo Yii::$app->urlManager->createUrl(['/system/log/view', 'id' => $logEntry->id]) ?>">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon">
                                        <i class="mx-0 fa fa-exclamation <?php echo $logEntry->level === Logger::LEVEL_ERROR ? 'text-danger' : 'text-warning' ?>"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject"><?php echo $logEntry->category ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li class="nav-item dropdown user-dropdown">
                    <a class="nav-link count-indicator" id="userDropdown" href="#" data-toggle="dropdown">
                        <span><?php echo Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                    </a>
                    <div class="dropdown-menu navbar-dropdown preview-list notification-drop-down dropdownAnimation" aria-labelledby="userDropdown">
                        <div class="">
                            <div class="dropdown-header">
                                <p>
                                    <?php echo Yii::$app->user->identity->username ?>
                                    <small>
                                        <?php echo Yii::t('backend', 'Member since {0, date, short}', Yii::$app->user->identity->created_at) ?>
                                    </small>
                                </p>
                                <div class="row">
                                    <div class="col-12">
                                        <?php echo Html::a(Yii::t('backend', 'Profile'), ['/sign-in/profile'], ['class' => 'btn btn-default w-100']) ?>
                                    </div>
                                    <div class="col-12">
                                        <?php echo Html::a(Yii::t('backend', 'Account'), ['/sign-in/account'], ['class' => 'btn btn-default w-100']) ?>
                                    </div>
                                    <div class="col-12">
                                        <?php echo Html::a(Yii::t('backend', 'Logout'), ['/sign-in/logout'], ['class' => 'btn btn-default w-100', 'data-method' => 'post']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-auto" type="button" data-toggle="offcanvas">
                <span class="fa-align-justify fa"></span>
            </button>
        </div>
    </nav>
    <div class="container-fluid page-body-wrapper">
        <div class="row row-offcanvas row-offcanvas-right">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <?php echo Menu::widget([
                    'options' => ['class' => 'nav', 'id' => 'sidebar-menu'],
                    'activateParents' => true,
                    'items' => [
                        [
                            'label' => Yii::t('backend', 'Main'),
                            'options' => ['class' => 'nav-item nav-category'],
                            'visible' =>
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_TIMELINE) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_DASHBOARD) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_USERS) ?
                                    true : false,
                        ],
                        [
                            'label' => Yii::t('backend', 'Dashboard'),
                            'icon' => '<i class="fas fa-tachometer-alt"></i>',
                            'url' => ['/dashboard/index'],
                            'options' => ['class' => 'nav-item'],
                            'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_DASHBOARD)
                        ],
                        [
                            'label' => Yii::t('backend', 'Timeline'),
                            'icon' => '<i class="fa fa-chart-bar"></i>',
                            'url' => ['/timeline-event/index'],
                            'options' => ['class' => 'nav-item'],
                            'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_TIMELINE)
                        ],
                        [
                            'label' => Yii::t('backend', 'Users'),
                            'url' => ['/user/index'],
                            'icon' => '<i class="fa fa-users"></i>',
                            'options' => ['class' => 'nav-item'],
                            'active' => (Yii::$app->controller->id == 'user'),
                            'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_USERS)
                        ],
                        [
                            'label' => Yii::t('backend', 'Content'),
                            'options' => ['class' => 'nav-item nav-category'],
                            'visible' =>
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_ARTICLES) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_PAGES) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CATEGORIES) ?
                                    true : false,
                        ],
                        [
                            'label' => Yii::t('backend', 'Articles'),
                            'url' => '#',
                            'options' => ['class' => 'nav-item'],
                            'icon' => '<i class="fa fa-archive"></i>',
                            'active' => (Yii::$app->controller->module->id == 'content'),
                            'visible' =>
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_ARTICLES) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_PAGES) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CATEGORIES) ?
                                    true : false,
                            'items' => [
                                [
                                    'label' => Yii::t('backend', 'Static pages'),
                                    'url' => ['/content/page/index'],
                                    'icon' => '<i class="fa fa-thumbtack"></i>',
                                    'options' => ['class' => 'nav-item'],
                                    'active' => (Yii::$app->controller->id == 'page'),
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_PAGES)
                                ],
                                [
                                    'label' => Yii::t('backend', 'Articles'),
                                    'url' => ['/content/article/index'],
                                    'options' => ['class' => 'nav-item'],
                                    'icon' => '<i class="fa fa-file"></i>',
                                    'active' => (Yii::$app->controller->id == 'article'),
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_ARTICLES)
                                ],
                                [
                                    'label' => Yii::t('backend', 'Categories'),
                                    'url' => ['/content/category/index'],
                                    'options' => ['class' => 'nav-item'],
                                    'icon' => '<i class="fa fa-folder-open"></i>',
                                    'active' => (Yii::$app->controller->id == 'category'),
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CATEGORIES)
                                ],
                            ],
                        ],
                        [
                            'label' => Yii::t('backend', 'Widgets'),
                            'url' => '#',
                            'icon' => '<i class="fa fa-code"></i>',
                            'options' => ['class' => 'nav-item'],
                            'active' => (Yii::$app->controller->module->id == 'widget'),
                            'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_CAROUSELS) ? true : false,
                            'items' => [
                                [
                                    'label' => Yii::t('backend', 'Carousel'),
                                    'url' => ['/widget/carousel/index'],
                                    'options' => ['class' => 'nav-item'],
                                    'icon' => '<i class="fa fa-circle-o"></i>',
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_CAROUSELS),
                                    'active' => in_array(Yii::$app->controller->id, ['carousel', 'carousel-item']),
                                ],
                            ],
                        ],
                        [
                            'label' => Yii::t('backend', 'Translation'),
                            'options' => ['class' => 'nav-item nav-category'],
                            'visible' =>
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_SCAN) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_OPTIMIZE) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_MANAGE) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_IMPORT) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_EXPORT) ?
                                    true : false,
                        ],
                        [
                            'label' => Yii::t('backend', 'Translation'),
                            'url' => ['/translation/default/index'],
                            'options' => ['class' => 'nav-item'],
                            'icon' => '<i class="fa fa-language"></i>',
                            'visible' =>
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_SCAN) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_OPTIMIZE) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_MANAGE) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_IMPORT) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_EXPORT) ?
                                    true : false,
                            'active' => (Yii::$app->controller->module->id == 'translatemanager'),
                            'items' => [
                                [
                                    'label' => Yii::t('language', 'List of languages'),
                                    'url' => ['/translatemanager/language/list'],
                                    'options' => ['class' => 'nav-item'],
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_MANAGE),
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                ],
                                [
                                    'label' => Yii::t('language', 'Import'),
                                    'url' => ['/translatemanager/language/import'],
                                    'options' => ['class' => 'nav-item'],
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_IMPORT),
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                ],
                                [
                                    'label' => Yii::t('language', 'Export'),
                                    'url' => ['/translatemanager/language/export'],
                                    'options' => ['class' => 'nav-item'],
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_EXPORT),
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                ],
                                [
                                    'label' => Yii::t('language', 'Scan'),
                                    'url' => ['/translatemanager/language/scan'],
                                    'options' => ['class' => 'nav-item'],
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_SCAN),
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                ],
                                [
                                    'label' => Yii::t('language', 'Optimize'),
                                    'url' => ['/translatemanager/language/optimizer'],
                                    'options' => ['class' => 'nav-item'],
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_OPTIMIZE),
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                ],
                            ]
                        ],
                        [
                            'label' => Yii::t('backend', 'Forum'),
                            'options' => ['class' => 'nav-item nav-category'],
                            'visible' =>
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_TO_BACKEND) ?
                                    true : false,
                        ],
                        [
                            'label' => Yii::t('backend', 'Forum'),
                            'url' => ['/forum/admin/index'],
                            'options' => ['class' => 'nav-item'],
                            'icon' => '<i class="fa fa-language"></i>',
                            'visible' =>
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_TO_BACKEND) ?
                                    true : false,
                            'active' => (Yii::$app->controller->module->id == 'forum'),
                            'items' => [
                                [
                                    'label' => Yii::t('backend', 'Dashboard'),
                                    'url' => ['/forum/admin/index'],
                                    'options' => ['class' => 'nav-item'],
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                ],
                                [
                                    'label' => Yii::t('backend', 'Forums'),
                                    'url' => ['/forum/admin/categories'],
                                    'options' => ['class' => 'nav-item'],
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                ],
                                [
                                    'label' => Yii::t('backend', 'Icons'),
                                    'url' => ['/forum/admin/icons'],
                                    'options' => ['class' => 'nav-item'],
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                ],
                                [
                                    'label' => Yii::t('backend', 'Contents'),
                                    'url' => ['/forum/admin/contents'],
                                    'options' => ['class' => 'nav-item'],
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                ],
                                [
                                    'label' => Yii::t('backend', 'Settings'),
                                    'url' => ['/forum/admin/settings'],
                                    'options' => ['class' => 'nav-item'],
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                ],
                            ]
                        ],
                        [
                            'label' => Yii::t('backend', 'System'),
                            'options' => ['class' => 'nav-item nav-category'],
                            'visible' =>
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_ASSIGNMENT) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_PERMISSION) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_RULE) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_ROLE) ?
                                    true : false,
                        ],
                        [
                            'label' => Yii::t('backend', 'RBAC Rules'),
                            'icon' => '<i class="fa fa-flag"></i>',
                            'options' => ['class' => 'nav-item'],
                            'active' => (Yii::$app->controller->module->id == 'rbac'),
                            'visible' =>
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_ASSIGNMENT) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_PERMISSION) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_RULE) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_ROLE) ?
                                    true : false,
                            'items' => [
                                [
                                    'label' => Yii::t('rbac-admin','Roles'),
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                    'active' => (\Yii::$app->controller->id == 'role'),
                                    'options' => ['class' => 'nav-item'],
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_ROLE),
                                    'url' => ['/rbac/role/index'],
                                ],
                                [
                                    'label' => Yii::t('rbac-admin','Rules'),
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                    'active' => (\Yii::$app->controller->id == 'rule'),
                                    'options' => ['class' => 'nav-item'],
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_RULE),
                                    'url' => ['/rbac/rule/index'],
                                ],
                                [
                                    'label' => Yii::t('rbac-admin','Permissions'),
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                    'active' => (\Yii::$app->controller->id == 'permission'),
                                    'options' => ['class' => 'nav-item'],
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_PERMISSION),
                                    'url' => ['/rbac/permission/index'],
                                ],
                                [
                                    'label' => Yii::t('rbac-admin','Assignment'),
                                    'icon' => '<i class="fa fa-angle-double-right"></i>',
                                    'active' => (\Yii::$app->controller->id == 'assignment'),
                                    'options' => ['class' => 'nav-item'],
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_ASSIGNMENT),
                                    'url' => ['/rbac/assignment/index'],
                                ],
                            ],
                        ],
                        [
                            'label' => Yii::t('backend', 'Files'),
                            'icon' => '<i class="fa fa-th-large"></i>',
                            'options' => ['class' => 'nav-item'],
                            'active' => (Yii::$app->controller->module->id == 'file'),
                            'visible' =>
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_STORAGE) ||
                                Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_MANAGER) ?
                                true : false,
                            'items' => [
                                [
                                    'label' => Yii::t('backend', 'Storage'),
                                    'url' => ['/file/storage/index'],
                                    'options' => ['class' => 'nav-item'],
                                    'icon' => '<i class="fa fa-database"></i>',
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_STORAGE),
                                    'active' => (Yii::$app->controller->id == 'storage'),
                                ],
                                [
                                    'label' => Yii::t('backend', 'Manager'),
                                    'url' => ['/file/manager/index'],
                                    'options' => ['class' => 'nav-item'],
                                    'icon' => '<i class="fa fa-tv"></i>',
                                    'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_MANAGER),
                                    'active' => (Yii::$app->controller->id == 'manager'),
                                ],
                            ],
                        ],
                        [
                            'label' => Yii::t('backend', 'Cache'),
                            'options' => ['class' => 'nav-item'],
                            'url' => ['/system/cache/index'],
                            'icon' => '<i class="fa fa-sync"></i>',
                            'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CACHE),
                            'active' => (Yii::$app->controller->id == 'cache')
                        ],
                        [
                            'label' => Yii::t('backend', 'System Information'),
                            'options' => ['class' => 'nav-item'],
                            'url' => ['/system/information/index'],
                            'icon' => '<i class="fa fa-tachometer-alt"></i>',
                            'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_INFORMATION),
                            'active' => (Yii::$app->controller->id == 'information')
                        ],
                        [
                            'label' => Yii::t('backend', 'Application settings'),
                            'url' => ['/system/settings/index'],
                            'options' => ['class' => 'nav-item'],
                            'icon' => '<i class="fas fa-cogs"></i>',
                            'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_SETTINGS),
                            'active' => (Yii::$app->controller->id == 'settings')
                        ],
                        [
                            'label' => Yii::t('backend', 'Logs'),
                            'url' => ['/system/log/index'],
                            'options' => ['class' => 'nav-item'],
                            'icon' => '<i class="fa fa-exclamation-triangle"></i>',
                            'visible' => Yii::$app->user->can(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LOGS),
                            'active' => (Yii::$app->controller->id == 'log')
                        ],
                    ]
                ])?>
            </nav>
            <div class="content-wrapper">
                <?php echo Breadcrumbs::widget([
                    'tag' => 'ol',
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?php echo Alert::widget() ?>
                <?=$content?>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>
