<legend>
    展品管理
    <button id="add-item-btn" type="button" class="btn btn-primary btn-xs pull-right">
        新增展品
    </button>
</legend>
<div id="item_form_block"></div>
<div id="item_list_block">
    <?= $this->table->generate($items); ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding','8px');

        $(document.body).off('click.add_item_form', '#add-item-btn');
        $(document.body).on('click.add_item_form', '#add-item-btn', function() {
            $.ajax({
                url: '/iBeaGuide/items/get_item_add_form',
                type: "GET",
                //cache: false,
                data: {},
                dataType: "html",
                beforeSend: function(xhr) {
                    $('#system-message').html('處理中...');
                    $('#system-message').show();
                },
                success: function(html_block) {
                    $('#item_form_block').html(html_block);
                    $('#system-message').html('完成');
                    $('#system-message').fadeOut();
                }
            });
        });

        $(document.body).off('click.edit_item_form', '.edit-item-btn');
        $(document.body).on('click.edit_item_form', '.edit-item-btn', function() {
            $.ajax({
                url: '/iBeaGuide/items/get_item_edit_form/' + $(this).attr('data-item-id'),
                type: "GET",
                //cache: false,
                data: {
                    // item_id: $(this).attr('data-item-id')
                },
                dataType: "html",
                beforeSend: function(xhr) {
                    $('#system-message').html('處理中...');
                    $('#system-message').show();
                },
                success: function(html_block) {
                    $('#item_form_block').html(html_block);
                    $('#system-message').html('完成');
                    $('#system-message').fadeOut();
                    $.scrollTo($('#add-item-btn'), 500, {offset: -10});
                }
            });
        });

        $(document.body).off('click.delete_item', '.del-item-btn');
        $(document.body).on('click.delete_item', '.del-item-btn', function() {
            var this_item_id = $(this).attr('data-item-id');
            var this_item_title = $(this).parent().parent().children('td').eq(1).html();
            BootstrapDialog.show({
                title: '注意！',
                message: '是否確認刪除「' + this_item_title + '」展品資訊？',
                buttons: [{
                    label: '取消',
                    action: function(dialogRef){
                        dialogRef.close();
                    }
                },
                {
                    label: '刪除',
                    cssClass: 'btn-danger',
                    action: function(dialogRef) {
                        $.ajax({
                            url: '/iBeaGuide/items/delete_item_action',
                            type: "POST",
                            //cache: false,
                            data: {
                                item_id: this_item_id
                            },
                            dataType: "html",
                            beforeSend: function(xhr) {
                                dialogRef.close();
                                $('#system-message').html('處理中...');
                                $('#system-message').show();
                            },
                            success: function(html_block) {
                                $('#item_list_block').html(html_block);
                                // $.scrollTo($('#add_item_btn'), 500, {offset: -10});
                                $('#item_form_block').empty();
                                $('#system-message').html('完成');
                                $('#system-message').fadeOut();
                                $('[data-toggle="table"]').bootstrapTable();
                                $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding', '8px');
                            }
                        });
                    }
                }]
            });
        });

    });
</script>
