<?php
require_once('../initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php
    //Find all the photos
    $users = User::find_all();
?>

<?php include_layout_template('admin_header.php'); ?>
<a class="back-link" href="<?php echo "index.php"; ?>">&laquo; Back to Menu</a>
<h2>Users</h2>
<?php echo output_message($message); ?>
<table class="bordered">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
<?php foreach($users as $user): ?>
    <tr>
        <td><?php echo $user->id; ?></td>
        <td><?php echo $user->first_name; ?></td>
        <td><?php echo $user->last_name; ?></td>
        <td><?php echo $user->username; ?></td>
        <?php //TODO add functionality to show edit and delete?>
        <td><a class="action" href="<?php echo 'show.php?id=' . h(u($user->id)) ; ?>">View</a></td>
        <td><a class="action" href="<?php echo 'edit.php?id=' . h(u($user->id)) ;?>">Edit</a></td>
        <td><a class="action" href="<?php echo 'delete.php?id=' . h(u($user->id));?>">Delete</a></td>
    </tr>
<?php endforeach; ?>
</table>
<br />

<?php include_layout_template('admin_footer.php'); ?>
