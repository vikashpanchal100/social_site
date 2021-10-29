<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js?v=<?php echo config('constants.JS_VERSION'); ?>"  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js?v=<?php echo config('constants.JS_VERSION'); ?>" crossorigin="anonymous"></script>
<script src="<?php echo config('app.admin_asset_url'); ?>js/scripts.js?v=<?php echo config('constants.JS_VERSION'); ?>"></script>
<script src="<?php echo config('app.asset_url'); ?>js/bootstrap-datepicker.min.js?v=<?php echo config('constants.JS_VERSION'); ?>"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
</script>
<script src="<?php echo config('app.admin_asset_url'); ?>js/jquery.dataTables.min.js?v=<?php echo config('constants.JS_VERSION'); ?>"></script>
<script src="<?php echo config('app.admin_asset_url'); ?>js/common_admin.js?v=<?php echo config('constants.JS_VERSION'); ?>"></script>
<script src="<?php echo config('app.admin_asset_url'); ?>js/ckeditor/ckeditor.js?v=<?php echo config('constants.JS_VERSION'); ?>"></script>
<script src="<?php echo config('app.admin_asset_url'); ?>js/ckeditor/adapters/jquery.js?v=<?php echo config('constants.JS_VERSION'); ?>"></script>

