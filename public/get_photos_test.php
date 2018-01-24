<?php require_once("initialize.php"); ?>
<?php
// You can simulate a slow server with sleep
// sleep(2);

//function is_ajax_request() {
//    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
//        $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
//}
//
//if(!is_ajax_request()) { exit; }


//$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$page = 1;

$per_page = 2;

$total_count = 10;

$pagination = new Pagination($page, $per_page, $total_count);

if(!$pagination->has_page()){
    echo "false";
    exit;
}else {
    echo "yes";
}

$sql = "SELECT * FROM photographs ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$photos = Photograph::find_by_sql($sql);

?>
<?php foreach ($photos as $photo): ?>
    <img id="<?php echo $photo->id; ?>" class="loaded-img" src="<?php echo $photo->image_path(); ?>" alt="<?php echo $photo->caption; ?>" width="300" onClick="reply_click(this.id);">
<?php endforeach; ?>
