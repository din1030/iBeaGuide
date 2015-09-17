<?php echo validation_errors(); ?>

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">新增展區</h4>
    </div>
    <form id="section_add_form" class="form-horizontal" action="/iBeaGuide/exhibitions/add_section_action" method="post" enctype="multipart/form-data">
        <fieldset>
            <div class="modal-body">
                <input id="exh_id" type="hidden" name="exh_id" value="<?= $exh_id ?>">
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="sec_title">展區標題</label>
                    <div class="col-md-8">
                        <input id="sec_title" name="sec_title" type="text" placeholder="" class="form-control input-md" required="">
                    </div>
                </div>

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="sec_description">展區說明</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="sec_description" name="sec_description"></textarea>
                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="sec_main_pic">主要圖片</label>
                    <div class="col-md-8">
                        <input id="sec_main_pic" name="sec_main_pic" class="input-file" type="file" accept="image/*" multiple="true">
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
<script type="text/javascript">
    $('#section_add_form').ready(function() {

        $('#sec_main_pic').fileinput({
            language: 'zh-TW',
            showUpload: false,
            maxFileCount: 3,
            allowedFileTypes: ["image"],
            previewFileType: 'image'
        });

    });
</script>
