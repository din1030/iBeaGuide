<legend>
    「<?= $exhibition->title ?>」：展區管理
    <button id="add_section_btn" type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-exh-id="<?= $exhibition->id ?>">新增展區</button>
    <!-- <a href="/iBeaGuide/sections/add" class="btn btn-primary btn-xs pull-right">新增展區</a> -->
</legend>

<?= $this->table->generate($sections); ?>
<?php $this->table->clear(); ?>

<script>
    // $('.header').ready(function() {

        $(document.body).off('click.add_section', '#add_section_btn');
        $(document.body).on('click.add_section', '#add_section_btn', function() {

            $.ajax({
                url: 'getCreateSectionModalFormAction',
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
                url: 'getEditSectionModalFormAction',
                type: "GET",
                data: {
                    sec_id: $(this).attr('data-id')
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
    // });
</script>
