<?php

use core\modules\forum\Podium;
use yii\helpers\Html;

$this->registerJs("$('[data-toggle=\"tooltip\"]').tooltip();");

?>

<div class="card">
    <div class="card-body">
        <div class="row podium-post" id="post<?php echo $model->id; ?>">
            <div class="col-sm-2" id="postAvatar<?php echo $model->id; ?>">
                <div class="position-relative">
                    <input type="hidden" name="post[<?=$model->id?>]" value="0">
                    <input type="checkbox" id="select-post-<?=$model->id?>" name="post[<?=$model->id?>]" value="<?=$model->id?>">
                    <label class="checkbox-label" for="select-post-<?=$model->id?>">
                        <?=Yii::t('podium/view', 'Select this post')?>
                    </label>
                </div>
            </div>
            <div class="col-sm-10" id="postContent<?php echo $model->id; ?>">
                <div class="card">
                    <div class="card-header">
                        <small>
                            <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($model->created_at, 'long'); ?>">
                                <?php echo Podium::getInstance()->formatter->asRelativeTime($model->created_at); ?>
                            </span>
                            <?php if ($model->edited && $model->edited_at): ?>
                                <em>(<?php echo Yii::t('podium/view', 'Edited'); ?> <span data-toggle="tooltip" data-placement="top" title="<?php echo Podium::getInstance()->formatter->asDatetime($model->edited_at, 'long'); ?>"><?php echo Podium::getInstance()->formatter->asRelativeTime($model->edited_at); ?>)</span></em>
                            <?php endif; ?>
                        </small>
                        <?php echo $model->author->podiumTag; ?>
                        <small>
                            <span class="label text-info" data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('podium/view', 'Number of posts'); ?>"><?php echo $model->author->postsCount; ?></span>
                        </small>
                    </div>
                    <div class="card-body podium-content">
                        <?php echo $model->parsedContent; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>