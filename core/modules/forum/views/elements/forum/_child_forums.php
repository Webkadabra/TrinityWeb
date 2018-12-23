<table class="table table-hover">
    <?php echo $this->render('/elements/forum/_forum_header'); ?>
    <?php echo $this->render('/elements/forum/_child_list', ['parent_id' => $parent_id]); ?>
</table>
