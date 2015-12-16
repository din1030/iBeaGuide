<legend>
    路線管理
    <button id="add-route-btn" type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal">新增路線</button>
</legend>
<div id="route_form_block"></div>
<div id="route_list_block">
    <?= $this->table->generate($routes); ?>
</div>
<?php $this->table->clear(); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding','8px');

        $("#route_list").bootstrapTable({
            sortName: "1"
        });

        $(document.body).off('click.add_route_form', '#add-route-btn');
        $(document.body).on('click.add_route_form', '#add-route-btn', function() {
            BootstrapDialog.show({
                title: '請選擇新增路線所屬之展覽',
                message: function(dialog) {
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad);

                    return $message;
                },
                data: {
                    'pageToLoad': '/iBeaGuide/exhibitions/print_exh_menu'
                },
                buttons: [{
                    label: '取消',
                    action: function(dialogRef){
                        dialogRef.close();
                    }
                },
                {
                    label: '確定',
                    cssClass: 'btn-primary',
                    action: function(dialogRef) {
                        dialogRef.close();
                        $.ajax({
                            url: '/iBeaGuide/routes/get_route_add_form',
                            type: "GET",
                            //cache: false,
                            data: {
                                exh_id: $('#exh_menu').val()
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
                            }
                        });
                    }
                }]
            });
        });

        $(document.body).off('click.edit_route_form', '.edit-route-btn');
        $(document.body).on('click.edit_route_form', '.edit-route-btn', function() {
            $.ajax({
                url: '/iBeaGuide/routes/get_route_edit_form',
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

    });
</script>
