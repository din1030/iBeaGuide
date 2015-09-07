<?php echo validation_errors(); ?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">新增iBeacon裝置</h4>
    </div>
    <form class="form-horizontal" action="/iBeaGuide/ibeacons/addIbeaconAction" method="post">
        <fieldset>
            <div class="modal-body">

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="ibeacon_title">iBeacon名稱</label>
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
                                    <li>
                                        <button id="link_modify" class="btn btn-link">變更</button>
                                    </li>
                                    <li>
                                        <button id="link_remove" class="btn btn-link">刪除</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Button Group -->
            <div class="modal-footer">
                <button type="button" id="ibeacon_cancel_btn" name="ibeacon_cancel_btn" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" id="ibeacon_submit_btn" name="ibeacon_submit_btn" class="btn btn-primary">送出 iBeacon 資訊</button>
            </div>

        </fieldset>
    </form>
</div>
