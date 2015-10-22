<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">編輯iBeacon裝置資訊</h4>
    </div>
    <form id="ibeacon_edit_form" class="form-horizontal" action="/iBeaGuide/ibeacons/edit_ibeacon_action" method="post">
        <fieldset>
            <div class="modal-body">
                <input id="ibeacon_id" type="hidden" name="ibeacon_id" value="<?= $ibeacon->id ?>">

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="ibeacon_title">名稱</label>
                    <div class="col-md-6">
                        <input id="ibeacon_title" name="ibeacon_title" type="text" placeholder="" class="form-control input-md" required="" value="<?= $ibeacon->title ?>">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="ibeacon_uuid">UUID</label>
                    <div class="col-md-6">
                        <input id="ibeacon_uuid" name="ibeacon_uuid" type="text" placeholder="" class="form-control input-md" required="" value="<?= $ibeacon->uuid ?>">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="ibeacon_major">Major</label>
                    <div class="col-md-6">
                        <input id="ibeacon_major" name="ibeacon_major" type="text" placeholder="" class="form-control input-md" required="" value="<?= $ibeacon->major ?>">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="ibeacon_minor">Minor</label>
                    <div class="col-md-6">
                        <input id="ibeacon_minor" name="ibeacon_minor" type="text" placeholder="" class="form-control input-md" required="" value="<?= $ibeacon->minor ?>">
                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="ibeacon_link_type">連結物件種類</label>
                    <div class="col-md-6">
                        <?= form_dropdown('ibeacon_link_type', $type, $ibeacon->link_type, "id='ibeacon_link_type' class='form-control'") ?>
                    </div>
                </div>

                <!-- ibeacon obj menu -->
                <div id="link_obj_block" class="form-group" style="<?php if(empty($linked_obj)) echo 'display: none;' ?>">
                    <label class="col-md-4 control-label" for="ibeacon_link_obj">連結對象</label>
                    <div class="col-md-6">
                        <?php
                            if ($ibeacon->link_obj_id == 'none' || !empty($ibeacon->link_obj_id)) {
                                echo form_dropdown('ibeacon_link_obj', $linked_obj, $ibeacon->link_obj_id, "id='ibeacon_link_obj' class='form-control'");
                            }
                        ?>
                    </div>
                </div>

            </div>
            <!-- Button Group -->
            <div class="modal-footer">
                <button type="button" id="ibeacon_cancel_btn" name="ibeacon_cancel_btn" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" id="ibeacon_submit_btn" name="ibeacon_submit_btn" class="btn btn-primary">送出iBeacon資訊</button>
            </div>

        </fieldset>
    </form>
</div>
<script type="text/javascript">
    $('#ibeacon_edit_form').ready(function() {
        $(document.body).off('change.ibeacon_link_type', '#ibeacon_link_type');
        $(document.body).on('change.ibeacon_link_type', '#ibeacon_link_type', function() {
            var url_str ='/iBeaGuide/ibeacons/print_obj_menu/' + $('#ibeacon_link_type').val()
            if($('#ibeacon_link_type').val() == '<?= $ibeacon->link_type ?>') {
                url_str += '/<?= $ibeacon->link_obj_id ?>';
            }
            $.ajax({
                url: url_str,
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

        $('#ibeacon_edit_form').ajaxForm({
            beforeSend: function(xhr) {
                $('#system-message').html('處理中...');
                $('#system-message').show();
            },
            success: function(error) {
                if (error) {
                    $('#form_alert').html(error);
                    $('#form_alert').show();
                    $('#system-message').fadeOut();
                } else {
                    $('#form_alert').hide();
                    $('#form_alert').empty();
                    $.ajax({
                        url: '/iBeaGuide/ibeacons/print_ibeacon_list',
                        type: "GET",
                        dataType: 'html',
                        success: function(html_block) {
                            $('#ibeacon_list_block').html(html_block);
                            $('#iBeaGuide-modal-block').empty();
                            $('#iBeaGuide-modal').modal('hide');
                            $('[data-toggle="table"]').bootstrapTable();
                            $('#system-message').html('完成');
                            $('#system-message').fadeOut();
                            $.scrollTo($('#add-ibeacon-btn'), 500, {
                                offset: -10
                            });
                        }
                    });
                    $('#system-message').html('完成');
                    $('#system-message').fadeOut();
                }
            }
        });
    });
</script>
