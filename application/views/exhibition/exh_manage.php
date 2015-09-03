<legend>
    展覽管理
    <button id="add_exh_btn" type="button" class="btn btn-primary btn-xs pull-right">
        新增展覽
    </button>
    <!-- <a href="/iBeaGuide/exhibitions/add" class="btn btn-primary btn-xs pull-right">新增展覽</a> -->
</legend>
<div id="exh_form_block"></div>

<?= $this->table->generate($exhibitions); ?>
<?php $this->table->clear(); ?>

<script type="text/javascript">
    $(document.body).off('click.add_exh_form', '#add_exh_btn');
    $(document.body).on('click.add_exh_form', '#add_exh_btn', function() {
        $.ajax({
            url: '/iBeaGuide/exhibitions/add',
            type: "GET",
            //cache: false,
            data: {},
            dataType: "html",
            beforeSend: function(xhr) {
                $('#system-message').html('處理中...');
                $('#system-message').show();
            },
            success: function(html_block) {
                $('#exh_form_block').html(html_block);
                $('#system-message').html('完成');
                $('#system-message').fadeOut();
            }
        });
    });

    $(document.body).off('click.edit_exh_form', '.edit_exh_btn');
    $(document.body).on('click.edit_exh_form', '.edit_exh_btn', function() {
    $.ajax({
        url: '/iBeaGuide/exhibitions/edit',
        type: "GET",
        //cache: false,
        data: {
            exh_id: $(this).attr('data-exh-id')
        },
        dataType: "html",
        beforeSend: function(xhr) {
            $('#system-message').html('處理中...');
            $('#system-message').show();
        },
        success: function(html_block) {
            $('#exh_form_block').html(html_block);
            $.scrollTo($('#add_exh_btn'), 500, {offset: -10});
            $('#system-message').html('完成');
            $('#system-message').fadeOut();
        }
    });
    });


</script>
