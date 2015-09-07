<legend>
    設施管理
    <button id="add_fac_btn" type="button" class="btn btn-primary btn-xs pull-right">新增設施</button>
    <!-- <a href="/iBeaGuide/facilities/add" class="btn btn-primary btn-xs pull-right">新增設施</a> -->
</legend>
<div id="fac_form_block"></div>
<div id="fac_list_block">
<?= $this->table->generate($facilities); ?>
</div>
<?php $this->table->clear(); ?>

<script type="text/javascript">
    $(document.body).off('click.add_fac_form', '#add_fac_btn');
    $(document.body).on('click.add_fac_form', '#add_fac_btn', function() {
        $.ajax({
            url: '/iBeaGuide/facilities/add',
            type: "GET",
            //cache: false,
            data: {},
            dataType: "html",
            beforeSend: function(xhr) {
                $('#system-message').html('處理中...');
                $('#system-message').show();
            },
            success: function(html_block) {
                $('#fac_form_block').html(html_block);
                $('#system-message').html('完成');
                $('#system-message').fadeOut();
            }
        });
    });

    $(document.body).off('click.edit_fac_form', '.edit_fac_btn');
    $(document.body).on('click.edit_fac_form', '.edit_fac_btn', function() {
        $.ajax({
            url: '/iBeaGuide/facilities/edit',
            type: "GET",
            //cache: false,
            data: {
                fac_id: $(this).attr('data-fac-id')
            },
            dataType: "html",
            beforeSend: function(xhr) {
                $('#system-message').html('處理中...');
                $('#system-message').show();
            },
            success: function(html_block) {
                $('#fac_form_block').html(html_block);
                $.scrollTo($('#add_fac_btn'), 500, {offset: -10});
                $('#system-message').html('完成');
                $('#system-message').fadeOut();
            }
        });
    });


    $(document.body).off('click.delete_fac', '.del_fac_btn');
    $(document.body).on('click.delete_fac', '.del_fac_btn', function() {
        var this_fac_id = $(this).attr('data-fac-id');
        BootstrapDialog.show({
            title: '注意！',
            message: '是否刪除此設施資訊？',
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
                        url: '/iBeaGuide/facilities/deleteFacilityAction',
                        type: "POST",
                        //cache: false,
                        data: {
                            fac_id: this_fac_id
                        },
                        dataType: "html",
                        beforeSend: function(xhr) {
                            dialogRef.close();
                            $('#system-message').html('處理中...');
                            $('#system-message').show();
                        },
                        success: function(html_block) {
                            $('#fac_list_block').html(html_block);
                            // $.scrollTo($('#add_fac_btn'), 500, {offset: -10});
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
