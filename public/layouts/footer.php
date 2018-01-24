</main>

<footer>
    <div>Copyright <?php echo date('Y'); ?> <a href="https://angellowen.com">Angell Owen</a> </div>
</footer>

  </body>
</html>

<?php if(isset($database)) { $database->close_connection(); } ?>