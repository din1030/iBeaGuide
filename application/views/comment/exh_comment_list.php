<legend>
    <?= $title ?>
</legend>
<div id="comment_list_block">
    <?= $this->table->generate($comments); ?>
</div>
<?php $this->table->clear(); ?>

<script type="text/javascript">
    $('#comment_list_block').ready(function() {

        $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding','8px');

        $.pjax.defaults.timeout = 5000
        $(document).pjax('a[data-pjax]', '#pjax-container');
        $(document).on('pjax:complete', function() {
            $('[data-toggle="table"]').bootstrapTable();
            $('div.sortable.both:last').removeClass('th-inner sortable both').css('padding','8px');
        });

        $(document.body).off('click.get_user_info', '.user-info-btn');
        $(document.body).on('click.get_user_info', '.user-info-btn', function() {
            var comment_user_id = $(this).attr('data-user-id');
            $.ajax({
                url: '/iBeaGuide/comments/get_user_info_modal_form/' + comment_user_id,
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
        });

    });
</script>
