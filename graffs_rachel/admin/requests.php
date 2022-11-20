<?php
require_once("common.php");
if (!authorized()) { exit(); }

    # a bit sloppy, this...
    global $lang;
    $page_title = 'requests';
    $page_nav = "requests";
    $page_script = "";
    include "head.php";

    $requests = file('/var/www/request.txt');
    echo "<h3 style=\"margin=20px\">Items Requested</h3>";
    foreach ($requests as $request){
        echo "<li>".$request.'</li><br>';
    }

    echo "<a href=\"../request.txt\"  rel=\"noopener noreferrer\" download target=\"_blank\"> Download Request File </a>";
?>