<?php echo validation_errors(); ?>

<form class="form-horizontal" action="AddIbeaconAction" method="post">
    <fieldset>

        <!-- Form Name -->
        <legend>新增 iBeacon 裝置</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="ibeacon_title">iBeacon 名稱</label>
            <div class="col-md-6">
                <input id="ibeacon_title" name="ibeacon_title" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="ibeacon_uuid">UUID</label>
            <div class="col-md-6">
                <input id="ibeacon_uuid" name="ibeacon_uuid" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="ibeacon_major">Major</label>
            <div class="col-md-6">
                <input id="ibeacon_major" name="ibeacon_major" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="ibeacon_minor">Minor</label>
            <div class="col-md-6">
                <input id="ibeacon_minor" name="ibeacon_minor" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Button Drop Down -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="ibeacon_link">連結物件</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input id="ibeacon_link" name="ibeacon_link" class="form-control" placeholder="" type="text">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            管理
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right">
                            <li><button id="link_modify" class="btn btn-link">變更</button></li>
                            <li><button id="link_remove" class="btn btn-link">刪除</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button Group -->
        <div class="form-group text-center">
            <button id="submit" name="submit" class="btn btn-primary">送出 iBeacon 資訊</button>
            <button id="cancel" name="cancel" class="btn btn-default">取消</button>
        </div>

    </fieldset>
</form>
