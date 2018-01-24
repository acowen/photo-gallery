<?php require_once("initialize.php"); ?>
<?php

function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

if(!is_ajax_request()) { exit; }

$photo = Photograph::find_by_id($_GET['id']);
if(!$photo) {
    echo "No comments found";
    exit;
}

$comments = $photo->comments();

?>
<?php foreach ($comments as $comment): ?>
    <div class="comment">
        <div class="author">
            <?php echo htmlentities($comment->author); ?> wrote:
        </div>
        <div class="body">
            <?php echo strip_tags($comment->body, '<strong><em><p>'); ?>
        </div>
        <div class="meta-info" style="font-size: 0.8em;">
            <?php echo datetime_to_text($comment->created); ?>
        </div>
    </div>
<?php endforeach; ?>
<?php if(empty($comments)) { echo "No Comments."; } ?>