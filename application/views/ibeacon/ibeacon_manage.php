<legend>
    iBeacon 管理
    <button id="add_ibeacon_btn" type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal">新增iBeacon</button>
</legend>
<div id="sec_list_block">
<?= $this->table->generate($ibeacons); ?>
</div>
<?php $this->table->clear(); ?>

<table id="ibeacon_list" data-toggle="table" data-striped="true">
    <thead>
        <tr>
            <th>ID</th>
            <th>UUID</th>
            <th>Major</th>
            <th>Minor</th>
            <th>狀態</th>
            <th class="col-lg-2 col-md-2 col-sm-3 com-xs-3">管理</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>B13C4534-F5F8-466E-11F9-25123B57FE6D</td>
            <td>1</td>
            <td>12</td>
            <td>與「清院本清明上河圖」展品連結中</td>
            <td>
                <a href="/iBeaGuide/ibeacons/edit" class="btn btn-default">編輯</a>
                <a href="/iBeaGuide/ibeacons/delete" class="btn btn-default">刪除</a>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>B9407F30-F5F8-423E-ECF9-25556B57FE70</td>
            <td>2</td>
            <td>20</td>
            <td>與「菜單塗鴉餐」展品連結中</td>
            <td>
                <a href="/iBeaGuide/ibeacon/edit" class="btn btn-default">編輯</a>
                <a href="/iBeaGuide/ibeacons/delete" class="btn btn-default">刪除</a>
            </td>
        </tr>
        <tr>
            <td>3</td>
            <td>A1EC5830-F5F8-4678-A672-2555AC68FE38</td>
            <td>2</td>
            <td>20</td>
            <td>位於「古畫動漫：清院本清明上河圖」入口推播歡迎訊息</td>
            <td>
                <a href="/iBeaGuide/ibeacons/edit" class="btn btn-default">編輯</a>
                <a href="/iBeaGuide/ibeacons/delete" class="btn btn-default">刪除</a>
            </td>
        </tr>
    </tbody>
</table>

<script type="text/javascript">
    $(document.body).off('click.add_ibeacon', '#add_ibeacon_btn');
    $(document.body).on('click.add_ibeacon', '#add_ibeacon_btn', function() {

        $.ajax({
            url: 'getCreateIbeaconModalFormAction',
            type: "GET",
            data: {
                // exh_id: $(this).attr('data-exh-id')
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
</script>
