<?php
$sUserStatusUpdatedMessage = session('user_status_updated');
unsetSession('user_status_updated');
?>
<div class="modal" tabindex="-1" role="dialog" id="post_status_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Post Your Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="postStatusForm" method="POST" action="<?php echo url('/submit-status'); ?>" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label class="small mb-1" for="post_status_content">Write Something</label>
                        <textarea class="form-control py-4" id="post_status_content" name="post_status_content" placeholder="Write Something in your post..."></textarea>
                        <p class="form-error-text" id="post_status_content_error"></p>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="post_status_image">Upload Post Image</label>
                        <input class="form-control py-4" id="post_status_image" type="file" name="post_status_image">
                        <p class="form-error-text" id="post_status_image_error"></p>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="postStatusBtn" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<script>
    var sUserStatusUpdatedMessage = '<?php echo $sUserStatusUpdatedMessage && is_array($sUserStatusUpdatedMessage)&& count($sUserStatusUpdatedMessage) ? json_encode($sUserStatusUpdatedMessage): false; ?>';
</script>
