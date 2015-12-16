
<?php
    if (!empty($exhibition)) {
    ?>  <legend>
            「<?= $exhibition->title ?>」：展區管理
            <button id="add_section_btn" type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-exh-id="<?= $exhibition->id ?>">新增展區</button>
        </legend>
        <div id="sec_list_block">
            <?= $this->table->generate($sections); ?>
        </div>
    <?php } else {
        echo "未輸入展覽編號或展覽編號不存在";
    }
    $this->table->clear();
?>
<script type="text/javascript">
    $(document).ready(function() {

        $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding','8px');

        $(document.body).off('click.add_section', '#add_section_btn');
        $(document.body).on('click.add_section', '#add_section_btn', function() {

            $.ajax({
                url: '/iBeaGuide/exhibitions/get_section_add_modal_form',
                type: "GET",
                data: {
                    exh_id: $(this).attr('data-exh-id')
                },
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

        });
        $(document.body).off('click.edit_section', '.edit-section-btn');
        $(document.body).on('click.edit_section', '.edit-section-btn', function() {

            $.ajax({
                url: '/iBeaGuide/exhibitions/get_section_edit_modal_form',
                type: "GET",
                data: {
                    sec_id: $(this).attr('data-sec-id')
                },
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

        });

        $(document.body).off('click.delete_sec', '.del-section-btn');
        $(document.body).on('click.delete_sec', '.del-section-btn', function() {
            var this_sec_id = $(this).attr('data-sec-id');
            var this_sec_title = $(this).parent().parent().children('td').eq(1).html();
            BootstrapDialog.show({
                title: '注意！',
                message: '是否刪除「' + this_sec_title + '」展區？',
                buttons: [{
                    label: '取消',
                    action: function(dialogRef){
                        dialogRef.close();
                    }
                }, {
                    label: '刪除',
                    cssClass: 'btn-danger',
                    action: function(dialogRef) {
                        $.ajax({
                            url: '/iBeaGuide/exhibitions/delete_section_action',
                            type: "POST",
                            //cache: false,
                            data: {
                                sec_id: this_sec_id,
                                exh_id: '<?= $exhibition->id ?>'
                            },
                            dataType: "html",
                            beforeSend: function(xhr) {
                                dialogRef.close();
                                $('#system-message').html('處理中...');
                                $('#system-message').show();
                            },
                            success: function(html_block) {
                                $('#sec_list_block').html(html_block);
                                // $.scrollTo($('#add_sec_btn'), 500, {offset: -10});
                                $('#system-message').html('完成');
                                $('#system-message').fadeOut();
                                $('[data-toggle="table"]').bootstrapTable();
                            }
                        });
                    }
                }]
            });
        });

    });
</script>
