<?php echo validation_errors(); ?>
    <div class="panel panel-info panel-form">
        <div class="panel-heading">
            <span class="h4">編輯「
                <?= $exhibition->title ?>」展覽資訊</span>
        </div>
        <div class="panel-body">
            <div id="form_alert" class="alert alert-danger" role="alert" style="display: none"></div>
            <form id="exh_edit_form" class="form-horizontal" action="/iBeaGuide/exhibitions/edit_exhibition_action" method="post">
                <fieldset>
                    <input id="exh_id" type="hidden" name="exh_id" value="<?= $exhibition->id ?>">

                    <div class="form-group">
                        <!-- Text input-->
                        <label class="col-md-2 control-label" for="exh_title">標題</label>
                        <div class="col-sm-8 col-md-8">
                            <input id="exh_title" name="exh_title" type="text" placeholder="" class="form-control input-md" required value="<?= $exhibition->title ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Text input-->
                        <label class="col-md-2 control-label" for="exh_subtitle">副標</label>
                        <div class="col-sm-8 col-md-8">
                            <input id="exh_subtitle" name="exh_subtitle" type="text" placeholder="" class="form-control input-md" value="<?= $exhibition->subtitle ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Text input-->
                        <label class="col-md-2 control-label" for="exh_venue">展場</label>
                        <div class="col-sm-8 col-md-8">
                            <input id="exh_venue" name="exh_venue" type="text" placeholder="" class="form-control input-md" required="" value="<?= $exhibition->venue ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_start_date">開展日期</label>
                        <div class="col-md-8">
                            <div class="input-group date" id="exh_start_date_picker">
                                <input id="exh_start_date" name="exh_start_date" type="text" class="form-control" required value="<?= $exhibition->start_date ?>" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_end_date">閉展日期</label>
                        <div class="col-md-8">
                            <div class="input-group date" id="exh_end_date_picker">
                                <input id="exh_end_date" name="exh_end_date" type="text" class="form-control" required value="<?= $exhibition->end_date ?>" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_daily_open_time">每日開展時間</label>
                        <div class="col-md-8">
                            <div class='input-group date' id='exh_daily_open_time_picker'>
                                <input id="exh_daily_open_time" name="exh_daily_open_time" type="text" class="form-control" required value="<?= $exhibition->daily_open_time ?>" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_daily_close_time">每日閉展時間</label>
                        <div class="col-md-8">
                            <div class="input-group date" id="exh_daily_close_time_picker">
                                <input id="exh_daily_close_time" name="exh_daily_close_time" type="text" class="form-control" required value="<?= $exhibition->daily_close_time ?>" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Textarea -->
                        <label class="col-md-2 control-label" for="exh_description">展覽介紹</label>
                        <div class="col-md-8">
                            <textarea id="exh_description" name="exh_description" class="form-control" required><?= $exhibition->description ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Text input-->
                        <label class="col-md-2 control-label" for="exh_web_link">官網連結</label>
                        <div class="col-sm-8 col-md-8">
                            <input id="exh_web_link" name="exh_web_link" type="text" placeholder="" class="form-control input-md" value="<?= $exhibition->web_link ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_main_pic">主要圖片</label>
                        <!-- File Upload -->
                        <div class="col-md-8">
                            <input id="exh_main_pic" name="exh_main_pic[]" class="input-file" type="file" accept="image/*">
                            <p class="help-block">（檔案大小請勿超過 2 MB）</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Textarea -->
                        <label class="col-md-2 control-label" for="exh_push">推播文字</label>
                        <div class="col-md-8">
                            <textarea class="form-control" id="exh_push" name="exh_push"><?= $exhibition->push_content ?></textarea>
                            <p class="help-block">（推播文字將顯示於使用者手機推播通知）</p>
                            <!-- <div class="checkbox">
                            <label>
                                <input id="customize_push" type="checkbox"> 自定推播文字內容
                            </label>
                        </div> -->
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_ibeacon">連結iBeacon</label>
                        <div class="col-md-8">
                            <?= form_dropdown('exh_ibeacon', $ibeacons, $exhibition->ibeacon_id, "id='exh_ibeacon' class='form-control'") ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <!-- Button -->
                        <div class="col-sm-8 col-md-8">
                            <button type="button" class="btn btn-info">連結出口iBeacon</button>
                        </div>
                    </div>

                    <!-- Button Group -->
                    <div class="form-group text-center">
                        <button type="button" id="preview" name="preview" class="btn btn-default">預覽</button>
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">送出展覽資訊</button>
                        <button type="button" id="exh_cancel_btn" name="exh_cancel_btn" class="btn btn-default">取消</button>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $('#exh_edit_form').ready(function() {
            // $('#exh_title').on("change keyup click", function() {
            //     if (!$('#customize_push').prop("checked")) {
            //         $('#exh_push').val("歡迎參觀「" + $('#exh_title').val() + "」！");
            //     }
            // });
            //
            // $('#customize_push').change(function() {
            //     $('#exh_push').prop('disabled', !$('#exh_push').prop('disabled'));
            // });
            $('#exh_start_date_picker').datetimepicker({
                format: 'YYYY-MM-DD',
                defaultDate: moment("<?= $exhibition->start_date ?>")
            });
            $('#exh_end_date_picker').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                format: 'YYYY-MM-DD',
                defaultDate: moment("<?= $exhibition->end_date ?>")
            });
            $("#exh_start_date_picker").on("dp.change", function(e) {
                $('#exh_end_date').data("DateTimePicker").minDate(e.date);
            });
            $("#exh_end_date_picker").on("dp.change", function(e) {
                $('#exh_start_date').data("DateTimePicker").maxDate(e.date);
            });
            $('#exh_daily_open_time_picker').datetimepicker({
                format: 'HH:mm',
                defaultDate: moment("<?= $exhibition->daily_open_time ?>", "HH:mm:ss")
            });
            $('#exh_daily_close_time_picker').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                format: 'HH:mm',
                defaultDate: moment("<?= $exhibition->daily_close_time ?>", "HH:mm:ss")
            });
            $("#exh_daily_open_time_picker").on("dp.change", function(e) {
                $('#exh_daily_close_time_picker').data("DateTimePicker").minDate(e.date);
            });
            $("#exh_daily_close_time_picker").on("dp.change", function(e) {
                $('#exh_daily_open_time_picker').data("DateTimePicker").maxDate(e.date);
            });
            $('#exh_main_pic').fileinput({
                // language: 'zh-TW',
                showUpload: false,
                // minFileCount: 1, 編輯可不上傳檔案
                maxFileCount: 1,
                allowedFileTypes: ["image"],
                previewFileType: 'image'
            });
            $('form').ajaxForm({
                beforeSend: function(xhr) {
                    $('#system-message').html('處理中...');
                    $('#system-message').show();
                },
                success: function(result) {
                    if (result) {
                        $('#form_alert').html(result);
                        $('#form_alert').show();
                        $('#system-message').fadeOut();
                    } else {
                        $('#form_alert').hide();
                        $('#form_alert').empty();
                        $.ajax({
                            url: 'exhibitions/print_exh_list',
                            type: "GET",
                            dataType: 'html',
                            success: function(html_block) {
                                $('#exh_list_block').html(html_block);
                                $('#exh_form_block').empty();
                                $('[data-toggle="table"]').bootstrapTable();
                                $('#system-message').html('完成');
                                $('#system-message').fadeOut();
                                $.scrollTo($('#add-exh-btn'), 500, {
                                    offset: -10
                                });
                            }
                        });
                        $('#system-message').html('完成');
                        $('#system-message').fadeOut();
                    }
                }
            });

            $(document.body).off('click.exh_cancel', '#exh_cancel_btn');
            $(document.body).on('click.exh_cancel', '#exh_cancel_btn', function() {
                $('#exh_form_block').empty();
                $.scrollTo($('#add_exh_btn'), 500, {
                    offset: -10
                });
            });
        });
    </script>
