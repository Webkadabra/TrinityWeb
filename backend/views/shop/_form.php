<?php
use trntv\yii\datetime\DateTimeWidget;
?>
<div class="row">
    <div class="col-md-3">
        <?=$form->field($node, 'discount')->textInput(['placeholder' => Yii::t('app','% скидки')])?>
    </div>
    <div class="col-md-3">
        <?=$form->field($node,'discount_end')->widget(DateTimeWidget::className(),
            [
                'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ',
                'options' => [
                    'placeholder' => Yii::t('app','Дата окончания'),
                ]
            ]
        );?>
    </div>
</div>
