<legend>
    iBeacon 管理
    <button id="add_ibeacon_btn" type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal">新增iBeacon</button>
</legend>
<div id="ibeacon_list_block">
<?= $this->table->generate($ibeacons); ?>
</div>
<?php $this->table->clear(); ?>

<script type="text/javascript">
    $(document.body).off('click.add_ibeacon', '#add_ibeacon_btn');
    $(document.body).on('click.add_ibeacon', '#add_ibeacon_btn', function() {

        $.ajax({
            url: '/iBeaGuide/ibeacons/get_ibeacon_add_modal_form',
            type: "GET",
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

    $(document.body).off('click.edit_ibeacon', '.edit-ibeacon-btn');
    $(document.body).on('click.edit_ibeacon', '.edit-ibeacon-btn', function() {
        var this_ibeacon_id = $(this).attr('data-ibeacon-id');
        $.ajax({
            url: '/iBeaGuide/ibeacons/get_ibeacon_edit_modal_form/' + this_ibeacon_id,
            type: "GET",
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

    $(document.body).off('click.delete_ibeacon', '.del-ibeacon-btn');
    $(document.body).on('click.delete_ibeacon', '.del-ibeacon-btn', function() {
        var this_ibeacon_id = $(this).attr('data-ibeacon-id');
        BootstrapDialog.show({
            title: '注意！',
            message: '是否刪除此iBeacon裝置？',
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
                        url: '/iBeaGuide/ibeacons/delete_ibeacon_action',
                        type: "POST",
                        //cache: false,
                        data: {
                            ibeacon_id: this_ibeacon_id
                        },
                        dataType: "html",
                        beforeSend: function(xhr) {
                            dialogRef.close();
                            $('#system-message').html('處理中...');
                            $('#system-message').show();
                        },
                        success: function(html_block) {
                            $('#ibeacon_list_block').html(html_block);
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
