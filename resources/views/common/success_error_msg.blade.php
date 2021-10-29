<?php
$bStatus = session('status');
$sMessage = session('message');
if(isset($bStatus) && $bStatus === false && $sMessage !== ''){
?>
<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo session('message'); ?>
</div>
<?php
}else if(isset($bStatus) && $bStatus === true && $sMessage !== ''){
?>
<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo session('message'); ?>
</div>
<?php
}
?>
