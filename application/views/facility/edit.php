<form class="form-horizontal">
    <fieldset>
        <!-- Form Name -->
        <legend>新增設施資訊</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="fac_title">設施名稱</label>
            <div class="col-md-6">
                <input id="fac_title" name="fac_title" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="fac_icon">設施圖示</label>
            <div class="col-md-4">
                <input id="fac_icon" name="fac_icon" class="input-file" type="file">
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="fac_description">設施說明</label>
            <div class="col-md-4">
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

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="fac_push">推播文字</label>
            <div class="col-md-4">
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
