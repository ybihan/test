<?php if ($module == 'category' and $param['id'] != 'PHP' and $param['id'] != 'JS'
    and $param['id'] != 'mysql' and $param['id'] != 'HTML5' and $param['id'] != 'CSS3' )
    sendMessage(20, '/load');

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Сторінка новин</title>
    <meta http-equiv='content-type' content='text/html; charset=utf-8'/>
    <meta name='description' content=''/>
    <meta name='keywords' content=''/>
    <!--[if lte IE 8]>
    <script src='/css/ie/html5shiv.js'></script><![endif]-->
    <script src='/js/jquery.min.js'></script>
    <script src='/js/skel.min.js'></script>
    <script src='/js/skel-layers.min.js'></script>
    <script src='/js/init.js'></script>

    <link rel='stylesheet' href='/css/skel.css'/>
    <link rel='stylesheet' href='/css/style.css'/>
    <link rel='stylesheet' href='/css/style-desktop.css'/>
    <link rel='stylesheet' href='/css/style-wide.css'/>

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
<?if ($_SESSION['user_log_in']){
    $menu = "<a href='/load/add'>
             <div class='Cat'>Додати новину</div>
             </a>";
}?>
    <!-- Content -->
    <div id='content'>
        <div class='inner'>
            <div class="CatHead">
                <a href="/load">
                    <div class="Cat">Всі категорії</div>
                </a>
                <a href="/load/category/id/PHP">
                    <div class="Cat">Категорія PHP</div>
                </a>
                <a href="/load/category/id/JS">
                    <div class="Cat">Категорія JavaSsript</div>
                </a>
                <a href="/load/category/id/mysql">
                    <div class="Cat">Категорія MySQL</div>
                </a>
                <?echo $menu;?>
            </div><br>
            <!-- Post -->
<? showMessage(); ?>
     <?

if (!$module or $module == 'main') {
    if ($_SESSION['user_group'] != 2) $active = 'WHERE active = 1';
    $param1 = "SELECT id, name, category, date, text, added, active FROM loads ".$active." ORDER BY id DESC LIMIT 0, 6";
    $param2 = "SELECT id, name, category, date, text, added, active FROM loads ".$active." ORDER BY id DESC LIMIT START, 6";
    $param3 = "SELECT COUNT('id') FROM loads";
    $param4 = "/load/main/page/";
} elseif ($module == 'category') {
    if ($_SESSION['user_group'] != 2) $active = 'AND active = 1';
    $param1 = "SELECT id, name, category, date, text, added, active FROM loads
               WHERE category = '$param[id]' ".$active." ORDER BY id DESC LIMIT 0, 6";
    $param2 = "SELECT id, name, category, date, text, added, active FROM loads
               WHERE category = '$param[id]' ".$active." ORDER BY id DESC LIMIT START, 6";
    $param3 = "SELECT COUNT('id') FROM loads WHERE category = '$param[id]'";
    $param4 = "/load/category/id/$param[id]/page/";
}
     $sql = mysqli_query($cnn,$param3);
     $count = mysqli_fetch_row($sql);
     //var_dump($count);
    if (!$param['page']){
    $param['page'] = 1;
        $res = mysqli_query($cnn,$param1);
    }else{
        $start = ($param['page']-1)*5;
        $res = mysqli_query($cnn,str_replace('START',$start,$param2));
    }

     while ($row = mysqli_fetch_assoc($res)) {
         if ($row['active'] == 0) $row['name'] .= " <b>(Очікує на провірку)</b>";
         echo '<a class="myClass" href="/load/material/id/'.$row['id'] .'">
               <div class="newsBlock"><span>Додав: '.
             $row['added'] . ' | ' . $row['date'] . '</span>' . $row['name'] . '</div></a>';
         //echo $param['page'];
     }
     nextPage($param4,$param['page'],$count);
     ?>
        </div>
    </div>
</div>

<?php leftMenu(); ?>

</body>
</html>