<table class="table table-hover">
    <?php echo $this->render('/elements/forum/_thread_header'); ?>
    <?php echo $this->render('/elements/members/_thread_list', ['id' => $id]); ?>
</table>
