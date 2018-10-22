<?php

use Sitemaped\Sitemap;

return [
    'class' => yii\web\UrlManager::class,
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        //Main page
        ['pattern' => '/', 'route' => 'main/index'],
        //Articles
        ['pattern' => 'article/attachment-download', 'route' => 'article/attachment-download'],
        ['pattern' => 'article/<slug>', 'route' => 'article/view'],
        // Sitemap
        ['pattern' => 'sitemap.xml', 'route' => 'main/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_XML]],
        ['pattern' => 'sitemap.txt', 'route' => 'main/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_TXT]],
        ['pattern' => 'sitemap.xml.gz', 'route' => 'main/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_XML, 'gzip' => true]],
    ]
];
