<table class="table table-hover">
    <?= $this->render('/elements/forum/_thread_header') ?>
    <?= $this->render('/elements/members/_thread_list', ['id' => $id]) ?>
</table>
