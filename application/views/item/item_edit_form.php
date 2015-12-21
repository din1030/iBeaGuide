<div class="panel panel-info panel-form">
    <div class="panel-heading">
        <span class="h4">編輯「
            <?= $item->title; ?>」展品</span>
    </div>
    <div class="panel-body">
        <div id="form_alert" class="alert alert-danger" role="alert" style="display: none"></div>
        <form id="item_edit_form" class="form-horizontal" action="/iBeaGuide/items/edit_item_action" method="post" enctype="multipart/form-data">
            <fieldset id="item_basic_info">
                <input id="item_id" type="hidden" name="item_id" value="<?= $item->id ?>">
                <div class="col-md-12">
                    <legend>展品基本資訊
                        <span style="font-size:15px; color:#AAA;">顯示於展品導覽預設頁面</span>
                    </legend>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_exh">所屬展覽</label>
                    <div class="col-md-8">
                        <?= form_dropdown('item_exh', $exhibitions, $item->exh_id, "id='item_exh' class='form-control'") ?>
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
                        <input id="item_title" name="item_title" type="text" class="form-control input-md" required="" value="<?= $item->title; ?>">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_subtitle">展品副標</label>
                    <div class="col-md-8">
                        <input id="item_subtitle" name="item_subtitle" type="text" placeholder="" class="form-control input-md" value="<?= $item->subtitle; ?>">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_creator">展品作者</label>
                    <div class="col-md-8">
                        <input id="item_creator" name="item_creator" type="text" placeholder="" class="form-control input-md" required="" value="<?= $item->creator; ?>">
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_brief">展品簡介</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="item_brief" name="item_brief" required=""><?= $item->brief; ?></textarea>
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_main_pic">主要圖片</label>
                    <div class="col-md-8">
                        <input id="item_main_pic" name="item_main_pic[]" class="input-file" type="file" accept="image/*">
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
                <!-- <div id="ib_select_block" class="form-group">
                    <label class="col-md-2 control-label" for="exh_ibeacon">連結iBeacon</label>
                    <div class="col-md-8">
                        <?= form_dropdown('item_ibeacon', $ibeacons, $item->ibeacon_id, "id='item_ibeacon' class='form-control'") ?>
                    </div>
                </div> -->
                
                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_push">推播文字</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="item_push" name="item_push"><?= $item->push_content; ?></textarea>
                        <p class="help-block">（推播文字將顯示於使用者手機推播通知）</p>
                    </div>
                </div>
                <!-- Show customed basic fields  -->
                <?php
                    if (!empty($basic_fields)) {
                        for ($i = 0; $i < count($basic_fields); ++$i) {
                            ?>
                    <div class="well margin-top-30 custom-basic-field">
                        <div id="field_alert" class="alert alert-danger" role="alert" style="display: none"></div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="existing_field_name">自訂欄位名稱</label>
                            <div class="col-md-3">
                                <input id="existing_field_name" name="existing_field_name" type="text" placeholder="請輸入欄位名稱" class="form-control input-md" data-field-id="<?= $basic_fields[$i]->id ?>" value="<?= $basic_fields[$i]->field_name ?>" readonly>
                            </div>
                            <div class="col-md-5" >
                                <p id="field-help-block" class="help-block text-right" style="display: none">（既有自訂欄位送出即直接更新，不需送出展品表單）</p>
                            </div>
                            <div class="col-md-2 text-right">
                                <button id="edit-field-btn" type="button" name="edit_field_btn" class="btn btn-primary edit-field-btn"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                                <button id="del-field-btn" type="button" name="del_field_btn" class="btn btn-danger del-field-btn" data-field-id="<?= $basic_fields[$i]->id ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="existing_field_value">欄位內容</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="existing_field_value" name="existing_field_value" data-field-id="<?= $basic_fields[$i]->id ?>" readonly><?= $basic_fields[$i]->field_value ?></textarea>
                            </div>
                            <div id="field-btn-group" class="col-md-2 text-right" style="display: none">
                                <button id="submit-field-btn" type="button" name="submit_field_btn" class="btn btn-primary submit-field-btn" data-field-id="<?= $basic_fields[$i]->id ?>">送出</button>
                                <button id="cancel-field-btn" type="button" name="cancel_field_btn" class="btn btn-default cancel-field-btn">取消</button>
                            </div>
                        </div>
                    </div>
                    <?php

                        }
                    }
                ?>

            </fieldset>
            <div class="col-md-offset-2 col-md-8">
                <button type="button" id="add-basic-btn" name="add-basic-btn" class="btn btn-block btn-info">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>新增基本資訊欄位
                </button>
                <br>
                <div id="note_for_basic_fields" class="text-muted" style="display: none;">
                    <p>自訂基本資訊欄位注意事項：</p>
                    <ul>
                        <li>最多新增三個基本資訊欄位。</li>
                        <li>自訂欄位將顯示於原有欄位之後。</li>
                        <li>欄位名稱與內容皆為必填。</li>
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
                        <textarea class="form-control" id="item_description" name="item_description" required=""><?= $item->description; ?></textarea>
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="item_more_pics">其他圖片</label>
                    <div class="col-md-8">
                        <input id="item_more_pics" name="item_more_pics[]" class="input-file" type="file" multiple="true" accept="image/*">
                        <p class="help-block">（檔案大小請勿超過 2 MB，至多五張）</p>
                    </div>
                </div>
                <!-- Show customed basic fields  -->
                <?php
                    if (!empty($detail_fields)) {
                        for ($i = 0; $i < count($detail_fields); ++$i) {
                            ?>
                            <div class="well margin-top-30 custom-detail-field">
                                <div id="field_alert" class="alert alert-danger" role="alert" style="display: none"></div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="existing_field_name">自訂欄位名稱</label>
                                    <div class="col-md-3">
                                        <input id="existing_field_name" name="existing_field_name" type="text" placeholder="請輸入欄位名稱" class="form-control input-md" data-field-id="<?= $detail_fields[$i]->id ?>" value="<?= $detail_fields[$i]->field_name ?>" readonly>
                                    </div>
                                    <div class="col-md-5" >
                                        <p id="field-help-block" class="help-block text-right" style="display: none">（既有自訂欄位送出即直接更新，不需送出展品表單）</p>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <button id="edit-field-btn" type="button" name="edit_field_btn" class="btn btn-primary edit-field-btn"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                                        <button id="del-field-btn" type="button" name="del_field_btn" class="btn btn-danger del-field-btn" data-field-id="<?= $basic_fields[$i]->id ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="existing_field_value">欄位內容</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" id="existing_field_value" name="existing_field_value" data-field-id="<?= $detail_fields[$i]->id ?>" readonly><?= $detail_fields[$i]->field_value ?></textarea>
                                    </div>
                                    <div id="field-btn-group" class="col-md-2 text-right" style="display: none">
                                        <button id="submit-field-btn" type="button" name="submit_field_btn" class="btn btn-primary submit-field-btn" data-field-id="<?= $basic_fields[$i]->id ?>">送出</button>
                                        <button id="cancel-field-btn" type="button" name="cancel_field_btn" class="btn btn-default cancel-field-btn">取消</button>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                ?>
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
    $('#item_edit_form').ready(function() {
        $(document.body).off('change.item_exh', '#item_exh');
        $(document.body).on('change.item_exh', '#item_exh', function() {
            var exh_selected = $('#item_exh').val();
            $.ajax({
                url: '/iBeaGuide/items/print_exh_sec_menu/' + exh_selected,
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
                    "<div class='well margin-top-30 custom-basic-field'>" +
                    "<button type='button' class='close custom-filed-close' aria-label='Close'><span aria-hidden='true'>" + "&times" + ";</span></button>" +
                    "<div class='form-group'><label class='col-md-2 control-label' for='basic_field_name'>自訂欄位名稱</label>" +
                    "<div class='col-md-3'><input id='basic_field_name' name='basic_field_name[]' type='text' placeholder='請輸入欄位名稱' class='form-control input-md' required=''></div></div>" +
                    "<div class='form-group'><label class='col-md-2 control-label' for='basic_field_value'>欄位內容</label>" +
                    "<div class='col-md-8'><textarea class='form-control' id='basic_field_value' name='basic_field_value[]' required=''></textarea></div></div></div>";
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
                var custom_field_block =
                    "<div class='well margin-top-30 custom-detail-field'>" +
                    "<button type='button' class='close' aria-label='Close'><span aria-hidden='true'>" + "&times" + ";</span></button>" +
                    "<div class='form-group'><label class='col-md-2 control-label' for='detail_field_name'>自訂欄位名稱</label>" +
                    "<div class='col-md-3'><input id='detail_field_name' name='detail_field_name[]' type='text' placeholder='請輸入欄位名稱' class='form-control input-md' required=''></div></div>" +
                    "<div class='form-group'><label class='col-md-2 control-label' for='detail_field_value'>欄位內容</label>" +
                    "<div class='col-md-8'><textarea class='form-control' id='detail_field_value' name='detail_field_value[]' required=''></textarea></div></div></div>";
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
            // minFileCount: 1,
            maxFileCount: 1,
            allowedFileTypes: ["audio"],
            previewFileType: 'audio'
        });
        $('#item_edit_form').ajaxForm({
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
        $(document.body).off('click.edit_field', '.edit-field-btn');
        $(document.body).on('click.edit_field', '.edit-field-btn', function() {
            var this_field_name = $(this).parent().parent().find('#existing_field_name');
            var this_field_value = $(this).parent().parent().parent().find('#existing_field_value');
            $(this).prop('disabled', true);
            this_field_name.prop('readonly', false);
            this_field_value.prop('readonly', false);
            $(this).parent().parent().find('#field-help-block').show();
            $(this).parent().parent().parent().find('#field-btn-group').show();
        });
        $(document.body).off('click.delete_field', '.del-field-btn');
        $(document.body).on('click.delete_field', '.del-field-btn', function() {
            var this_field_id = $(this).attr('data-field-id');
            var this_field_title = $(this).parent().parent().find('#existing_field_name').val();
            var this_field_block = $(this).parent().parent().parent();
            BootstrapDialog.show({
                title: '注意！',
                message: '是否確認刪除「' + this_field_title + '」欄位資訊？',
                buttons: [{
                    label: '取消',
                    action: function(dialogRef) {
                        dialogRef.close();
                    }
                },
                {
                    label: '刪除',
                    cssClass: 'btn-danger',
                    action: function(dialogRef) {
                        $.ajax({
                            url: '/iBeaGuide/items/delete_field_action',
                            type: "POST",
                            //cache: false,
                            data: {
                                field_id: this_field_id
                            },
                            dataType: "html",
                            beforeSend: function(xhr) {
                                dialogRef.close();
                                $('#system-message').html('處理中...');
                                $('#system-message').show();
                            },
                            success: function() {
                                this_field_block.remove();
                                $('#system-message').html('完成');
                                $('#system-message').fadeOut();
                            }
                        });
                    }
                }]
            });
        });
        $(document.body).off('click.submit_field', '.submit-field-btn');
        $(document.body).on('click.submit_field', '.submit-field-btn', function() {
            var this_field_id = $(this).attr('data-field-id');
            var this_field_name = $(this).parent().parent().parent().find('#existing_field_name');
            var this_field_value = $(this).parent().parent().parent().find('#existing_field_value');
            var this_btn_group = $(this).parent();
            $.ajax({
                url: '/iBeaGuide/items/update_field_action',
                type: "POST",
                //cache: false,
                data: {
                    field_id: this_field_id,
                    field_name: this_field_name.val(),
                    field_value: this_field_value.val()
                },
                dataType: "html",
                beforeSend: function(xhr) {
                    $('#system-message').html('處理中...');
                    $('#system-message').show();
                },
                success: function(error) {
                    if (error) {
                        $('#field_alert').html(error);
                        $('#field_alert').show();
                        $('#system-message').fadeOut();
                    } else {
                        $('#form_alert').hide();
                        $('#form_alert').empty();
                        $('#system-message').html('完成');
                        $('#system-message').fadeOut();
                        this_field_name.prop('readonly', true);
                        this_field_value.prop('readonly', true);
                        this_btn_group.hide();
                    }
                }
            });

        });
        $(document.body).off('click.cancel_field', '.cancel-field-btn');
        $(document.body).on('click.cancel_field', '.cancel-field-btn', function() {
            var this_field_name = $(this).parent().parent().parent().find('#existing_field_name');
            var this_field_value = $(this).parent().parent().parent().find('#existing_field_value');
            $(this).parent().parent().parent().find('#edit-field-btn').prop('disabled', false);
            this_field_name.prop('readonly', true);
            this_field_value.prop('readonly', true);
            $(this).parent().parent().parent().find('#field-help-block').hide();
            $(this).parent().hide();
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
