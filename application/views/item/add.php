<?php echo validation_errors(); ?>

<form class="form-horizontal" action="/iBeaGuide/exhibitions/addItemAction" method="post">
    <fieldset>

        <!-- Form Name -->
        <legend>新增展品資訊</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_title">展品標題</label>
            <div class="col-md-6">
                <input id="item_title" name="item_title" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_subtitle">展品副標</label>
            <div class="col-md-6">
                <input id="item_subtitle" name="item_subtitle" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_creator">展品創作者</label>
            <div class="col-md-6">
                <input id="item_creator" name="item_creator" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_section">展區</label>
            <div class="col-md-6">
                <select id="item_section" name="item_section" class="form-control">
                    <option value="1">展區 A</option>
                    <option value="2">展區 B</option>
                </select>
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_brief">展品簡介</label>
            <div class="col-md-4">
                <textarea class="form-control" id="item_brief" name="item_brief"></textarea>
            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_main_pic">主要圖片</label>
            <div class="col-md-4">
                <input id="item_main_pic" name="item_main_pic" class="input-file" type="file">
            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_audioguide">導覽語音</label>
            <div class="col-md-4">
                <input id="item_audioguide" name="item_audioguide" class="input-file" type="file">
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_detail">展品詳細說明</label>
            <div class="col-md-4">
                <textarea class="form-control" id="item_detail" name="item_detail"></textarea>
            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_more_pics">其他圖片</label>
            <div class="col-md-4">
                <input id="item_more_pics" name="item_more_pics" class="input-file" type="file">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_finished_time">展品完成時間</label>
            <div class="col-md-6">
                <input id="item_finished_time" name="item_finished_time" type="text" placeholder="日期或文字描述（如：2015 夏末）" class="form-control input-md">

            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="item_ibeacon">連結 iBeacon</label>
            <div class="col-md-6">
                <select id="item_ibeacon" name="item_ibeacon" class="form-control">
                    <option value="null">請選擇</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                </select>
            </div>
        </div>

        <!-- Button Group -->
        <div class="form-group text-center">
            <button id="preview" name="preview" class="btn btn-default">預覽</button>
            <button id="submit" name="submit" class="btn btn-primary">送出展品資訊</button>
            <button id="cancel" name="cancel" class="btn btn-default">取消</button>
        </div>

    </fieldset>
</form>
