<?php require_once("initialize.php"); ?>
<?php

?>
<?php include_layout_template('header.php'); ?>

    <!-- Trigger the Modal -->
    <div id="images">
    </div>

    <div id="spinner">
        <img src="spinner.gif" width="50" height="50"/>
    </div>

    <div id="load-more-container">
        <button id="load-more" data-page="0">Load more</button>
        <p id="end" style="display: none;">End of images</p>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- The Close Button -->
        <span class="close">&times;</span>

        <!-- Modal Caption (Image Text) -->
        <div class="container">
            <div class="img-caption">
                <img class="modal-content" id="img01" data-photo-id="">
                <div id="caption"></div>
            </div>

            <div class="comment-form" style="color: white;">

                <div id="comments" style="color: white;">
                </div>

                <!--        --><?php //echo output_message($message); ?>

                <div class="form">
                    <h3>New Comment</h3>
                    <div class="form-section">
                        <label for="author">Author</label>
                        <input type="text" id="author" value="<?php echo "test author"; ?>"/>
                        <label for="body">Comments</label>
                        <textarea id="body"><?php echo "test body"; ?></textarea>
                    </div>
                    <div>
                        <button id="submit" type="button" onclick="submitComment();">Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php include_layout_template('footer.php'); ?>