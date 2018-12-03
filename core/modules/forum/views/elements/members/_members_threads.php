<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            <?= Yii::t('podium/view', 'Threads started by {name}', ['name' => $user->podiumName]) ?>
        </h4>
    </div>
    <div class="card-body">
        <?= $this->render('/elements/members/_threads', ['id' => $user->id]) ?>
    </div>
</div>

<div class="card">
    <div class="card-body small">
        <?= $this->render('/elements/forum/_icons') ?>
    </div>
</div>
