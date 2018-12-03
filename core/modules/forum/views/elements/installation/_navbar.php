<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use yii\bootstrap\NavBar;

?>
<?php NavBar::begin([
    'brandLabel'            => 'Podium',
    'brandUrl'              => ['forum/index'],
    'options'               => ['class' => 'navbar-inverse navbar-default',],
    'innerContainerOptions' => ['class' => 'container-fluid',]
]);
NavBar::end();
