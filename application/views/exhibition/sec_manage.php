<legend>
    「<?= $exhibition->title ?>」：展區管理
    <button id="add_section_btn" type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-exh-id="<?= $exhibition->id ?>">新增展區</button>
</legend>
<div id="sec_list_block">
<?= $this->table->generate($sections); ?>
</div>
<?php $this->table->clear(); ?>

<script>
    $(document.body).off('click.add_section', '#add_section_btn');
    $(document.body).on('click.add_section', '#add_section_btn', function() {

        $.ajax({
            url: 'getCreateSectionModalFormAction',
            type: "GET",
            data: {
                exh_id: $(this).attr('data-exh-id')
            },
            dataType: "html",
            beforeSend: function(xhr) {
                $('#system-message').html('處理中...');
                $('#system-message').show();
            },
            success: function(html_block) {
                $('#iBeaGuide-modal-block').html(html_block);
                $('#iBeaGuide-modal').modal('show');
                $('#system-message').html('完成');
                $('#system-message').fadeOut();
            }
        });

    });
    $(document.body).off('click.edit_section', '.edit-section-btn');
    $(document.body).on('click.edit_section', '.edit-section-btn', function() {

        $.ajax({
            url: 'getEditSectionModalFormAction',
            type: "GET",
            data: {
                sec_id: $(this).attr('data-sec-id')
            },
            dataType: "html",
            beforeSend: function(xhr) {
                $('#system-message').html('處理中...');
                $('#system-message').show();
            },
            success: function(html_block) {
                $('#iBeaGuide-modal-block').html(html_block);
                $('#iBeaGuide-modal').modal('show');
                $('#system-message').html('完成');
                $('#system-message').fadeOut();
            }
        });

    });

    $(document.body).off('click.delete_sec', '.del-section-btn');
    $(document.body).on('click.delete_sec', '.del-section-btn', function() {
        var this_sec_id = $(this).attr('data-sec-id');
        BootstrapDialog.show({
            title: '注意！',
            message: '是否刪除此展區？',
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
                        url: '/iBeaGuide/exhibitions/deleteSectionAction',
                        type: "POST",
                        //cache: false,
                        data: {
                            sec_id: this_sec_id,
                            exh_id: '<?= $exhibition->id ?>'
                        },
                        dataType: "html",
                        beforeSend: function(xhr) {
                            dialogRef.close();
                            $('#system-message').html('處理中...');
                            $('#system-message').show();
                        },
                        success: function(html_block) {
                            $('#sec_list_block').html(html_block);
                            // $.scrollTo($('#add_sec_btn'), 500, {offset: -10});
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
