<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">使用者資料</h4>
    </div>
    <div id="form_alert" class="alert alert-danger" role="alert" style="display: none"></div>
    <form id="user_info_form" class="form-horizontal" action="/iBeaGuide/ibeacons/add_ibeacon_action" method="post">
        <fieldset>
            <div class="modal-body">

                <div class="form-group">
                    <label class="col-md-2 control-label">姓名</label>
                    <label class="col-md-8 control-label"><?= $user->name ?></label>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">性別</label>
                    <label class="col-md-8 control-label"><?= $user->gender ?></label>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">生日</label>
                    <label class="col-md-8 control-label"><?= $user->birthday ?></label>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Email</label>
                    <label class="col-md-8 control-label"><?= $user->email ?><a href="mailto:<?= $user->email ?>"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a></label>
                </div>



        </fieldset>
    </form>
</div>
<script type="text/javascript">
    $('#user_info_form').ready(function() {


    });
</script>
