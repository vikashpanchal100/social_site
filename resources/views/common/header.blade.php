<?php $sBaseUrl = url('/'); ?>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="_token" content="{!! csrf_token() !!}" />
    <title>Dashboard - SB Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css?v=<?php echo config('constants.CSS_VERSION'); ?>" crossorigin="anonymous">
    <link href="<?php echo config('app.admin_asset_url'); ?>css/common_admin.css?v=<?php echo config('constants.CSS_VERSION'); ?>" rel="stylesheet" />
    <link href="<?php echo config('app.admin_asset_url'); ?>css/jquery.dataTables.min.css?v=<?php echo config('constants.CSS_VERSION'); ?>" rel="stylesheet" />
    <link href="<?php echo config('app.admin_asset_url'); ?>css/styles.css?v=<?php echo config('constants.CSS_VERSION'); ?>" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js?v=<?php echo config('constants.JS_VERSION'); ?>" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js?v=<?php echo config('constants.JS_VERSION'); ?>" crossorigin="anonymous"></script>
    <link href="<?php echo config('app.asset_url'); ?>css/bootstrap-datepicker.standalone.min.css?v=<?php echo config('constants.CSS_VERSION'); ?>" rel="stylesheet">
    <script>let sBaseUrl = '<?php echo $sBaseUrl; ?>'</script>
</head>
