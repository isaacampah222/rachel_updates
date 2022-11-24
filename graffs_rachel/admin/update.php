<?php
require_once("common.php");
if (!authorized()) { exit(); }

    # a bit sloppy, this...
    global $lang;
    $page_title = 'updates';
    $page_nav = "updates";
    $page_script = "";
    include "head.php";

    if (isset($_POST['update'])) {
       $result = shell_exec('bash /var/www/rachel-update.sh');
       echo "<pre>$result</pre>";
    }
   
	
?>

<html>
    <body>
        <?php echo $result ?>
        <h1 onclick="<?php  ?>">Here</h1>
        <form method="POST">
            <button name="update">Run Shell Update Script</button>
</form>
<script>
    <?php echo  $result ?>
</script>
</body>