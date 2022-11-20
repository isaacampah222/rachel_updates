<?php require_once("admin/common.php"); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang['langcode'] ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>RACHEL - <?php echo $lang['home'] ?></title>
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
         maybe you're on one but need to know the other. Also helps if my.3ontent
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
                    <a href="index.php" target="_self" class="nav-item nav-link active">
                        <h5><?php echo strtoupper($lang['home']) ?></h5>
                    </a>
                    <a href="about.html" target="_self" class="nav-item nav-link">
                        <h5><?php echo strtoupper($lang['about']) ?></h5>
                    </a>
                </div>

                <div class="mx-auto"><span><strong style="font-size: 2rem;">RACHEL </strong>v4.4</span></div>

                <div class="navbar-nav ms-auto">
                    <form class="d-flex" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="input-group" style="width: 370px">
                            <input type="text" name="requestBar" id="requestBar" class="form-control" style="background-color: rgba(255,255,255,0.6);" placeholder="Que voulez-vous apprendre?">
                            <button type="button" id="reqbtn" value="submit" class="btn btn-secondary">Demande</button>
                        </div>
                    </form>
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

    <div class="container-xl m-3  mt-4 mx-auto">

        <!-- <h2 class="accordion-header" id="headingOne"> -->
        <!-- <button class="accordion-button text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" style="height: 200px; background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.6)), url(art/lit.jpg)" aria-expanded="true" aria-controls="collapseOne"> -->
        <!-- Literature -->
        <!-- Center Jumbotron -->
        <div class="justify-content-center align-items-center jumbotron py-3">
            <h2 class="text-align-center">Bienvenue sur votre tableau de bord</h2>
        </div>
        <!-- </button> -->
        <!-- </h2> -->
        <div class="row gx-1">

            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="https://comdevnet.org">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/logo.png); background-size: contain; background-position: center; border: inset 15px transparent; background-repeat: no-repeat;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">CDN</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="church.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/logo.PNG); background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Ressources sur les Lieux de Rassemblement</h5>
                        </div>
                    </div>
                </a>
            </div>



		



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

                    if ($mod['category'] == "kolibri") {
                        include $mod['fragment'];
                    }
                    ++$modcount;
                }
            }

            if ($modcount == 0) {
                echo $lang['no_mods_error'];
            }

            ?>


            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="education.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/education.jpg); background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Éducation</h5>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="religion.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/religion.jpg);  background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">La Religion</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="agriculture.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/agri.jpg); ; background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Agriculture</h5>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="books.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/books.jpg);  background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Livres</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4 col-md-3 my-3 col-6">
                <a href="literacy.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/edu.png);  background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Littératie</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="music.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/music.jpg); background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Musique</h5>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="stem.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/stem.png); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">STEM</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4 col-md-3 my-3 col-6">
                <a href="community.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/com.jpg);  background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Santé</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="business.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/business.jpg); background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: 20%">

                            <h5 class="text-dark">Entreprise</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="vocational.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/vocational.jpg); ; background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Professionnelle</h5>
                        </div>
                    </div>
                </a>
            </div>

            

            <div class="col-sm-4 col-md-3 my-3 col-6">
                <a href="language.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/lit.jpg);  background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Langue</h5>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="human_rights.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/hre.jpg); ; background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Droits Humains</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="multimedia.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/photography.jpg); ; background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Multimédia</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-4 col-md-3 col-6 my-3">
                <a href="tools.php">
                    <div class="indexmodule shadow rounded border">
                        <div class="bg-img" style="background-image: url(art/tools.jpg); ; background-size: cover;"></div>

                        <div class=" align-items-center justify-content-center d-flex  text-center" style="flex: auto">

                            <h5 class="text-dark">Outils</h5>
                        </div>
                    </div>
                </a>
            </div>


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
    <script>
        <?php if (isset($_COOKIE['request'])) {
            // echo "console.log('" . $_COOKIE['request'] . "')";
            echo "console.log('" . updateRequest($_COOKIE['request'] . PHP_EOL) . "');";
        } ?>;
        const btn = document.getElementById('reqbtn');
        btn.addEventListener('click', function handleClick(event) {
            const request = document.getElementById('requestBar');
            var date = new Date();
            date.setTime(date.getTime() + (5 * 1000));
            document.cookie = "request=" + request.value + "; max-age=" + 5;



            location.reload();

        })
    </script>

</body>

</html>
