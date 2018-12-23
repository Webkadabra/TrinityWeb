<?php

use core\models\User;
use core\rbac\Migration;

class m180905_114601_trinity_web extends Migration
{
    public function up()
    {
        //i18n START
        $access_global_i18n = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n);
        $this->auth->add($access_global_i18n);

        $access_global_i18n_manage = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_MANAGE);
        $this->auth->add($access_global_i18n_manage);

        $access_global_i18n_import = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_IMPORT);
        $this->auth->add($access_global_i18n_import);

        $access_global_i18n_export = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_EXPORT);
        $this->auth->add($access_global_i18n_export);

        $access_global_i18n_scan = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_SCAN);
        $this->auth->add($access_global_i18n_scan);

        $access_global_i18n_optimize = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_OPTIMIZE);
        $this->auth->add($access_global_i18n_optimize);

        $this->auth->addChild($access_global_i18n, $access_global_i18n_optimize);
        $this->auth->addChild($access_global_i18n, $access_global_i18n_scan);
        $this->auth->addChild($access_global_i18n, $access_global_i18n_export);
        $this->auth->addChild($access_global_i18n, $access_global_i18n_import);
        $this->auth->addChild($access_global_i18n, $access_global_i18n_manage);
        //--i18n END

        //TIMELINE
        $access_backend_to_timeline = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_TIMELINE);
        $this->auth->add($access_backend_to_timeline);

        //DASHBOARD
        $access_backend_to_dashboard = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_DASHBOARD);
        $this->auth->add($access_backend_to_dashboard);

        //USERS START
        $access_backend_to_users = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_USERS);
        $this->auth->add($access_backend_to_users);

        $access_backend_to_remove_user = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_USER);
        $this->auth->add($access_backend_to_remove_user);

        $access_backend_to_update_user = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_USER);
        $this->auth->add($access_backend_to_update_user);

        $access_backend_to_view_user = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_VIEW_USER);
        $this->auth->add($access_backend_to_view_user);

        $access_backend_to_list_users = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_USERS);
        $this->auth->add($access_backend_to_list_users);

        $this->auth->addChild($access_backend_to_users, $access_backend_to_view_user);
        $this->auth->addChild($access_backend_to_users, $access_backend_to_list_users);
        $this->auth->addChild($access_backend_to_users, $access_backend_to_remove_user);
        $this->auth->addChild($access_backend_to_users, $access_backend_to_update_user);
        //--USERS END

        //ARTICLES START
        $access_backend_to_articles = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_ARTICLES);
        $this->auth->add($access_backend_to_articles);

        $access_backend_to_create_article = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_ARTICLE);
        $this->auth->add($access_backend_to_create_article);

        $access_backend_to_list_article = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_ARTICLES);
        $this->auth->add($access_backend_to_list_article);

        $access_backend_to_remove_article = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_ARTICLE);
        $this->auth->add($access_backend_to_remove_article);

        $access_backend_to_update_article = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_ARTICLE);
        $this->auth->add($access_backend_to_update_article);

        $access_backend_to_view_article = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_VIEW_ARTICLE);
        $this->auth->add($access_backend_to_view_article);

        $this->auth->addChild($access_backend_to_articles, $access_backend_to_create_article);
        $this->auth->addChild($access_backend_to_articles, $access_backend_to_list_article);
        $this->auth->addChild($access_backend_to_articles, $access_backend_to_remove_article);
        $this->auth->addChild($access_backend_to_articles, $access_backend_to_update_article);
        $this->auth->addChild($access_backend_to_articles, $access_backend_to_view_article);
        //--ARTICLES END

        //CATEGORIES
        $access_backend_to_categories = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CATEGORIES);
        $this->auth->add($access_backend_to_categories);

        $access_backend_to_list_categories = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_CATEGORIES);
        $this->auth->add($access_backend_to_list_categories);

        $access_backend_to_update_categories = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_CATEGORIES);
        $this->auth->add($access_backend_to_update_categories);

        $access_backend_to_view_categories = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_VIEW_CATEGORIES);
        $this->auth->add($access_backend_to_view_categories);

        $access_backend_to_remove_categories = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_CATEGORIES);
        $this->auth->add($access_backend_to_remove_categories);

        $access_backend_to_create_categories = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_CATEGORIES);
        $this->auth->add($access_backend_to_create_categories);

        $this->auth->addChild($access_backend_to_categories, $access_backend_to_list_categories);
        $this->auth->addChild($access_backend_to_categories, $access_backend_to_update_categories);
        $this->auth->addChild($access_backend_to_categories, $access_backend_to_view_categories);
        $this->auth->addChild($access_backend_to_categories, $access_backend_to_remove_categories);
        $this->auth->addChild($access_backend_to_categories, $access_backend_to_create_categories);
        //--CATEGORIES END

        //PAGES
        $access_backend_to_pages = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_PAGES);
        $this->auth->add($access_backend_to_pages);

        $access_backend_to_create_page = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_PAGE);
        $this->auth->add($access_backend_to_create_page);

        $access_backend_to_remove_page = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_PAGE);
        $this->auth->add($access_backend_to_remove_page);

        $access_backend_to_update_page = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_PAGE);
        $this->auth->add($access_backend_to_update_page);

        $access_backend_to_list_pages = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_PAGES);
        $this->auth->add($access_backend_to_list_pages);

        $access_backend_to_view_page = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_VIEW_PAGE);
        $this->auth->add($access_backend_to_view_page);

        $this->auth->addChild($access_backend_to_pages, $access_backend_to_create_page);
        $this->auth->addChild($access_backend_to_pages, $access_backend_to_remove_page);
        $this->auth->addChild($access_backend_to_pages, $access_backend_to_update_page);
        $this->auth->addChild($access_backend_to_pages, $access_backend_to_list_pages);
        $this->auth->addChild($access_backend_to_pages, $access_backend_to_view_page);
        //--PAGES END

        //MANAGER FILES
        $access_backend_to_manager = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_MANAGER);
        $this->auth->add($access_backend_to_manager);
        //--MANAGER FILES END

        //STORAGE
        $access_backend_to_storage = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_STORAGE);
        $this->auth->add($access_backend_to_storage);
        //--STORAGE END

        //RBAC
        $access_backend_to_rbac = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC);
        $this->auth->add($access_backend_to_rbac);

        $access_backend_to_rbac_assignment = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_ASSIGNMENT);
        $this->auth->add($access_backend_to_rbac_assignment);

        $access_backend_to_rbac_permission = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_PERMISSION);
        $this->auth->add($access_backend_to_rbac_permission);

        $access_backend_to_rbac_role = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_ROLE);
        $this->auth->add($access_backend_to_rbac_role);

        $access_backend_to_rbac_rule = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_RULE);
        $this->auth->add($access_backend_to_rbac_rule);

        $this->auth->addChild($access_backend_to_rbac, $access_backend_to_rbac_rule);
        $this->auth->addChild($access_backend_to_rbac, $access_backend_to_rbac_role);
        $this->auth->addChild($access_backend_to_rbac, $access_backend_to_rbac_permission);
        $this->auth->addChild($access_backend_to_rbac, $access_backend_to_rbac_assignment);
        //--RBAC END

        //CACHE
        $access_backend_to_cache = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CACHE);
        $this->auth->add($access_backend_to_cache);
        //--CACHE END

        //INFORMATION
        $access_backend_to_information = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_INFORMATION);
        $this->auth->add($access_backend_to_information);
        //--INFORMATION END

        //SETTINGS
        $access_backend_to_settings = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_SETTINGS);
        $this->auth->add($access_backend_to_settings);
        //--SETTINGS END

        //LOGS
        $access_backend_to_logs = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LOGS);
        $this->auth->add($access_backend_to_logs);
        //--LOGS END

        //CAROUSEL
        $access_backend_to_carousel = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CAROUSEL);
        $this->auth->add($access_backend_to_carousel);

        $access_backend_to_list_carousels = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_CAROUSELS);
        $this->auth->add($access_backend_to_list_carousels);

        $access_backend_to_create_carousel = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_CAROUSEL);
        $this->auth->add($access_backend_to_create_carousel);

        $access_backend_to_remove_carousel = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_CAROUSEL);
        $this->auth->add($access_backend_to_remove_carousel);

        $access_backend_to_update_carousel = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_CAROUSEL);
        $this->auth->add($access_backend_to_update_carousel);

        $this->auth->addChild($access_backend_to_carousel, $access_backend_to_list_carousels);
        $this->auth->addChild($access_backend_to_carousel, $access_backend_to_remove_carousel);
        $this->auth->addChild($access_backend_to_carousel, $access_backend_to_create_carousel);
        $this->auth->addChild($access_backend_to_carousel, $access_backend_to_update_carousel);
        //--CAROUSEL END

        //CAROUSEL ITEM
        $access_backend_to_carousel_item = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CAROUSEL_ITEM);
        $this->auth->add($access_backend_to_carousel_item);

        $access_backend_to_list_carousel_item = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_CAROUSEL_ITEM);
        $this->auth->add($access_backend_to_list_carousel_item);

        $access_backend_to_remove_carousel_item = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_CAROUSEL_ITEM);
        $this->auth->add($access_backend_to_remove_carousel_item);

        $access_backend_to_create_carousel_item = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_CAROUSEL_ITEM);
        $this->auth->add($access_backend_to_create_carousel_item);

        $access_backend_to_update_carousel_item = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_CAROUSEL_ITEM);
        $this->auth->add($access_backend_to_update_carousel_item);

        $this->auth->addChild($access_backend_to_carousel_item, $access_backend_to_remove_carousel_item);
        $this->auth->addChild($access_backend_to_carousel_item, $access_backend_to_create_carousel_item);
        $this->auth->addChild($access_backend_to_carousel_item, $access_backend_to_update_carousel_item);
        $this->auth->addChild($access_backend_to_carousel_item, $access_backend_to_list_carousel_item);
        //--CAROUSEL ITEM END

        $role_administrator = $this->auth->getRole(User::ROLE_ADMINISTRATOR);
        $this->auth->addChild($role_administrator, $access_backend_to_carousel_item);
        $this->auth->addChild($role_administrator, $access_backend_to_carousel);
        $this->auth->addChild($role_administrator, $access_backend_to_logs);
        $this->auth->addChild($role_administrator, $access_backend_to_settings);
        $this->auth->addChild($role_administrator, $access_backend_to_information);
        $this->auth->addChild($role_administrator, $access_backend_to_cache);
        $this->auth->addChild($role_administrator, $access_backend_to_rbac);
        $this->auth->addChild($role_administrator, $access_backend_to_storage);
        $this->auth->addChild($role_administrator, $access_backend_to_manager);
        $this->auth->addChild($role_administrator, $access_backend_to_pages);
        $this->auth->addChild($role_administrator, $access_backend_to_categories);
        $this->auth->addChild($role_administrator, $access_backend_to_articles);
        $this->auth->addChild($role_administrator, $access_backend_to_users);
        $this->auth->addChild($role_administrator, $access_backend_to_timeline);
        $this->auth->addChild($role_administrator, $access_global_i18n);
        $this->auth->addChild($role_administrator, $access_backend_to_dashboard);

        $access_to_backend = $this->auth->createPermission(Yii::$app->PermissionHelper::ACCESS_TO_BACKEND);
        $this->auth->add($access_to_backend);

        $this->auth->addChild($role_administrator, $access_to_backend);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_TO_BACKEND));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_CAROUSEL_ITEM));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_CAROUSEL_ITEMS));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_CAROUSEL_ITEM));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_CAROUSEL_ITEM));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CAROUSEL_ITEM));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_CAROUSEL));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_CAROUSEL));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_CAROUSEL));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_CAROUSELS));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CAROUSEL));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LOGS));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_SETTINGS));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_INFORMATION));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CACHE));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_RULE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_ROLE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_PERMISSION));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC_ASSIGNMENT));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_RBAC));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_STORAGE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_MANAGER));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_VIEW_PAGE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_PAGE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_PAGE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_PAGE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_PAGES));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_PAGES));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_CATEGORIES));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_CATEGORIES));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_VIEW_CATEGORIES));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_CATEGORIES));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_CATEGORIES));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CATEGORIES));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_VIEW_ARTICLE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_ARTICLE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_ARTICLE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_ARTICLES));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_CREATE_ARTICLE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_ARTICLES));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_VIEW_USER));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_REMOVE_USER));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_UPDATE_USER));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_LIST_USERS));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_USERS));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_DASHBOARD));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_BACKEND_TO_TIMELINE));

        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_EXPORT));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_IMPORT));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_MANAGE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_OPTIMIZE));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n_SCAN));
        $this->auth->remove($this->auth->getPermission(Yii::$app->PermissionHelper::ACCESS_GLOBAL_i18n));
    }
}
