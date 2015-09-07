<?php echo validation_errors(); ?>
<div class="panel panel-info panel-form">
    <div class="panel-heading">
        <span class="h4">新增設施資訊</span>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="/iBeaGuide/exhibitions/addFacilityAction" method="post">
            <fieldset>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="fac_exh">所屬展覽</label>
                    <div class="col-md-6">
                        <?= form_dropdown('fac_exh', $exhibitions,'',"id='fac_exh' class='form-control'") ?>
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
                    <div class="col-md-6">
                        <input id="fac_main_pic" name="fac_main_pic" class="input-file" type="file">
                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="fac_ibeacon">連結 iBeacon</label>
                    <div class="col-md-6">
                        <?= form_dropdown('fac_ibeacon', $ibeacons,'',"id='fac_ibeacon' class='form-control'") ?>
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
                    <button type="button" id="fac_preview_btn" name="fac_preview_btn" class="btn btn-default">預覽</button>
                    <button type="submit" id="fac_submit_btn" name="fac_submit_btn" class="btn btn-primary">送出設施資訊</button>
                    <button type="button" id="fac_cancel_btn" name="fac_cancel_btn" class="btn btn-default">取消</button>
                </div>

            </fieldset>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document.body).off('click.fac_cancel', '#fac_cancel_btn');
    $(document.body).on('click.fac_cancel', '#fac_cancel_btn', function() {
        $('#fac_form_block').empty();
        $.scrollTo($('#add_fac_btn'), 500, {offset: -10});
    });
</script>
