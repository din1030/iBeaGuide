<?php echo validation_errors(); ?>

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">編輯展區</h4>
    </div>
    <form class="form-horizontal" action="EditSectionAction" method="post">
        <fieldset>
            <div class="modal-body">
                <input id="sec_id" type="hidden" name="sec_id" value="<?= $sec->id ?>">
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="sec_title">展區標題</label>
                    <div class="col-md-6">
                        <input id="sec_title" name="sec_title" type="text" placeholder="" class="form-control input-md" required="" value="<?= $sec->title ?>"/>
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="sec_description">展區說明</label>
                    <div class="col-md-6">
                        <textarea class="form-control" id="sec_description" name="sec_description"><?= $sec->description ?></textarea>
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="sec_main_pic">主要圖片</label>
                    <div class="col-md-4">
                        <input id="sec_main_pic" name="sec_main_pic" class="input-file" type="file">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">新增展區</button>
            </div>
        </fieldset>
    </form>
</div>
