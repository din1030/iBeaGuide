<?php echo validation_errors(); ?>

<form class="form-horizontal" action="AddFacilityAction" method="post">
    <fieldset>

        <!-- Form Name -->
        <legend>新增設施資訊</legend>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="fac_exh">所屬展覽</label>
            <div class="col-md-6">
                <select id="fac_exh" name="fac_exh" class="form-control">
                    <option value="null">請選擇</option>
                    <option value="1">展覽 A</option>
                    <option value="2">展覽 B</option>
                    <option value="3">展覽 C</option>
                </select>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="fac_title">設施名稱</label>
            <div class="col-md-6">
                <input id="fac_title" name="fac_title" type="text" placeholder="" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="fac_description">設施說明</label>
            <div class="col-md-6">
                <textarea class="form-control" id="fac_description" name="fac_description"></textarea>
            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="fac_main_pic">主要圖片</label>
            <div class="col-md-4">
                <input id="fac_main_pic" name="fac_main_pic" class="input-file" type="file">
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="fac_ibeacon">連結 iBeacon</label>
            <div class="col-md-6">
                <select id="fac_ibeacon" name="fac_ibeacon" class="form-control">
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

        <!-- Button Group -->
        <div class="form-group text-center">
            <button id="preview" name="preview" class="btn btn-default">預覽</button>
            <button id="submit" name="submit" class="btn btn-primary">送出設施資訊</button>
            <button id="cancel" name="cancel" class="btn btn-default">取消</button>
        </div>

    </fieldset>
</form>
