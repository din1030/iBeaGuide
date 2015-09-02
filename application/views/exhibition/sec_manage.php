<legend>
    「<?= $exhibition->title ?>」：展區管理
    <button id="add-section-btn" type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal">新增展區</button>
    <!-- <a href="/iBeaGuide/sections/add" class="btn btn-primary btn-xs pull-right">新增展區</a> -->
</legend>
<!-- <table id="fac_list" data-toggle="table" data-striped="true">
    <thead>
        <tr>
            <th>ID</th>
            <th>展區名稱</th>
            <th>展區介紹</th>
            <th>管理</th>
        </tr>
    </thead>
    <tbody> -->
        <!-- <tr>
            <td>1</td>
            <td>濕滑特區</td>
            <td>又濕又滑</td>
            <td>
                <a href="/iBeaGuide/sections/edit" class="btn btn-default">編輯</a>
                <a href="/iBeaGuide/sections/delete" class="btn btn-default">刪除</a>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>行一特區</td>
            <td>型一誤差</td>
            <td>
                <a href="/iBeaGuide/sections/edit" class="btn btn-default">編輯</a>
                <a href="/iBeaGuide/sections/delete" class="btn btn-default">刪除</a>
            </td>
        </tr> -->
    <!-- </tbody>
</table> -->
<?= $this->table->generate($sections); ?>
<?php $this->table->clear(); ?>
<script>
    // $('.header').ready(function() {

        $(document.body).off('click.add_section', '#add-section-btn');
        $(document.body).on('click.add_section', '#add-section-btn', function() {

            $.ajax({
                url: 'getCreateSectionModalFormAction',
                type: "GET",
                data: {
                    // user_id: $('#user-id').val()
                },
                dataType: "html",
                beforeSend: function(xhr) {
                    $('#system-message').html('處理中...');
                    $('#system-message').show();
                },
                success: function(html_block) {
                    // $(html_block).appendTo("body").modal('show');
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
                    sec_id: $(this).attr('data-id')
                },
                dataType: "html",
                beforeSend: function(xhr) {
                    $('#system-message').html('處理中...');
                    $('#system-message').show();
                },
                success: function(html_block) {
                    // $(html_block).appendTo("body").modal('show');
                    $('#iBeaGuide-modal-block').html(html_block);
                    $('#iBeaGuide-modal').modal('show');
                    $('#system-message').html('完成');
                    $('#system-message').fadeOut();
                }
            });

        });
    // });
</script>
