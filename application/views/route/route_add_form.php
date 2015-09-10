<?php echo validation_errors(); ?>
<div class="panel panel-info panel-form">
    <div class="panel-heading">
        <span class="h4">新增推薦路線</span>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="exhibitions/add_route_action" method="post">
            <fieldset>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="route_title">路線標題</label>
                    <div class="col-md-8">
                        <input id="route_title" name="route_title" type="text" placeholder="" class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="route_exh">所屬展覽</label>
                    <div class="col-md-8">
                        <select id="route_exh" name="route_exh" class="form-control">
                            <option value="1">展覽 A</option>
                            <option value="2">展覽 B</option>
                        </select>
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="route_main_pic">主要圖片</label>
                    <div class="col-md-2">
                        <input id="route_main_pic" name="route_main_pic" class="input-file" type="file">
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="route_description">路線說明</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="route_description" name="route_description"></textarea>
                    </div>
                </div>

                <!--  路線排序 -->
                <div class="col-md-5">
                    <legend>已連結iBeacon展品</legend>
                    <ol id="items_list" class="connectedSortable">
                        <li class="ui-state-default">Item 1</li>
                        <li class="ui-state-default">Item 2</li>
                        <li class="ui-state-default">Item 3</li>
                        <li class="ui-state-default">Item 4</li>
                        <li class="ui-state-default">Item 5</li>
                    </ol>
                </div>
                <div class="col-md-2" style="margin-top: 100px;">
                    <p class="text-center">
                        <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    </p>
                    <p class="text-center">
                        拖曳展品排序
                    </p>
                </div>
                <div class="col-md-5">
                    <legend>路線排序</legend>
                    <div class="well">
                        <div class="clearfix" style="">
                            <p id="route_start_label" class="in-route-label">
                                路線開始
                            </p>
                            <p class='text-center'><span class='glyphicon glyphicon-arrow-down'></span></p>
                            <ol id="in_route_list" class="connectedSortable">
                                <li class="ui-state-highlight in-route-item">Item 1</li>
                                <li class="ui-state-highlight in-route-item">Item 2</li>
                                <li class="ui-state-highlight in-route-item">Item 3</li>
                                <li class="ui-state-highlight in-route-item">Item 4</li>
                                <li class="ui-state-highlight in-route-item">Item 5</li>
                            </ol>
                            <p class='text-center'><span class='glyphicon glyphicon-arrow-down'></span></p>
                            <p id="route_start_label" class="in-route-label">
                                路線結束
                            </p>
                        </div>
                    </div>
                </div>
                <script>
                    $("#items_list, #in_route_list").sortable({
                        connectWith: ".connectedSortable",
                        dropOnEmpty: false,
                        cursor: "move",
                        start: function(event, ui) {
                            $('#in_route_list').css('list-style-type', 'none');
                        },
                        stop: function(event, ui) {
                            $('#in_route_list').css('list-style-type', 'decimal');
                        }
                    }).disableSelection();
                </script>

                <!-- Button Group -->
                <div class="form-group text-center">
                    <button id="preview" name="preview" class="btn btn-default">預覽</button>
                    <button id="submit" name="submit" class="btn btn-primary">送出路線資訊</button>
                    <button id="cancel" name="cancel" class="btn btn-default">取消</button>
                </div>

            </fieldset>
        </form>
    </div>
</div>
