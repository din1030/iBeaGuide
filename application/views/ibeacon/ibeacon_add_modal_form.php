<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">新增iBeacon裝置</h4>
    </div>
    <form class="form-horizontal" action="ibeacons/add_ibeacon_action" method="post">
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

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="ibeacon_link_type">連結物件種類</label>
                    <div class="col-md-6">
                        <?= form_dropdown('ibeacon_link_type', $type, '', "id='ibeacon_link_type' class='form-control'") ?>
                    </div>
                </div>

                <!-- ibeacon obj menu -->
                <div id="link_obj_block" class="form-group" style="display: none">
                    <label class="col-md-4 control-label" for="ibeacon_obj">連結對象</label>
                    <div class="col-md-6">
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
<script type="text/javascript">
    $('#ibeacon_edit_form').ready(function() {
        $(document.body).off('change.ibeacon_link_type', '#ibeacon_link_type');
        $(document.body).on('change.ibeacon_link_type', '#ibeacon_link_type', function() {
            $.ajax({
                url: '/iBeaGuide/ibeacons/print_obj_menu/' + $('#ibeacon_link_type').val(),
                type: "GET",
                dataType: 'html',
                success: function(html_block) {
                    if (html_block) {
                        $('#link_obj_block > div').html(html_block);
                        $('#link_obj_block').show();
                    } else {
                        $('#link_obj_block > div').empty();
                        $('#link_obj_block').hide();
                    }
                }
            });
        });
    });
</script>
