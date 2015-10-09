<legend>
    展品管理
    <button id="add-item-btn" type="button" class="btn btn-primary btn-xs pull-right">
        新增展品
    </button>
</legend>
<div id="item_form_block"></div>
<div id="item_list_block">
    <!-- < $this->table->generate($items); ?> -->
</div>
<table id="item_list" data-toggle="table" data-striped="true">
    <thead>
        <tr>
            <th>ID</th>
            <th>展品名稱</th>
            <th>展覽狀態</th>
            <th>連結 iBeacon</th>
            <th>管理</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>清院本清明上河圖</td>
            <td>展於「古畫動漫」之「古畫」展區</td>
            <td>Estimote-1</td>
            <td>
                <a href="/iBeaGuide/items/edit" class="btn btn-default">編輯</a>
                <a href="/iBeaGuide/items/delete" class="btn btn-default">刪除</a>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>菜單塗鴉餐</td>
            <td>展於「食物箴言：思想與食物」</td>
            <td>未連結</td>
            <td>
                <a href="/iBeaGuide/items/edit" class="btn btn-default">編輯</a>
                <a href="/iBeaGuide/items/delete" class="btn btn-default">刪除</a>
            </td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
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
            url: '/iBeaGuide/items/get_item_edit_form',
            type: "GET",
            //cache: false,
            data: {
                item_id: $(this).attr('data-item-id')
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
        BootstrapDialog.show({
            title: '注意！',
            message: '刪除展覽資訊會將所屬展區一併刪除，是否確認刪除此展覽？',
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
                        url: '/iBeaGuide/items/delete_itemibition_action',
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
