<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;

?>
<footer class="footer">
    <div class="container">
        <p class="flaot-left">&copy; <?= Podium::getInstance()->podiumConfig->get('name') ?> <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>
