<h4>
    iBeacon 列表
</h4>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>UUID</th>
            <th>Major</th>
            <th>Minor</th>
            <th>狀態</th>
            <th class="col-lg-2 col-md-2 col-sm-3 com-xs-3">管理</th>
        </tr>
    </thead>
    <tr>
        <th>B13C4534-F5F8-466E-11F9-25123B57FE6D</th>
        <th>1</th>
        <th>12</th>
        <th>與「清院本清明上河圖」展品連結中</th>
        <th>編輯｜刪除</th>
    </tr>
    <tr>
        <th>B9407F30-F5F8-423E-ECF9-25556B57FE70</th>
        <th>2</th>
        <th>20</th>
        <th>與「菜單塗鴉餐」展品連結中</th>
        <th>編輯｜刪除</th>
    </tr>
    <tr>
        <th>A1EC5830-F5F8-4678-A672-2555AC68FE38</th>
        <th>2</th>
        <th>20</th>
        <th>位於「古畫動漫：清院本清明上河圖」入口推播歡迎訊息</th>
        <th>編輯｜刪除</th>
    </tr>
    <?php 
    $query = $this->db->query('select * from ibeacon'); 
    foreach ($query->result() as $row) {
        echo $row->id."\n";
        echo $row->uuid."\n";
        echo $row->status."\n";
    }
?>
</table>