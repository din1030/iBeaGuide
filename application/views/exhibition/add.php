<?php echo validation_errors(); ?>

<form class="form-horizontal" action="AddExhibitionAction" method="post">
    <fieldset>

        <legend >新增展覽資訊</legend>

        <div class="form-group">
            <!-- Text input-->
            <label class="col-md-4 control-label" for="exh_title">標題</label>
            <div class="col-sm-6 col-md-6">
                <input id="exh_title" name="exh_title" type="text" placeholder="" class="form-control input-md" required="">
            </div>
        </div>

        <div class="form-group">
            <!-- Text input-->
            <label class="col-md-4 control-label" for="exh_subtitle">副標</label>
            <div class="col-sm-6 col-md-6">
                <input id="exh_subtitle" name="exh_subtitle" type="text" placeholder="" class="form-control input-md" required="">
            </div>
        </div>

        <div class="form-group">
            <!-- Text input-->
            <label class="col-md-4 control-label" for="exh_venue">展場</label>
            <div class="col-sm-6 col-md-6">
                <input id="exh_venue" name="exh_venue" type="text" placeholder="" class="form-control input-md" required="">
            </div>
        </div>

        <div class="form-group">
            <!-- Text input-->
            <label class="col-md-4 control-label" for="exh_web_link">官網連結</label>
            <div class="col-sm-6 col-md-6">
                <input id="exh_web_link" name="exh_web_link" type="text" placeholder="" class="form-control input-md" required="">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="exh_main_pic">封面照片</label>
            <!-- File Upload -->
            <div class="col-md-4">
                <input id="exh_main_pic" name="exh_main_pic" class="input-file" type="file">
            </div>
        </div>

        <div class="form-group">
            <!-- Textarea -->
            <label class="col-md-4 control-label" for="exh_description">展覽介紹</label>
            <div class="col-md-6">
                <textarea class="form-control" id="exh_description" name="exh_description"></textarea>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-4 control-label" for="exh_start_date">開展日期</label>
            <div class="col-md-6">
                <div class='input-group date' id='exh_start_date'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="exh_end_date">閉展日期</label>
            <div class="col-md-6">
                <div class='input-group date' id='exh_end_date'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="exh_daily_open_time">每日開展時間</label>
            <div class="col-md-6">
                <div class='input-group date' id='exh_daily_open_time'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="exh_daily_close_time">每日閉展時間</label>
            <div class="col-md-6">
                <div class='input-group date' id='exh_daily_close_time'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#exh_start_date').datetimepicker({
                    format: 'YYYY-MM-DD'
                });

                $('#exh_end_date').datetimepicker({
                    useCurrent: false, //Important! See issue #1075
                    format: 'YYYY-MM-DD'
                });

                $("#exh_start_date").on("dp.change", function (e) {
                    $('#exh_end_date').data("DateTimePicker").minDate(e.date);
                });

                $("#exh_end_date").on("dp.change", function (e) {
                    $('#exh_start_date').data("DateTimePicker").maxDate(e.date);
                });

                $('#exh_daily_open_time').datetimepicker({
                    format: 'HH:mm'
                });

                $('#exh_daily_close_time').datetimepicker({
                    format: 'HH:mm'
                });
            });
        </script>

        <div class="form-group">
            <!-- Textarea -->
            <label class="col-md-4 control-label" for="exh_push">推播文字</label>
            <div class="col-md-6">
                <textarea class="form-control" id="exh_push" name="exh_push"></textarea>
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="exh_ibeacon">連結 iBeacon</label>
            <div class="col-md-6">
                <select id="exh_ibeacon" name="exh_ibeacon" class="form-control">
                    <option value="null">請選擇</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                </select>
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="fac_push">推播文字</label>
            <div class="col-md-6">
                <textarea class="form-control" id="fac_push" name="fac_push"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label"></label>
            <!-- Button -->
            <div class="col-sm-6 col-md-6">
                <button class="btn btn-info">建立展區</button>
                <button class="btn btn-info">連結出口 iBeacon</button>
            </div>
        </div>

        <!-- Button Group -->
        <div class="form-group text-center">
            <button id="preview" name="preview" class="btn btn-default">預覽</button>
            <button id="submit" name="submit" class="btn btn-primary">送出展覽資訊</button>
            <button id="cancel" name="cancel" class="btn btn-default">取消</button>
        </div>

    </fieldset>
</form>
