<?php
namespace core\components\helpers;

use core\models\Article;
use core\models\i18n\MetaI18n;
use core\models\Meta;
use core\models\Page;
use Yii;
use yii\base\Component;
use yii\helpers\StringHelper;

class SeoHelper extends Component
{
    public function getSeoData()
    {
        pre(Yii::$app);

        return [];
    }

    /**
     * @param bool $force
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     * @return void
     */
    public function getSyncData($force = false)
    {
        if($force === true) {
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=0')->execute();
            Yii::$app->db->createCommand()->truncateTable(MetaI18n::tableName())->execute();
            Yii::$app->db->createCommand()->truncateTable(Meta::tableName())->execute();
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=1')->execute();
        }
        $appName = Yii::$app->settings->get(Yii::$app->settings::APP_NAME);

        $pageModels = Page::find()->published()->each(1000);
        $articleModels = Article::find()->published()->each(1000);

        foreach($pageModels as $page) {
            /* @var $page Page */
            $seoData = [
                'route'       => Yii::$app->urlManagerFrontend->createUrl(['/page/view', 'slug' => $page->slug]),
                'title'       => Yii::$app->i18nHelper::getLangAttributeValue($page,'title'),
                'description' => StringHelper::truncate(
                    strip_tags(Yii::$app->i18nHelper::getLangAttributeValue($page,'body')),
                    152,
                    '...',
                    null),
                'keywords' => null
            ];
            self::pushMeta(
                $seoData['route'],
                $seoData['title'],
                [
                    'description' => $seoData['description'],
                    'keywords'    => $seoData['keywords']
                ]
            );
        }

        foreach($articleModels as $article) {
            /* @var $article Article */
            $seoData = [
                'route'       => Yii::$app->urlManagerFrontend->createUrl(['/article/view', 'slug' => $article->slug]),
                'title'       => Yii::$app->i18nHelper::getLangAttributeValue($article,'title'),
                'description' => StringHelper::truncate(
                    strip_tags(Yii::$app->i18nHelper::getLangAttributeValue($article,'announce')),
                    152,
                    '...',
                    null),
                'keywords' => null
            ];
            self::pushMeta(
                $seoData['route'],
                $seoData['title'],
                [
                    'description' => $seoData['description'],
                    'keywords'    => $seoData['keywords']
                ]
            );
        }

        $seoData = [
            'route'       => Yii::$app->urlManagerFrontend->createUrl(['/main/index']),
            'title'       => "Home",
            'description' => 'Private Server Community.',
            'keywords'    => $appName.', WoW, World of Warcraft, Warcraft, Private Server, Private WoW Server, WoW Server, Private WoW Server, wow private server, wow server, wotlk server, best free private server, wotlk private server, anti-cheat, sentinel anti-cheat, warden'
        ];
        self::pushMeta(
            $seoData['route'],
            $seoData['title'],
            [
                'description' => $seoData['description'],
                'keywords'    => $seoData['keywords']
            ]
        );

        $routes[] = Yii::$app->urlManagerFrontend->createUrl(['/auth/sign-in']);
        $routes[] = Yii::$app->urlManagerFrontend->createUrl(['/auth/sign-up']);
        $routes[] = Yii::$app->urlManagerFrontend->createUrl(['/auth/request-password-reset']);
        $routes[] = Yii::$app->urlManagerFrontend->createUrl(['/auth/request-password-reset']);

        $routes[] = Yii::$app->urlManagerFrontend->createUrl(['/ladder']);
    }

    /**
     * @param $route
     * @param $title
     * @param array $params
     * @return bool
     */
    public static function pushMeta($route, $title, $params = [])
    {
        if(!Meta::find()->where(['route' => $route])->exists()) {
            $newMeta = new Meta([
                'route'         => $route,
                'robots_index'  => isset($params['robots_index']) && !empty($params['robots_index']) ? $params['robots_index'] : Meta::INDEX,
                'robots_follow' => isset($params['robots_follow']) && !empty($params['robots_follow']) ? $params['robots_follow'] : Meta::FOLLOW,
                'title'         => $title,
                'description'   => isset($params['description']) && !empty($params['description']) ? $params['description'] : '',
                'keywords'      => isset($params['keywords']) && !empty($params['keywords']) ? $params['keywords'] : ''
            ]);

            return $newMeta->save();
        }

        return false;
    }
}