
    <div class="panel panel-info panel-form">
        <div class="panel-heading">
            <span class="h4">新增展覽</span>
        </div>
        <div class="panel-body">
            <div id="form_alert" class="alert alert-danger" role="alert" style="display: none"></div>
            <form id="exh_add_form" class="form-horizontal" action="/iBeaGuide/exhibitions/add_exhibition_action" method="post">
                <fieldset>

                    <div class="form-group">
                        <!-- Text input-->
                        <label class="col-md-2 control-label" for="exh_title">標題</label>
                        <div class="col-sm-8 col-md-8">
                            <input id="exh_title" name="exh_title" type="text" placeholder="" class="form-control input-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Text input-->
                        <label class="col-md-2 control-label" for="exh_subtitle">副標</label>
                        <div class="col-sm-8 col-md-8">
                            <input id="exh_subtitle" name="exh_subtitle" type="text" placeholder="" class="form-control input-md">
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Text input-->
                        <label class="col-md-2 control-label" for="exh_venue">展場</label>
                        <div class="col-sm-8 col-md-8">
                            <input id="exh_venue" name="exh_venue" type="text" placeholder="" class="form-control input-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_start_date">開展日期</label>
                        <div class="col-md-8">
                            <div class="input-group date" id="exh_start_date_picker">
                                <input id="exh_start_date" name="exh_start_date" type="text" class="form-control" required>
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
                                <input id="exh_end_date" name="exh_end_date" type="text" class="form-control" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_daily_open_time">每日開展時間</label>
                        <div class="col-md-8">
                            <div class="input-group date" id="exh_daily_open_time_picker">
                                <input id="exh_daily_open_time" name="exh_daily_open_time" type="text" class="form-control" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_daily_close_time">每日閉展時間</label>
                        <div class="col-md-8">
                            <div class="input-group date" id="exh_daily_close_time_picker">
                                <input id="exh_daily_close_time" name="exh_daily_close_time" type="text" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Textarea -->
                        <label class="col-md-2 control-label" for="exh_description">展覽介紹</label>
                        <div class="col-md-8">
                            <textarea class="form-control" id="exh_description" name="exh_description" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Text input-->
                        <label class="col-md-2 control-label" for="exh_web_link">官網連結</label>
                        <div class="col-sm-8 col-md-8">
                            <input id="exh_web_link" name="exh_web_link" type="text" placeholder="" class="form-control input-md">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_main_pic">主要圖片</label>
                        <!-- File Upload -->
                        <div class="col-md-8">
                            <input id="exh_main_pic" name="exh_main_pic[]" class="input-file" type="file" multiple="true" accept="image/*" required>
                            <p class="help-block">（檔案大小請勿超過 2 MB）</p>
                        </div>

                    </div>

                    <div class="form-group">
                        <!-- Textarea -->
                        <label class="col-md-2 control-label" for="exh_push">推播文字</label>
                        <div class="col-md-8">
                            <textarea class="form-control" id="exh_push" name="exh_push" disabled></textarea>
                            <p class="help-block">（推播文字將顯示於使用者手機推播通知）</p>
                            <div class="checkbox">
                                <label>
                                    <input id="customize_push" type="checkbox"> 自定推播文字內容
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <!-- <div class="form-group">
                        <label class="col-md-2 control-label" for="exh_ibeacon">連結 iBeacon</label>
                        <div class="col-md-8">
                            <?= form_dropdown('exh_ibeacon', $ibeacons, '', "id='exh_ibeacon' class='form-control'") ?>
                        </div>
                    </div> -->

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
                        <button type="button" id="exh-cancel-btn" name="exh-cancel-btn" class="btn btn-default">取消</button>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $('#exh_add_form').ready(function() {

            $('#exh_title').on("change keyup click", function() {
                if (!$('#customize_push').prop("checked")) {
                    $('#exh_push').val("歡迎參觀「" + $('#exh_title').val() + "」！");
                }
            });

            $('#customize_push').change(function() {
                $('#exh_push').prop('disabled', !$('#exh_push').prop('disabled'));
            });

            $('#exh_start_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#exh_end_date').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                format: 'YYYY-MM-DD'
            });
            $("#exh_start_date").on("dp.change", function(e) {
                $('#exh_end_date').data("DateTimePicker").minDate(e.date);
            });
            $("#exh_end_date").on("dp.change", function(e) {
                $('#exh_start_date').data("DateTimePicker").maxDate(e.date);
            });
            $('#exh_daily_open_time').datetimepicker({
                format: 'HH:mm'
            });
            $('#exh_daily_close_time').datetimepicker({
                useCurrent: false,
                format: 'HH:mm'
            });
            $("#exh_daily_open_time").on("dp.change", function(e) {
                $('#exh_daily_close_time').data("DateTimePicker").minDate(e.date);
            });
            $("#exh_daily_close_time").on("dp.change", function(e) {
                $('#exh_daily_open_time').data("DateTimePicker").maxDate(e.date);
            });
            $('#exh_main_pic').fileinput({
                language: 'zh-TW',
                showUpload: false,
                minFileCount: 1,
                maxFileCount: 1,
                allowedFileTypes: ["image"],
                previewFileType: 'image'
            });
            $('form').ajaxForm({
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
                            url: '/iBeaGuide/exhibitions/print_exh_list',
                            type: "GET",
                            dataType: 'html',
                            success: function(html_block) {
                                $('#exh_list_block').html(html_block);
                                $('#exh_form_block').empty();
                                $('[data-toggle="table"]').bootstrapTable();
                                $('#system-message').html('完成');
                                $('#system-message').fadeOut();
                                $.scrollTo($('#add-exh-btn'), 500, {offset: -10});
                            }
                        });

                        $('#system-message').html('完成');
                        $('#system-message').fadeOut();
                    }
                }
            });
            $(document.body).off('click.exh_cancel', '#exh-cancel-btn');
            $(document.body).on('click.exh_cancel', '#exh-cancel-btn', function() {
                $('#exh_form_block').empty();
                $.scrollTo($('#add-exh-btn'), 500, {
                    offset: -10
                });
            });
        });
    </script>
