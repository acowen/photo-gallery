<?php require_once("../initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>
<?php

$logfile = PROJECT_PATH.DS.'logs'.DS.'log.txt';

if(isset($_GET['clear']) && $_GET['clear'] == 'true') {
    file_put_contents($logfile, '');
    // Add logs cleared in log file
    log_action('Logs Cleared', "by User ID {$session->user_id}");
    // refresh page to remove clear=true in url
    redirect_to('logfile.php');
}
?>

<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&laquo; Back</a><br />
<br />

<h2>Log File</h2>

<p><a href="logfile.php?clear=true">Clear log file</a><p>

    <?php

    if( file_exists($logfile) && is_readable($logfile) &&
        $handle = fopen($logfile, 'r')) {  // read
        echo "<ul class=\"log-entries\">";
        while(!feof($handle)) {
            $entry = fgets($handle);
            if(trim($entry) != "") {
                echo "<li>{$entry}</li>";
            }
        }
        echo "</ul>";
        fclose($handle);
    } else {
        echo "Could not read from {$logfile}.";
    }

    ?>

    <?php include_layout_template('admin_footer.php'); ?>
