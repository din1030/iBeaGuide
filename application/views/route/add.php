<?php echo validation_errors(); ?>

<form class="form-horizontal" action="AddRouteAction" method="post">
    <fieldset>

        <!-- Form Name -->
        <legend>新增推薦路線</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="route_title">路線標題</label>
            <div class="col-md-6">
                <input id="route_title" name="route_title" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="route_exh">所屬展覽</label>
            <div class="col-md-6">
                <select id="route_exh" name="route_exh" class="form-control">
                    <option value="1">展覽 A</option>
                    <option value="2">展覽 B</option>
                </select>
            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="route_main_pic">主要圖片</label>
            <div class="col-md-4">
                <input id="route_main_pic" name="route_main_pic" class="input-file" type="file">
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="route_description">路線說明</label>
            <div class="col-md-4">
                <textarea class="form-control" id="route_description" name="route_description"></textarea>
            </div>
        </div>

        <!-- Button Group -->
        <div class="form-group text-center">
            <button id="preview" name="preview" class="btn btn-default">預覽</button>
            <button id="submit" name="submit" class="btn btn-primary">送出路線資訊</button>
            <button id="cancel" name="cancel" class="btn btn-default">取消</button>
        </div>

    </fieldset>
</form>
