<legend>
    路線管理
    <button id="add_route_btn" type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal">新增路線</button>
</legend>
<div id="route_form_block"></div>
<div id="route_list_block">
<?= $this->table->generate($routes); ?>
</div>
<?php $this->table->clear(); ?>
<script type="text/javascript">
    $("#route_list").bootstrapTable({
        sortName: "1"
    });

    $(document.body).off('click.add_route_form', '#add_route_btn');
    $(document.body).on('click.add_route_form', '#add_route_btn', function() {
        $.ajax({
            url: 'routes/get_route_add_form',
            type: "GET",
            //cache: false,
            data: {},
            dataType: "html",
            beforeSend: function(xhr) {
                $('#system-message').html('處理中...');
                $('#system-message').show();
            },
            success: function(html_block) {
                $('#route_form_block').html(html_block);
                $('#system-message').html('完成');
                $('#system-message').fadeOut();
            }
        });
    });

    $(document.body).off('click.edit_route_form', '.edit-route-btn');
    $(document.body).on('click.edit_route_form', '.edit-route-btn', function() {
        $.ajax({
            url: 'routes/get_route_edit_form',
            type: "GET",
            //cache: false,
            data: {
                route_id: $(this).attr('data-route-id')
            },
            dataType: "html",
            beforeSend: function(xhr) {
                $('#system-message').html('處理中...');
                $('#system-message').show();
            },
            success: function(html_block) {
                $('#route_form_block').html(html_block);
                $('#system-message').html('完成');
                $('#system-message').fadeOut();
                $.scrollTo($('#add-route-btn'), 500, {offset: -10});
            }
        });
    });
    $(document.body).off('click.delete_route', '.del-route-btn');
    $(document.body).on('click.delete_route', '.del-route-btn', function() {
        var this_route_id = $(this).attr('data-route-id');
        var this_route_title = $(this).parent().parent().children('td').eq(1).html();
        BootstrapDialog.show({
            title: '注意！',
            message: '是否刪除「' + this_route_title + '」路線？',
            buttons: [{
                label: '取消',
                action: function(dialogRef){
                    dialogRef.close();
                }
            }, {
                label: '刪除',
                cssClass: 'btn-danger',
                action: function(dialogRef) {
                    $.ajax({
                        url: '/iBeaGuide/routes/delete_route_action',
                        type: "POST",
                        //cache: false,
                        data: {
                            route_id: this_route_id
                        },
                        dataType: "html",
                        beforeSend: function(xhr) {
                            dialogRef.close();
                            $('#system-message').html('處理中...');
                            $('#system-message').show();
                        },
                        success: function(html_block) {
                            $('#route_list_block').html(html_block);
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
