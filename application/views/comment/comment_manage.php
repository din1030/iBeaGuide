<legend>
    留言管理
</legend>
<div id="exh_list_block">
    <?= $this->table->generate($exhibitions); ?>
</div>
<?php $this->table->clear(); ?>
<!-- <table id="item_list" data-toggle="table" data-striped="true">
    <thead>
        <tr>
            <th>ID</th>
            <th>展覽名稱</th>
            <th>管理</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>2</td>
            <td>食物箴言：思想與食物</td>
            <td>
                <a href="/iBeaGuide/comments/add" class="btn btn-default">觀看展覽留言</a>
                <a href="/iBeaGuide/comments/add" class="btn btn-default">觀看展品留言</a>
                <a href="/iBeaGuide/comments/add" class="btn btn-default">關閉展覽留言功能</a>
            </td>
        </tr>
    </tbody>
</table> -->
