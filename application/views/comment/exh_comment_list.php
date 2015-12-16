<legend>
    <?= $title ?>
</legend>
<div id="comment_list_block">
    <?= $this->table->generate($comments); ?>
</div>
<?php $this->table->clear(); ?>

<script type="text/javascript">
    $('#comment_list_block').ready(function() {

        $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding','8px');

        $(document).pjax('a[data-pjax]', '#pjax-container');
        $(document).on('pjax:complete', function() {
            $('[data-toggle="table"]').bootstrapTable();
            $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding','8px');
        });

    });
</script>
