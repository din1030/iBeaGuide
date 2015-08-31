<legend>
    展覽管理
    <a href="/iBeaGuide/exhibitions/add" class="btn btn-primary btn-xs pull-right">新增展覽</a>
</legend>
<table id="exh_list" data-toggle="table" data-striped="true">
    <thead>
        <tr>
            <th>ID</th>
            <th>展覽名稱</th>
            <th>展場</th>
            <th>開始日期</th>
            <th>結束日期</th>
            <th>管理</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>古畫動漫：清院本清明上河圖</td>
            <td>國立故宮博物院 展覽區102</td>
            <td>2015/01/01</td>
            <td>2015/04/30</td>
            <td>
                <a href="/iBeaGuide/exhibitions/edit" class="btn btn-default">編輯</a>
                <a href="/iBeaGuide/exhibitions/delete" class="btn btn-default">刪除</a>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>食物箴言：思想與食物</td>
            <td>台北市立美術館 一樓1A~1B</td>
            <td>2015/02/07</td>
            <td>2015/05/03</td>
            <td>
                <button id="add-section-btn" type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">建立展區</button>
                <a href="/iBeaGuide/exhibitions/edit" class="btn btn-default">編輯</a>
                <a href="/iBeaGuide/exhibitions/delete" class="btn btn-default">刪除</a>
            </td>
        </tr>
    </tbody>
</table>
<script>
    // $(document).ready(function() {

        $(document.body).off('click.add_section', '#add-section-btn');
        $(document.body).on('click.add_section', '#add-section-btn', function() {

            $.ajax({
                url: 'exhibitions/getCreateSectionModalFormAction',
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
    // });
</script>
