<?php
namespace core\components\helpers;

use yii\base\Component;

class PermissionHelper extends Component
{
    const ACCESS_TO_BACKEND = 'access_to_backend';
    const ACCESS_EDIT_OWN_MODEL = 'access_edit_own_model';

    //GLOBAL

        //i18n
            const ACCESS_GLOBAL_i18n = 'access_global_to_i18n';

            const ACCESS_GLOBAL_i18n_MANAGE = 'access_global_to_i18n_manage';
            const ACCESS_GLOBAL_i18n_IMPORT = 'access_global_to_i18n_import';
            const ACCESS_GLOBAL_i18n_EXPORT = 'access_global_to_i18n_export';
            const ACCESS_GLOBAL_i18n_SCAN = 'access_global_to_i18n_scan';
            const ACCESS_GLOBAL_i18n_OPTIMIZE = 'access_global_to_i18n_optimize';

    //BACKEND

        //TIMELINE
            const ACCESS_BACKEND_TO_TIMELINE = 'access_backend_to_timeline';

        //DASHBOARD
            const ACCESS_BACKEND_TO_DASHBOARD = 'access_backend_to_dashboard';

        //USERS
            const ACCESS_BACKEND_TO_USERS = 'access_backend_to_users';

            const ACCESS_BACKEND_TO_LIST_USERS = 'access_backend_to_list_users';
            const ACCESS_BACKEND_TO_VIEW_USER = 'access_backend_to_view_user';
            const ACCESS_BACKEND_TO_UPDATE_USER = 'access_backend_to_update_user';
            const ACCESS_BACKEND_TO_REMOVE_USER = 'access_backend_to_remove_user';

        //MODULE OF CONTENT
            //Articles
                const ACCESS_BACKEND_TO_ARTICLES = 'access_backend_to_articles';

                const ACCESS_BACKEND_TO_LIST_ARTICLES = 'access_backend_to_list_articles';
                const ACCESS_BACKEND_TO_CREATE_ARTICLE = 'access_backend_to_create_article';
                const ACCESS_BACKEND_TO_VIEW_ARTICLE = 'access_backend_to_view_article';
                const ACCESS_BACKEND_TO_REMOVE_ARTICLE = 'access_backend_to_remove_article';
                const ACCESS_BACKEND_TO_UPDATE_ARTICLE = 'access_backend_to_update_article';

            //Categories
                const ACCESS_BACKEND_TO_CATEGORIES = 'access_backend_to_categories';

                const ACCESS_BACKEND_TO_LIST_CATEGORIES = 'access_backend_to_list_categories';
                const ACCESS_BACKEND_TO_CREATE_CATEGORIES = 'access_backend_to_create_categories';
                const ACCESS_BACKEND_TO_VIEW_CATEGORIES = 'access_backend_to_view_categories';
                const ACCESS_BACKEND_TO_REMOVE_CATEGORIES = 'access_backend_to_remove_categories';
                const ACCESS_BACKEND_TO_UPDATE_CATEGORIES = 'access_backend_to_update_categories';

            //Pages
                const ACCESS_BACKEND_TO_PAGES = 'access_backend_to_pages';

                const ACCESS_BACKEND_TO_LIST_PAGES = 'access_backend_to_list_pages';
                const ACCESS_BACKEND_TO_CREATE_PAGE = 'access_backend_to_create_page';
                const ACCESS_BACKEND_TO_VIEW_PAGE = 'access_backend_to_view_page';
                const ACCESS_BACKEND_TO_REMOVE_PAGE = 'access_backend_to_remove_page';
                const ACCESS_BACKEND_TO_UPDATE_PAGE = 'access_backend_to_update_page';

        //MODULE OF FILES
            //Manager
                const ACCESS_BACKEND_TO_MANAGER = 'access_backend_to_manager';

            //Storage
                const ACCESS_BACKEND_TO_STORAGE = 'access_backend_to_storage';

        //MODULE OF RBAC

            //GLOBAL
                const ACCESS_BACKEND_TO_RBAC = 'access_backend_to_rbac';

            //Assignment
                const ACCESS_BACKEND_TO_RBAC_ASSIGNMENT = 'access_backend_to_rbac_assignment';

            //Permission
                const ACCESS_BACKEND_TO_RBAC_PERMISSION = 'access_backend_to_rbac_permission';

            //Role
                const ACCESS_BACKEND_TO_RBAC_ROLE = 'access_backend_to_rbac_role';

            //Rule
                const ACCESS_BACKEND_TO_RBAC_RULE = 'access_backend_to_rbac_rule';

        //MODULE OF SYSTEM
            //Cache
                const ACCESS_BACKEND_TO_CACHE = 'access_backend_to_cache';

            //Information
                const ACCESS_BACKEND_TO_INFORMATION = 'access_backend_to_information';

            //Settings
                const ACCESS_BACKEND_TO_SETTINGS = 'access_backend_to_settings';

            //Logs
                const ACCESS_BACKEND_TO_LOGS = 'access_backend_to_logs';

        //MODULE OF WIDGETS
            //Carousel
                const ACCESS_BACKEND_TO_CAROUSEL = 'access_backend_to_carousel';

                const ACCESS_BACKEND_TO_LIST_CAROUSELS = 'access_backend_to_list_carousel';
                const ACCESS_BACKEND_TO_CREATE_CAROUSEL = 'access_backend_to_create_carousel';
                const ACCESS_BACKEND_TO_REMOVE_CAROUSEL = 'access_backend_to_remove_carousel';
                const ACCESS_BACKEND_TO_UPDATE_CAROUSEL = 'access_backend_to_update_carousel';

            //CarouselItem
                const ACCESS_BACKEND_TO_CAROUSEL_ITEM = 'access_backend_to_carousel_item';

                const ACCESS_BACKEND_TO_LIST_CAROUSEL_ITEM = 'access_backend_to_list_carousel_item';
                const ACCESS_BACKEND_TO_CREATE_CAROUSEL_ITEM = 'access_backend_to_create_carousel_item';
                const ACCESS_BACKEND_TO_REMOVE_CAROUSEL_ITEM = 'access_backend_to_remove_carousel_item';
                const ACCESS_BACKEND_TO_UPDATE_CAROUSEL_ITEM = 'access_backend_to_update_carousel_item';
}