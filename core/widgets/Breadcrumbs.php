<?php

namespace core\widgets;

use yii\widgets\Breadcrumbs as SystemBreadctrumbs;

class Breadcrumbs extends SystemBreadctrumbs {
    public $itemTemplate = "<li class=\"breadcrumb-item\">{link}</li>\n";
    public $activeItemTemplate = "<li class=\"breadcrumb-item active\">{link}</li>\n";
}