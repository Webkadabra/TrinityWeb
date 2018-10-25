<?php
/**
 * @var $model \backend\modules\system\models\SettingsModel
 * @var $this \yii\web\View
 */
?>
<div class="row justify-content-center">
    <?php
    foreach($model->modules as $key => $module) {
        ?>
        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <?=$module['label']?>
                    </h5>
                    <div class="position-relative">
                        <input type="checkbox" id="Module_<?=$key?>_status" name="Module[<?=$key?>][status]" value="<?=$module['fields']['status']?>" <?=($module['fields']['status'] ? 'checked' : '')?>>
                        <label class="checkbox-label" for="Module_<?=$key?>_status">
                            <?=Yii::t('backend','Статус')?>
                        </label>
                    </div>
                    <?php
                    if(isset($module['fields']['per-page']) || isset($module['fields']['cache_duration'])) {
                        ?>
                        <div class="row">
                            <?php
                            if(isset($module['fields']['per-page'])) {
                                ?>
                                <div class="col-6">
                                    <label class="form-check-label">
                                        <?=Yii::t('backend','per-page')?>
                                    </label>
                                    <div class="form-group">
                                        <i class="fas fa-copy input-icon"></i>
                                        <input type="text" value="<?=$module['fields']['per-page']?>" class="form-control parent-input-icon" name="Module[<?=$key?>][per-page]">
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if(isset($module['fields']['cache_duration'])) {
                                ?>
                                <div class="col-6">
                                    <label class="form-check-label">
                                        <?=Yii::t('backend','Cache duration')?>
                                    </label>
                                    <div class="form-group">
                                        <i class="fas fa-clock input-icon"></i>
                                        <input type="text" value="<?=$module['fields']['cache_duration']?>" class="form-control parent-input-icon" name="Module[<?=$key?>][cache_duration]">
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <p class="card-text">
                        <?=Yii::t('backend',$module['description'])?>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>