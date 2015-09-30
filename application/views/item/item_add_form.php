<div class="panel panel-info panel-form">
    <div class="panel-heading">
        <span class="h4">新增展品</span>
    </div>
    <div class="panel-body">
        <div id="form_alert" class="alert alert-danger" role="alert" style="display: none"></div>
        <form id="item_add_form" class="form-horizontal" action="/iBeaGuide/items/add_item_action" method="post" enctype="multipart/form-data">
            <fieldset>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_exh">所屬展覽</label>
                    <div class="col-md-8">
                        <?= form_dropdown('item_exh', $exhibitions, '', "id='item_exh' class='form-control'") ?>
                    </div>
                </div>

                <!-- Select Basic -->
                <div id="item_sec_block" class="form-group" style="display:none;">
                    <label class="col-md-2 control-label" for="item_section">展區</label>
                    <div class="col-md-8">
                    </div>
                </div>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_title">展品標題</label>
                    <div class="col-md-8">
                        <input id="item_title" name="item_title" type="text" placeholder="" class="form-control input-md" required="">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_subtitle">展品副標</label>
                    <div class="col-md-8">
                        <input id="item_subtitle" name="item_subtitle" type="text" placeholder="" class="form-control input-md">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_creator">展品創作者</label>
                    <div class="col-md-8">
                        <input id="item_creator" name="item_creator" type="text" placeholder="" class="form-control input-md" required="">
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_brief">展品簡介</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="item_brief" name="item_brief" required=""></textarea>
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_main_pic">主要圖片</label>
                    <div class="col-md-8">
                        <input id="item_main_pic" name="item_main_pic[]" class="input-file" type="file" accept="image/*">
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_audioguide">導覽語音</label>
                    <div class="col-md-8">
                        <input id="item_audioguide" name="item_audioguide" class="input-file" type="file" accept=".mp3">
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_detail">展品詳細說明</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="item_detail" name="item_detail" required=""></textarea>
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_more_pics">其他圖片</label>
                    <div class="col-md-8">
                        <input id="item_more_pics" name="item_more_pics" class="input-file" type="file" accept="image/*">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_finished_time">展品完成時間</label>
                    <div class="col-md-8">
                        <input id="item_finished_time" name="item_finished_time" type="text" placeholder="日期或文字描述（如：2015 夏末）" class="form-control input-md">

                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="exh_ibeacon">連結 iBeacon</label>
                    <div class="col-md-8">
                        <?= form_dropdown('item_ibeacon', $ibeacons, '', "id='item_ibeacon' class='form-control'") ?>
                    </div>
                </div>

                <!-- Button Group -->
                <div class="form-group text-center">
                    <button type="button" id="preview" name="preview" class="btn btn-default">預覽</button>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">送出展品資訊</button>
                    <button type="button" id="item-cancel-btn" name="item-cancel-btn" class="btn btn-default">取消</button>
                </div>

            </fieldset>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#item_add_form').ready(function() {
        $(document.body).off('change.item_exh', '#item_exh');
        $(document.body).on('change.item_exh', '#item_exh', function() {
            var exh_selected = $('#item_exh').val();
            $.ajax({
                url: '/iBeaGuide/items/print_exh_sec_select/' + exh_selected,
                type: "GET",
                dataType: 'html',
                success: function(html_block) {
                    if (html_block) {
                        $('#item_sec_block > div').html(html_block);
                        $('#item_sec_block').show();
                    } else {
                        $('#item_sec_block > div').empty();
                        $('#item_sec_block').hide();
                    }
                }
            });
        });
        $('#item_main_pic').fileinput({
            language: 'zh-TW',
            showUpload: false,
            minFileCount: 1,
            maxFileCount: 1,
            allowedFileTypes: ["image"],
            previewFileType: 'image'
        });
        $('#item_more_pics').fileinput({
            language: 'zh-TW',
            showUpload: false,
            minFileCount: 3,
            // maxFileCount: 5,
            allowedFileTypes: ["image"],
            previewFileType: 'image'
        });
        $('#item_audioguide').fileinput({
            language: 'zh-TW',
            showUpload: false,
            minFileCount: 1,
            maxFileCount: 1,
            allowedFileTypes: ["audio"],
            previewFileType: 'audio'
        });
        $(document.body).off('click.item_cancel', '#item-cancel-btn');
        $(document.body).on('click.item_cancel', '#item-cancel-btn', function() {
            $('#item_form_block').empty();
            $.scrollTo($('#add-item-btn'), 500, {
                offset: -10
            });
        });
    });
</script>