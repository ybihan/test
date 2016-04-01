<?php

$param['id'] += 0;
if ($param['id'] == 0) sendMessage(21,'/load');
$sql = "SELECT id, name, category, reade, date, text, added, active, dirimg FROM loads WHERE id = '$param[id]'";
$query = mysqli_query($cnn, $sql);
$row = mysqli_fetch_assoc($query);
//var_dump($row);
if (!$row['active'] and $_SESSION['user_group'] !=2) sendMessage(25, '/load');
if (!$row['name']) sendMessage(22,'/load');
mysqli_query($cnn, "UPDATE loads SET  reade=reade+1 WHERE id = '$param[id]'");


?>
<!DOCTYPE HTML>
<html>
<head>
    <title><?=$row['name']?></title>
    <meta http-equiv='content-type' content='text/html; charset=utf-8' />
    <meta name='description' content='' />
    <meta name='keywords' content='' />
    <!--[if lte IE 8]>
    <script src='/css/ie/html5shiv.js'></script><![endif]-->
    <script src='/js/jquery.min.js'></script>
    <script src='/js/skel.min.js'></script>
    <script src='/js/skel-layers.min.js'></script>
    <script src='/js/init.js'></script>

    <link rel='stylesheet' href='/css/skel.css' />
    <link rel='stylesheet' href='/css/style.css' />
    <link rel='stylesheet' href='/css/style-desktop.css' />
    <link rel='stylesheet' href='/css/style-wide.css' />

    <!--[if lte IE 8]>
    <link rel='stylesheet' href='/css/ie/v8.css'/><![endif]-->
</head>
<!--
    Note: Set the body element's class to "left-sidebar" to position the sidebar on the left.
    Set it to "right-sidebar" to, you guessed it, position it on the right.
-->

<body class="left-sidebar">
<!-- Wrapper -->
<div id='wrapper'>


    <!-- Content -->
    <div id='content'>
<div class='inner'>
<!-- Post -->
    <? showMessage(); ?>
    <?php
    if ($_SESSION['user_group'] > 0) {
        if (!$row['active'])
$menu = "<a  class='paginationMy' href='/load/control/id/$param[id]/command/active'>Активувати новину</a>";
$plusMenu = "<br> <a class='paginationMy' href='/load/edit/id/$param[id]'>Редагувати новину</a>" . $menu . "
            <a  class='paginationMy' href='/load/control/id/$param[id]/command/delete'>Видалити новину</a><br></>";
    }
            ?>
            <?php echo "Додав $row[added] | $row[date] | кількість переглядів ".($row['reade']+1).
                "$plusMenu".
                       " <br> <b>$row[name]</b> <br>
                       <img src='/catalog/img/$row[dirimg]/$param[id].jpg' width='200px''>
                       <br> $row[text]";?>

        </div>
    </div>

<?php leftMenu(); ?>

</body>
</html>