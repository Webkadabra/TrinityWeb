<table class="table table-hover mb-0">
    <thead>
        <?= $this->render('/elements/forum/_forum_header') ?>
    </thead>
    <tbody>
        <?= $this->render('/elements/forum/_forum_list', ['category' => $category]) ?>
    </tbody>
</table>
