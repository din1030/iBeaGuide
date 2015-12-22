<div class="panel panel-info panel-form">
    <div class="panel-heading">
        <span class="h4">新增設施資訊</span>
    </div>
    <div class="panel-body">
        <div id="form_alert" class="alert alert-danger" role="alert" style="display: none"></div>
        <form id="fac_add_form" class="form-horizontal" action="/iBeaGuide/facilities/add_facility_action" method="post" enctype="multipart/form-data">
            <fieldset>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fac_exh">所屬展覽</label>
                    <div class="col-md-8">
                        <?= form_dropdown('fac_exh', $exhibitions, '', "id='fac_exh' class='form-control'") ?>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fac_title">設施名稱</label>
                    <div class="col-md-8">
                        <input id="fac_title" name="fac_title" type="text" placeholder="" class="form-control input-md" required>
                    </div>
                </div>

                <!-- Select Basic -->
                <!-- <div class="form-group">
                    <label class="col-md-2 control-label" for="fac_ibeacon">連結 iBeacon</label>
                    <div class="col-md-8">
                        <?= form_dropdown('fac_ibeacon', $ibeacons, '', "id='fac_ibeacon' class='form-control'") ?>
                    </div>
                </div> -->

                <!-- Textarea -->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fac_push">推播文字</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="fac_push" name="fac_push"></textarea>
                        <p class="help-block">（推播文字將顯示於使用者手機推播通知）</p>
                    </div>
                </div>

                <!-- Button Group -->
                <div class="form-group text-center">
                    <button type="button" id="fac_preview_btn" name="fac_preview_btn" class="btn btn-default" disabled="">預覽</button>
                    <button type="submit" id="fac_submit_btn" name="fac_submit_btn" class="btn btn-primary">送出設施資訊</button>
                    <button type="button" id="fac_cancel_btn" name="fac_cancel_btn" class="btn btn-default">取消</button>
                </div>

            </fieldset>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#fac_add_form').ready(function() {

        $('form').ajaxForm({
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
                        url: 'facilities/print_fac_list',
                        type: "GET",
                        dataType: 'html',
                        success: function(html_block) {
                            $('#fac_list_block').html(html_block);
                            $('#fac_form_block').empty();
                            $('[data-toggle="table"]').bootstrapTable();
                            $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding', '8px');
                            $('#system-message').html('完成');
                            $('#system-message').fadeOut();
                            $.scrollTo($('#add-fac-btn'), 500, {
                                offset: -10
                            });
                        }
                    });
                    $('#system-message').html('完成');
                    $('#system-message').fadeOut();
                }
            }
        });

        $(document.body).off('click.fac_cancel', '#fac_cancel_btn');
        $(document.body).on('click.fac_cancel', '#fac_cancel_btn', function() {
            $('#fac_form_block').empty();
            $.scrollTo($('#add_fac_btn'), 500, {
                offset: -10
            });
        });

    });
</script>
