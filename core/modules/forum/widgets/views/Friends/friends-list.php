<div class="card">
    <div class="card-header">
        <?=Yii::t('forum','Online Friends')?>
    </div>
    <div class="card-body">
        <?php
        foreach($friends as $friend) {
            ?>
            <div><?=$friend?></div>
            <?php
        }
        ?>
    </div>
</div>