<?php
if(isset($aUserData) && isset($aUserData['user_id']) && $aUserData['user_id']){
$bAlreadyFollowing = isset($aUserData['isToFollowUser']) && $aUserData['isToFollowUser'];
?>
<div class="dropdown">
    <button class="btn btn-<?php echo $bAlreadyFollowing ? 'success':'secondary dropdown-toggle'; ?> " <?php echo $bAlreadyFollowing ? 'disabled':''; ?> type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $bAlreadyFollowing ? 'Already Following': 'Click to Follow';  ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="javascript:void(0)" onclick="followUser({'user_id': '<?php echo $aUserData['user_id']; ?>', 'name': '<?php echo $aUserData['name']; ?>'})">Follow This User</a>
    </div>
</div>
<?php
}
?>

