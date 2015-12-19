
<div class="panel panel-info panel-form">
    <div class="panel-heading">
        <span class="h4">新增精選主題</span>
    </div>
    <div class="panel-body">
        <div id="form_alert" class="alert alert-danger" role="alert" style="display: none"></div>
        <form id="topic_add_form" class="form-horizontal" action="/iBeaGuide/topics/add_topic_action" method="post">
            <fieldset>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="topic_title">精選主題標題</label>
                    <div class="col-md-8">
                        <input id="topic_title" name="topic_title" type="text" placeholder="" class="form-control input-md" required="">
                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="topic_exh">所屬展覽</label>
                    <div class="col-md-8">
                        <input id="topic_exh" type="hidden" name="topic_exh" value="<?= $exhibitions->id ?>">
                        <input id="topic_exh_title" type="text" name="topic_exh_title" class="form-control input-md" value="<?= $exhibitions->title ?>" disabled="">
                        <!-- < form_dropdown('topic_exh', $exhibitions, '', "id='topic_exh' class='form-control'") ?> -->
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
                        <textarea class="form-control" id="topic_description" name="topic_description"></textarea>
                    </div>
                </div>

                <!--  路線排序 -->
                <div class="col-md-5">
                    <legend>已連結iBeacon展品</legend>
                    <div class="well clearfix">
                        <ul id="items_list" class="connectedSortable">
                            <?php
                                foreach ($linked_items as $item) {
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
                        右區精選主題
                    </p>
                </div>
                <div class="col-md-5">
                    <legend>精選主題展品</legend>
                    <div class="well clearfix">
                        <ul id="in_topic_list" class="connectedSortable">
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="clearfix"></div>
                <!-- Button Group -->
                <div class="form-group text-center">
                    <button id="preview" type="button" name="preview" class="btn btn-default">預覽</button>
                    <button id="submit" type="submit" name="submit" class="btn btn-primary">送出精選主題資訊</button>
                    <button id="topic-cancel-btn" type="button" name="topic-cancel-btn" class="btn btn-default">取消</button>
                </div>

            </fieldset>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#topic_add_form').ready(function() {
        $("#items_list, #in_topic_list").sortable({
            connectWith: ".connectedSortable",
            cursor: "move",
            receive: function(event, ui) {
                var this_item_id = $(ui.item).attr('data-item-id');
                if($(event.target).is("#in_topic_list")) {
                    $.ajax({
                        url: '/iBeaGuide/topics/add_/' + comment_user_id,
                        type: "GET",
                        dataType: "html",
                        beforeSend: function(xhr) {
                            $('#system-message').html('處理中...');
                            $('#system-message').show();
                        },
                        success: function(html_block) {
                            $('#iBeaGuide-modal-block').html(html_block);
                            $('#iBeaGuide-modal').modal('show');
                            $('#system-message').html('完成');
                            $('#system-message').fadeOut();
                        }
                    });
                } else if ($(event.target).is("#items_list")) {

                }
            }
        }).disableSelection();

        $('#topic_main_pic').fileinput({
            language: 'zh-TW',
            showUpload: false,
            minFileCount: 1,
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

        $('#topic_add_form').ajaxForm({
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
                        url: '/iBeaGuide/topics/print_topic_list',
                        type: "GET",
                        dataType: 'html',
                        success: function(html_block) {
                            $('#topic_list_block').html(html_block);
                            $('#iBeaGuide-modal-block').empty();
                            $('#iBeaGuide-modal').modal('hide');
                            $('[data-toggle="table"]').bootstrapTable();
                            $('#system-message').html('完成');
                            $('#system-message').fadeOut();
                            $.scrollTo($('#add-topic-btn'), 500, {
                                offset: -10
                            });
                        }
                    });
                    $('#system-message').html('完成');
                    $('#system-message').fadeOut();
                }
            }
        });
    });
</script>
