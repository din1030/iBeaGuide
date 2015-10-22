<legend>
    展覽管理
    <button id="add-exh-btn" type="button" class="btn btn-primary btn-xs pull-right">
        新增展覽
    </button>
</legend>
<div id="exh_form_block"></div>
<div id="exh_list_block">
    <?= $this->table->generate($exhibitions); ?>
</div>
<?php $this->table->clear(); ?>

<script type="text/javascript">
    $(document.body).off('click.add_exh_form', '#add-exh-btn');
    $(document.body).on('click.add_exh_form', '#add-exh-btn', function() {
        $.ajax({
            url: '/iBeaGuide/exhibitions/get_exh_add_form',
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

    $(document.body).off('click.edit_exh_form', '.edit-exh-btn');
    $(document.body).on('click.edit_exh_form', '.edit-exh-btn', function() {
        $.ajax({
            url: '/iBeaGuide/exhibitions/get_exh_edit_form',
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
                $('#system-message').html('完成');
                $('#system-message').fadeOut();
                $.scrollTo($('#add-exh-btn'), 500, {offset: -10});
            }
        });
    });

    $(document.body).off('click.delete_exh', '.del-exh-btn');
    $(document.body).on('click.delete_exh', '.del-exh-btn', function() {
        var this_exh_id = $(this).attr('data-exh-id');
        var this_exh_title = $(this).parent().parent().children('td').eq(1).html();
        BootstrapDialog.show({
            title: '注意！',
            message: '刪除展覽資訊會將所屬展區一併刪除，是否確認刪除「' + this_exh_title + '」展覽資訊？',
            buttons: [{
                label: '取消',
                action: function(dialogRef){
                    dialogRef.close();
                }
            }, {
                label: '確認',
                cssClass: 'btn-danger',
                action: function(dialogRef) {
                    $.ajax({
                        url: '/iBeaGuide/exhibitions/delete_exhibition_action',
                        type: "POST",
                        //cache: false,
                        data: {
                            exh_id: this_exh_id
                        },
                        dataType: "html",
                        beforeSend: function(xhr) {
                            dialogRef.close();
                            $('#system-message').html('處理中...');
                            $('#system-message').show();
                        },
                        success: function(html_block) {
                            $('#exh_list_block').html(html_block);
                            // $.scrollTo($('#add_exh_btn'), 500, {offset: -10});
                            $('#system-message').html('完成');
                            $('#system-message').fadeOut();
                            $('[data-toggle="table"]').bootstrapTable();
                        }
                    });
                }
            }]
        });
    });
</script>
