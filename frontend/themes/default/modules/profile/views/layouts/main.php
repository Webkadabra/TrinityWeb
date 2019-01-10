<?php

use core\modules\forum\widgets\Friends;

/* @var $content string */
/* @var $this \yii\web\View */

$this->beginContent('@frontend/views/layouts/base.php');
?>
    <div class="container mih-100">
        <div class="fix-header">
        </div>
        <?=$this->render('_panel_head')?>
        <div class="row mih-100">
            <div class="col-12 h-100">
                <div class="row mt-3">
                    <div class="col-12 col-md-3">
                        <?=Friends::widget()?>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $content;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>