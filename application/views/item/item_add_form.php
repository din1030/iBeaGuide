<div class="panel panel-info panel-form">
    <div class="panel-heading">
        <span class="h4">新增展品</span>
    </div>
    <div class="panel-body">
        <div id="form_alert" class="alert alert-danger" role="alert" style="display: none"></div>
        <form id="item_add_form" class="form-horizontal" action="/iBeaGuide/items/add_item_action" method="post" enctype="multipart/form-data">
            <fieldset id="item_basic_info">

                <div class="col-md-12">
                    <legend>展品基本資訊
                        <span style="font-size:15px; color:#AAA;">顯示於展品導覽預設頁面</span>
                    </legend>
                </div>

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
                    <label class="col-md-2 control-label" for="item_title">展品名稱</label>
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
                    <label class="col-md-2 control-label" for="item_creator">展品作者</label>
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
                        <input id="item_main_pic" name="item_main_pic[]" class="input-file" type="file" accept="image/*" required="">
                        <p class="help-block">（檔案大小請勿超過 2 MB）</p>
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_audioguide">導覽語音</label>
                    <div class="col-md-8">
                        <input id="item_audioguide" name="item_audioguide" class="input-file" type="file" accept=".mp3">
                        <p class="help-block">（檔案大小請勿超過 5 MB）</p>
                    </div>
                </div>

                <!-- Select Basic -->
                <div id="ib_select_block" class="form-group">
                    <label class="col-md-2 control-label" for="exh_ibeacon">連結iBeacon</label>
                    <div class="col-md-8">
                        <?= form_dropdown('item_ibeacon', $ibeacons, '', "id='item_ibeacon' class='form-control'") ?>
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_push">推播文字</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="item_push" name="item_push"></textarea>
                        <p class="help-block">（推播文字將顯示於使用者手機推播通知）</p>
                    </div>
                </div>

            </fieldset>
            <div class="col-md-offset-2 col-md-8">
                <button type="button" id="add-basic-btn" name="add-basic-btn" class="btn btn-block btn-info">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>新增基本資訊欄位
                </button>
                <br>
                <div id="note_for_basic_fields" class="text-muted" style="display: none;">
                    <p>自訂詳細解說欄位注意事項：</p>
                    <ul>
                        <li>最多新增三個詳細解說欄位。</li>
                        <li>自訂欄位將顯示於原有欄位之後。</li>
                        <li>欄位名稱與內容皆為必填，若其中一項留白將動刪除該欄位（欲刪除欄位，請將該欄位名稱或內容留白即可）。</li>
                        <li>欄位名稱建議長度為四個字以內。</li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <br>
            <fieldset id="item_detail_info">
                <div class="col-md-12">
                    <legend>展品詳細資訊
                        <span style="font-size:15px; color:#AAA;">顯示於展品導覽詳細說明頁面</span>
                    </legend>
                </div>
                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_description">展品詳細解說</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="item_description" name="item_description" required=""></textarea>
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_more_pics">其他圖片</label>
                    <div class="col-md-8">
                        <input id="item_more_pics" name="item_more_pics[]" class="input-file" type="file" multiple="true" accept="image/*" required="">
                        <p class="help-block">（檔案大小請勿超過 2 MB，至多五張）</p>
                    </div>
                </div>
            </fieldset>

            <div class="col-md-offset-2 col-md-8">
                <button type="button" id="add-detail-btn" name="add-detail-btn" class="btn btn-block btn-info">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>新增詳細解說欄位
                </button>
                <br>
                <div id="note_for_detail_fields" class="text-muted" style="display: none;">
                    <p>自訂詳細解說欄位注意事項：</p>
                    <ul>
                        <li>最多新增三個詳細解說欄位。</li>
                        <li>自訂欄位將顯示於原有欄位之後。</li>
                        <li>欄位名稱與內容皆為必填，若其中一項留白將動刪除該欄位（欲刪除欄位，請將該欄位名稱或內容留白即可）。</li>
                        <li>欄位名稱建議長度為四個字以內。</li>
                    </ul>
                </div>
            </div>

            <div class="form-group text-center col-md-12 margin-top-30">
                <button type="button" id="preview" name="preview" class="btn btn-default">預覽</button>
                <button type="submit" id="submit" name="submit" class="btn btn-primary">送出展品資訊</button>
                <button type="button" id="item-cancel-btn" name="item-cancel-btn" class="btn btn-default">取消</button>
            </div>

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
        $(document.body).off('click.add_basic_col', '#add-basic-btn');
        $(document.body).on('click.add_basic_col', '#add-basic-btn', function() {
            $('#item_basic_info').append(function() {
                var count = $('.custom-basic-field').length;
                var index = count + 1;
                var custom_field_block =
                    "<div class='well margin-top-30 custom-basic-field'><div class='form-group'><label class='col-md-2 control-label' for='basic_field_name_" + index +
                    "'>自訂欄位名稱</label><div class='col-md-3'><input id='basic_field_name_" + index + "' name='basic_field_name_" + index +
                    "' type='text' placeholder='請輸入欄位名稱' class='form-control input-md'></div></div><div class='form-group'><label class='col-md-2 control-label' for='basic_field_value_" + index +
                    "'>欄位內容</label><div class='col-md-8'><textarea class='form-control' id='basic_field_value_" + index + "' name='basic_field_value_" + index + "'></textarea></div></div></div>";
                if (count < 3) {
                    $('#note_for_basic_fields').show();
                    return custom_field_block;
                } else {
                    $('#system-message').html('最多新增三個基本欄位！');
                    $('#system-message').show();
                    $('#system-message').delay(2000).fadeOut();
                }
            });
            $.scrollTo($('#item_basic_info > div.custom-basic-field').last(), 300, {
                offset: -10
            });
        });
        $(document.body).off('click.add_detail_col', '#add-detail-btn');
        $(document.body).on('click.add_detail_col', '#add-detail-btn', function() {
            $('#item_detail_info').append(function(n) {
                var count = $('.custom-detail-field').length;
                var index = count + 1;
                var custom_field_block = "<div class='well margin-top-30 custom-detail-field'><div class='form-group'><label class='col-md-2 control-label' for='detail_field_name_" + index +
                    "'>自訂欄位名稱</label><div class='col-md-3'><input id='detail_field_name_" + index + "' name='detail_field_name_" + index +
                    "' type='text' placeholder='請輸入欄位名稱' class='form-control input-md'></div></div><div class='form-group'><label class='col-md-2 control-label' for='detail_field_value_" + index +
                    "'>欄位內容</label><div class='col-md-8'><textarea class='form-control' id='detail_field_value_" + index + "' name='detail_field_value_" + index + "'></textarea></div></div></div>";
                if (count < 3) {
                    $('#note_for_detail_fields').show();
                    return custom_field_block;
                } else {
                    $('#system-message').html('最多新增三個詳細欄位！');
                    $('#system-message').show();
                    $('#system-message').delay(2000).fadeOut();
                }
            });
            $.scrollTo($('#item_detail_info > div.custom-detail-field').last(), 300, {
                offset: -10
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
            minFileCount: 1,
            maxFileCount: 5,
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
        $('#item_add_form').ajaxForm({
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
                        url: '/iBeaGuide/items/print_item_list',
                        type: "GET",
                        dataType: 'html',
                        success: function(html_block) {
                            $('#item_list_block').html(html_block);
                            $('#item_form_block').empty();
                            $('[data-toggle="table"]').bootstrapTable();
                            $('#system-message').html('完成');
                            $('#system-message').fadeOut();
                            $.scrollTo($('#add-item-btn'), 500, {
                                offset: -10
                            });
                        }
                    });
                    $('#system-message').html('完成');
                    $('#system-message').fadeOut();
                }
            }
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