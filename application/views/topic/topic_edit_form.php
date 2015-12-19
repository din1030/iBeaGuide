
<div class="panel panel-info panel-form">
    <div class="panel-heading">
        <span class="h4">編輯精選主題資訊</span>
    </div>
    <div class="panel-body">
        <div id="form_alert" class="alert alert-danger" role="alert" style="display: none"></div>
        <form id="topic_edit_form" class="form-horizontal" action="/iBeaGuide/topics/edit_topic_action" method="post">
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
                        <ul id="items_list" class="connectedSortable">
                        </ul>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 100px;">
                    <p class="text-center">
                        連結 iBeacon 之展品<br>
                        才能加入精選主題
                    </p>
                    <p class="text-center">
                        <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    </p>
                    <p class="text-center">
                        拖曳展品加入<br>
                        或移出精選主題
                    </p>
                </div>
                <div class="col-md-5">
                    <legend>路線排序</legend>
                    <div class="well clearfix">
                        <ul id="in_topic_list" class="connectedSortable">
                        </ul>
                    </div>
                </div>

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
    $('#topic_edit_form').ready(function() {
        $("#items_list, #in_topic_list").sortable({
            connectWith: ".connectedSortable",
            cursor: "move",
            // start: function(event, ui) {
            //     $('#in_topic_list').css('list-style-type', 'none');
            // },
            stop: function(event, ui) {

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
