<?php require_once("initialize.php"); ?>
<?php

function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

if(!is_ajax_request()) { exit; }

$id = isset($_POST['id']) ? (int) $_POST['id'] : '';
$author = isset($_POST['author']) ? $_POST['author'] : '';
$body = isset($_POST['body']) ? $_POST['body'] : '';

$new_comment = Comment::make($id, $author, $body);

if($new_comment && $new_comment->save()){
    //comment saved
    echo "true"; exit;
}else {
    //error return false
    echo "false"; exit;
}
