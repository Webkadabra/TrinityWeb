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
                        <?php echo $module['label'];?>
                    </h5>
                    <div class="position-relative">
                        <input type="hidden" name="Module[<?php echo $key;?>][hidden]" value="<?php echo time();?>">
                        <input type="checkbox" id="Module_<?php echo $key;?>_status" name="Module[<?php echo $key;?>][status]" value="<?php echo $module['fields']['status'];?>" <?php echo ($module['fields']['status'] ? 'checked' : '');?>>
                        <label class="checkbox-label" for="Module_<?php echo $key;?>_status">
                            <?php echo Yii::t('backend','Статус');?>
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
                                        <?php echo Yii::t('backend','per-page');?>
                                    </label>
                                    <div class="form-group">
                                        <i class="fas fa-copy input-icon"></i>
                                        <input type="text" value="<?php echo $module['fields']['per-page'];?>" class="form-control parent-input-icon" name="Module[<?php echo $key;?>][per-page]">
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
                                        <?php echo Yii::t('backend','Cache duration');?>
                                    </label>
                                    <div class="form-group">
                                        <i class="fas fa-clock input-icon"></i>
                                        <input type="text" value="<?php echo $module['fields']['cache_duration'];?>" class="form-control parent-input-icon" name="Module[<?php echo $key;?>][cache_duration]">
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
                        <?php echo Yii::t('backend',$module['description']);?>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>