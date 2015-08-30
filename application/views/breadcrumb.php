<div calss="row">
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>" class="">首頁</a>
        </li>

        <?php
        switch (uri_string()) {

            case '':
                break;

            case 'exhibitions':
                ?>
                <li>
                    展覽管理
                </li>
                <?php
                break;

            case 'exhibitions/add':
                ?>
                <li>
                    <a href="<?php echo base_url() ?>exhibitions">展覽管理</a>
                </li>
                <li>
                    新增展覽資訊
                </li>
                <?php
                break;

            case 'items':
                ?>
                <li>
                    展品管理
                </li>
                <?php
                break;

            case 'items/add':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>items">展品管理</a>
                </li>
                <li>
                    新增展品資訊
                </li>
                <?php
                break;

            case 'facilities':
                ?>
                <li>
                    展品管理
                </li>
                <?php
                break;

            case 'facilities/add':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>facilities">設施管理</a>
                </li>
                <li>
                    新增設施資訊
                </li>
                <?php
                break;

            case 'routes':
                ?>
                <li>
                    路線管理
                </li>
                <?php
                break;

            case 'routes/add':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>routes">路線管理</a>
                </li>
                <li>
                    新增路線
                </li>
                <?php
                break;

            case 'comments':
                ?>
                <li>
                    留言管理
                </li>
                <?php
                break;

            case 'comments/exh':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>comments">留言管理</a>
                </li>
                <li>
                    展覽留言管理
                </li>
                <?php
                break;

            case 'comments/item':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>comments">留言管理</a>
                </li>
                <li>
                    展品留言管理
                </li>
                <?php
                break;

            case 'ibeacons':
                ?>
                <li>
                    iBeacon管理
                </li>
                <?php
                break;

            case 'ibeacons/add':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>ibeacon">iBeacon管理</a>
                </li>
                <li>
                    新增 iBeacon
                </li>
                <?php
                break;
        }
        ?>
    </ol>
</div>