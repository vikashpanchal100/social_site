<?php
$aUserData = isset($aUserData) && $aUserData ? $aUserData :'';
?>
<div class="row">
    <div class="col-md-12" style="padding-bottom: 20px;">
        <img style="height:100%" width="100%" src="<?php echo url('/images/status_images/'.$aUserData['post_status_image']) ?>" />
    </div>
    <div class="col-md-12" style="background: grey; text-align: center;">
        <p><?php echo $aUserData['post_status_content']; ?></p>
    </div>
</div>
