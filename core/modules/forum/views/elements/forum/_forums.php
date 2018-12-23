<table class="table table-dark table-hover">
    <thead>
        <?php echo $this->render('/elements/forum/_forum_header'); ?>
    </thead>
    <tbody>
        <?php echo $this->render('/elements/forum/_forum_list', ['category' => $category]); ?>
    </tbody>
</table>
