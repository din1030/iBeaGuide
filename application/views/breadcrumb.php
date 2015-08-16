<div calss="row">
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>" class="">首頁</a>
            <span class="glyphicon glyphicon-menu-right"></span>
        </li>

        <?php
        switch (uri_string()) {

            case '':
                break;

            case 'exhibition':
                ?>
                <li>
                    展覽管理
                </li>
                <?php
                break;

            case 'exhibition/add':
                ?>
                <li>
                    <a href="<?php echo base_url() ?>exhibition">展覽管理</a>
                    <span class="glyphicon glyphicon-menu-right"></span>
                </li>
                <li>
                    新增展覽資訊
                </li>
                <?php
                break;

            case 'item':
                ?>
                <li>
                    展品管理
                </li>
                <?php
                break;

            case 'item/add':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>item">展品管理</a>
                    <span class="glyphicon glyphicon-menu-right"></span>
                </li>
                <li>
                    新增展品資訊
                </li>
                <?php
                break;

            case 'facility':
                ?>
                <li>
                    展品管理
                </li>
                <?php
                break;

            case 'facility/add':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>facility">設施管理</a>
                    <span class="glyphicon glyphicon-menu-right"></span>
                </li>
                <li>
                    新增設施資訊
                </li>
                <?php
                break;

            case 'route':
                ?>
                <li>
                    路線管理
                </li>
                <?php
                break;

            case 'route/add':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>route">路線管理</a>
                    <span class="glyphicon glyphicon-menu-right"></span>
                </li>
                <li>
                    新增路線
                </li>
                <?php
                break;

            case 'comment':
                ?>
                <li>
                    留言管理
                </li>
                <?php
                break;

            case 'comment/exh':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>comment">留言管理</a>
                    <span class="glyphicon glyphicon-menu-right"></span>
                </li>
                <li>
                    展覽留言管理
                </li>
                <?php
                break;

            case 'comment/item':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>comment">留言管理</a>
                    <span class="glyphicon glyphicon-menu-right"></span>
                </li>
                <li>
                    展品留言管理
                </li>
                <?php
                break;

            case 'ibeacon':
                ?>
                <li>
                    留言管理
                </li>
                <?php
                break;

            case 'ibeacon/add':
                ?>
                <li>
                    <a href="<?php echo base_url(); ?>ibeacon">留言管理</a>
                    <span class="glyphicon glyphicon-menu-right"></span>
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
