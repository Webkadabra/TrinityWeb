<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?php echo Yii::t('podium/view', 'Edit Poll'); ?></strong>
    </div>
    <div class="panel-body">
        <?php echo $this->render('_form', [
            'form'         => $form,
            'model'        => $model,
            'pollQuestion' => 'question',
            'pollVotes'    => 'votes',
            'pollHidden'   => 'hidden',
            'pollEnd'      => 'end',
            'pollAnswers'  => 'editAnswers',
        ]); ?>
    </div>
</div>
