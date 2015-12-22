
<div class="panel panel-info panel-form">
    <div class="panel-heading">
        <span class="h4">編輯精選主題資訊</span>
    </div>
    <div class="panel-body">
        <div id="form_alert" class="alert alert-danger" role="alert" style="display: none"></div>
        <form id="topic_edit_form" class="form-horizontal" action="/iBeaGuide/topics/edit_topic_action" method="post">
            <input id="topic_id" type="hidden" name="topic_id" class="form-control input-md" value="<?= $topic->id ?>">
            <fieldset>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="topic_title">精選主題名稱</label>
                    <div class="col-md-8">
                        <input id="topic_title" name="topic_title" type="text" placeholder="" class="form-control input-md" required="" value="<?= $topic->title; ?>">

                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="topic_exh">所屬展覽</label>
                    <div class="col-md-8">
                        <input id="topic_exh_title" type="text" name="topic_exh_title" class="form-control input-md" value="<?= $topic->exh_title ?>" disabled="">
                        <!-- < form_dropdown('topic_exh', $exhibitions, $topic->exh_id, "id='topic_exh' class='form-control'") ?> -->
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="topic_main_pic">主要圖片</label>
                    <div class="col-md-8">
                        <input id="topic_main_pic" name="topic_main_pic[]" class="input-file" type="file" accept="image/*" multiple="true">
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="topic_description">精選主題說明</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="topic_description" name="topic_description"><?= $topic->description; ?></textarea>
                    </div>
                </div>

                <!--  路線排序 -->
                <div class="col-md-5">
                    <legend>已連結iBeacon展品</legend>
                    <div class="well clearfix">
                        <ul id="items_list" class="connectedSortable text-center">
                            <?php
                                foreach ($not_in_topic_items as $item) {
                                    echo "<li class='ui-state-default' data-item-id='".$item['id']."' >".$item['title']."</li>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 100px;">
                    <p class="text-center">
                        左區列出所選展覽下<br>
                        已與 iBeacon 連結<br>
                        之展品

                    </p>
                    <p class="text-center">
                        <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    </p>
                    <p class="text-center">
                        拖曳展品加入或移出<br>
                        右區精選主題，不需<br>
                        送出表單即會更新
                    </p>
                </div>
                <div class="col-md-5">
                    <legend>精選主題展品</legend>
                    <div class="well clearfix">
                        <ul id="in_topic_list" class="connectedSortable text-center">
                            <?php
                                foreach ($in_topic_items as $item) {
                                    echo "<li class='ui-state-default' data-item-id='".$item['item_id']."' >".$item['title']."</li>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>

                <!-- Button Group -->
                <div class="form-group text-center">
                    <button id="preview" type="button" name="preview" class="btn btn-default" disabled="">預覽</button>
                    <button id="submit" type="submit" name="submit" class="btn btn-primary">送出精選主題資訊</button>
                    <button id="topic-cancel-btn" type="button" name="topic-cancel-btn" class="btn btn-default">取消</button>
                </div>

            </fieldset>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#topic_edit_form').ready(function() {

        $("#items_list, #in_topic_list").sortable({
            connectWith: ".connectedSortable",
            cursor: "move",
            start: function (event, ui) {
                if($(ui.item).is("#in_topic_list li")) {
                    $("#items_list").css('border', '2px dashed lightsteelblue').css('padding', '10px');
                } else {
                    $("#in_topic_list").css('border', '2px dashed lightsteelblue').css('padding', '10px');
                }
            },
            stop: function (event, ui) {
                $("#items_list, #in_topic_list").css('border', '');
            },
            receive: function(event, ui) {
                var this_topic_id = $("#topic_id").val();
                var this_item_id = $(ui.item).attr('data-item-id');
                var action_type = '';
                if($(event.target).is("#in_topic_list")) {
                    // $(ui.item).append("<input type='hidden' name='items[]' value='"+ this_item_id +"' />")
                    action_type = 'add_topic_item_action';
                } else if ($(event.target).is("#items_list")) {
                    // $(ui.item).children("input").remove();
                    action_type = 'delete_topic_item_action';
                }

                $.ajax({
                    url: '/iBeaGuide/topics/' + action_type,
                    type: "POST",
                    data: {
                        topic_id: this_topic_id,
                        item_id: this_item_id
                    },
                    // dataType: "html",
                    beforeSend: function(xhr) {
                        $('#system-message').html('處理中...');
                        $('#system-message').show();
                    },
                    success: function(result) {
                        if (!result) {
                            $('#system-message').html('資料處理異常，請重新操作');
                            $('#system-message').delay(2000).fadeOut(500);
                            return;
                        }
                        $('#system-message').html('完成');
                        $('#system-message').fadeOut();
                    }
                });

            }
        }).disableSelection();

        $('#topic_main_pic').fileinput({
            language: 'zh-TW',
            showUpload: false,
            maxFileCount: 1,
            allowedFileTypes: ["image"],
            previewFileType: 'image'
        });

        $(document.body).off('click.topic_cancel', '#topic-cancel-btn');
        $(document.body).on('click.topic_cancel', '#topic-cancel-btn', function() {
            $('#topic_form_block').empty();
            $.scrollTo($('#add-topic-btn'), 500, {
                offset: -10
            });
        });
    });
</script>
