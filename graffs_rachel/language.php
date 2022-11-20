<?php require_once("admin/common.php"); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang['langcode'] ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>RACHEL - Language Exploration </title>
    <!-- <link rel="stylesheet" href="css/normalize-1.1.3.css"> -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <!-- <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.4.custom.min.css"> -->
    <!-- <script src="js/jquery-1.10.2.min.js"></script> -->
    <!-- <script src="js/jquery-ui-1.10.4.custom.min.js"></script> -->
    <!-- I know this is not ideal UI, but it is based on real-world issues:
     because we can't provide navigation back to the home page (like on
     kalite and kiwix), it is difficult for users to find the front page
     again. This keeps it open in the background. We tried opening all
     content in a *single* seperate window named "content" but then
     going back to the main tab and clicking a second subject without
     closing the first tab resulted in no apparent action (though the
     "content" tab did in fact load the requested info in the background).
     The end result of all this is that we decided the best choice of
     lousy choices was to open everything in a new window/tab. Thus:
-->
    <base target="_blank">
</head>

<body>
    <!--<div id="rachel">
    <!-- Why show IP here? Some installations have WiFi and Ethernet, and
         maybe you're on one but need to know the other. Also helps if my.content
         isn't working on some client devices. Also nice for when you need to ssh
         or rsync. It's visible in the Admin panel too, but it's more convenient here. -->


    <nav class="navbar navbar-expand-lg navbar-light" style="background-image: linear-gradient(to right, rgb(245,207,164), orange);">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand">
                <img src="art/logo.png" height="30" alt="CDN Rachel">
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="index.php" target="_self" class="nav-item nav-link active"><?php echo strtoupper($lang['home']) ?></a>
                    <a href="about.html" target="_self" class="nav-item nav-link"><?php echo strtoupper($lang['about']) ?></a>
                </div>

                <div class="mx-auto"><span><strong style="font-size: 1.7rem;">RACHEL </strong>v4.4</span></div>

                <div class="navbar-nav ms-auto">
                    <!-- <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" style="background-color: rgba(255,255,255,0.6);" placeholder="Search">
                            <button type="button" class="btn btn-secondary">Search</button>
                        </div>
                    </form> -->
                    <a href="#" class="nav-item nav-link"><?php showip() ?></a>
                    <a href="admin/modules.php" class="nav-item nav-link"><?php echo $lang['admin'] ?></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- <div class="menubar cf">
        <ul>
            <li><a href="index.php" target="_self"><?php echo strtoupper($lang['home']) ?></a></li>
            <li><a href="about.html" target="_self"><?php echo strtoupper($lang['about']) ?></a></li>
            <?php
            if (show_local_content_link()) {
                echo "<li><a href=\"http://$_SERVER[SERVER_ADDR]:8090/\" target=\"_self\">LOCAL CONTENT</a></li>";
            }
            ?>
        </ul>
    </div> -->

    <div class="container-xl mt-4 mx-auto">

        <div class=" jumbotron p-5">
            <h2>Language Exploration du Langage </h2>
        </div>

        <div class="row gx-1">


            <?php

            $modcount = 0;

            $fsmods = getmods_fs();

            # if there were any modules found in the filesystem
            if ($fsmods) {

                # get a list from the databases (where the sorting
                # and visibility is stored)
                $dbmods = getmods_db();

                # populate the module list from the filesystem 
                # with the visibility/sorting info from the database
                foreach (array_keys($dbmods) as $moddir) {
                    if (isset($fsmods[$moddir])) {
                        $fsmods[$moddir]['position'] = $dbmods[$moddir]['position'];
                        $fsmods[$moddir]['hidden'] = $dbmods[$moddir]['hidden'];
                    }
                }

                # custom sorting function in common.php
                uasort($fsmods, 'bypos');

                # whether or not we were able to get anything
                # from the DB, we show what we found in the filesystem
                foreach (array_values($fsmods) as $mod) {
                    if ($mod['hidden'] || !$mod['fragment']) {
                        continue;
                    }
                    $dir  = $mod['dir'];
                    $moddir  = $mod['moddir'];

                    if ($mod['category'] == "language") {
                        include $mod['fragment'];
                    }
                    ++$modcount;
                }
            }

            if ($modcount == 0) {
                echo $lang['no_mods_error'];
            }

            ?>

        </div>

        <!-- <div class="row gx-1">

            

        </div> -->
    </div>

    <!-- <div class="menubar cf" style="margin-bottom: 80px; position: relative;">
    <ul>

    <li><a href="index.php" target="_self"><?php echo strtoupper($lang['home']) ?></a></li>
    <li><a href="about.html" target="_self"><?php echo strtoupper($lang['about']) ?></a></li>
    </ul>
</div> -->

    <script src="js/bootstrap.min.js"></script>

</body>

</html>