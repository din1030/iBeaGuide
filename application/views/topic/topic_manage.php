<legend>
    主題精選管理
    <button id="add-topic-btn" type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal">新增路線</button>
</legend>
<div id="topic_form_block"></div>
<div id="topic_list_block">
    <?= $this->table->generate($topics); ?>
</div>
<?php $this->table->clear(); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding','8px');

        $("#topic_list").bootstrapTable({
            sortName: "1"
        });

        $(document.body).off('click.add_topic_form', '#add-topic-btn');
        $(document.body).on('click.add_topic_form', '#add-topic-btn', function() {
            BootstrapDialog.show({
                title: '請選擇新增主題所屬之展覽',
                message: function(dialog) {
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad);

                    return $message;
                },
                data: {
                    'pageToLoad': '/iBeaGuide/exhibitions/print_exh_menu'
                },
                buttons: [{
                    label: '取消',
                    action: function(dialogRef){
                        dialogRef.close();
                    }
                },
                {
                    label: '確定',
                    cssClass: 'btn-primary',
                    action: function(dialogRef) {
                        dialogRef.close();
                        $.ajax({
                            url: '/iBeaGuide/topics/get_topic_add_form',
                            type: "GET",
                            //cache: false,
                            data: {
                                exh_id: $('#exh_menu').val()
                            },
                            dataType: "html",
                            beforeSend: function(xhr) {
                                $('#system-message').html('處理中...');
                                $('#system-message').show();
                            },
                            success: function(html_block) {
                                $('#topic_form_block').html(html_block);
                                $('#system-message').html('完成');
                                $('#system-message').fadeOut();
                            }
                        });
                    }
                }]
            });
        });

        $(document.body).off('click.edit_topic_form', '.edit-topic-btn');
        $(document.body).on('click.edit_topic_form', '.edit-topic-btn', function() {
            $.ajax({
                url: '/iBeaGuide/topics/get_topic_edit_form',
                type: "GET",
                //cache: false,
                data: {
                    topic_id: $(this).attr('data-topic-id')
                },
                dataType: "html",
                beforeSend: function(xhr) {
                    $('#system-message').html('處理中...');
                    $('#system-message').show();
                },
                success: function(html_block) {
                    $('#topic_form_block').html(html_block);
                    $('#system-message').html('完成');
                    $('#system-message').fadeOut();
                    $.scrollTo($('#add-topic-btn'), 500, {offset: -10});
                }
            });
        });
        $(document.body).off('click.delete_topic', '.del-topic-btn');
        $(document.body).on('click.delete_topic', '.del-topic-btn', function() {
            var this_topic_id = $(this).attr('data-topic-id');
            var this_topic_title = $(this).parent().parent().children('td').eq(1).html();
            BootstrapDialog.show({
                title: '注意！',
                message: '是否刪除「' + this_topic_title + '」主題？',
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
                            url: '/iBeaGuide/topics/delete_topic_action',
                            type: "POST",
                            //cache: false,
                            data: {
                                topic_id: this_topic_id
                            },
                            dataType: "html",
                            beforeSend: function(xhr) {
                                dialogRef.close();
                                $('#system-message').html('處理中...');
                                $('#system-message').show();
                            },
                            success: function(html_block) {
                                $('#topic_list_block').html(html_block);
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
