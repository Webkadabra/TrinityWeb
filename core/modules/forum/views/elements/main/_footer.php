<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\Podium;

?>
<footer class="footer">
    <div class="container">
        <p class="flaot-left">&copy; <?php echo Podium::getInstance()->podiumConfig->get('forum.name'); ?> <?php echo date('Y'); ?></p>
        <p class="float-right"><?php echo Yii::powered(); ?></p>
    </div>
</footer>
