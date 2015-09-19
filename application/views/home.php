<div id="active-exh" class="row" style="padding-bottom: 15px;">
    <h4>進行中展覽：</h4>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
        <img class="img-responsive" src="<?php echo $exhibitions[0]['main_pic']; ?>">
        <h4><?= $exhibitions[0]['title']; ?></h4>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
        <img class="img-responsive" src="<?php echo $exhibitions[1]['main_pic']; ?>">
        <h4><?= $exhibitions[1]['title']; ?></h4>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
        <img class="img-responsive" src="<?php echo $exhibitions[2]['main_pic']; ?>">
        <h4><?= $exhibitions[2]['title']; ?></h4>
    </div>
</div>
<hr>
<div id="manage-block-list" class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 manage-block">
        <a class="btn btn-block btn-lg btn-danger list-group" href="/iBeaGuide/exhibitions">展覽管理</a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 manage-block">
        <a class="btn btn-block btn-lg btn-info list-group" href="/iBeaGuide/items">展品管理</a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 manage-block">
        <a class="btn btn-block btn-lg btn-success list-group" href="/iBeaGuide/facilities">設施管理</a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 manage-block">
        <a class="btn btn-block btn-lg btn-warning list-group" href="/iBeaGuide/routes">路線管理</a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 manage-block">
        <a class="btn btn-block btn-lg btn-primary list-group" href="/iBeaGuide/comments">留言管理</a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 manage-block">
        <a class="btn btn-block btn-lg btn-default list-group" href="/iBeaGuide/ibeacons">iBeacon管理</a>
    </div>
</div>
