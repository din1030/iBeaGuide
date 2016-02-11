<legend>
    留言管理
</legend>
<div id="exh_list_block">
    <?= $this->table->generate($exhibitions); ?>
</div>
<?php $this->table->clear(); ?>

<script type="text/javascript">
    $(document).ready(function() {

        $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding','8px');
        $.pjax.defaults.timeout = 5000
        $(document).pjax('a[data-pjax]', '#pjax-container');
        $(document).on('pjax:complete', function() {
            $('[data-toggle="table"]').bootstrapTable();
            $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding','8px');
        });

    });
</script>
