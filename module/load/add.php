<?php
userLogin(1);
//userAccess(0);

if ($_POST['enter'] and $_POST['category'] and $_POST['text'] and $_POST['name'] and $_FILES['img']['tmp_name']) {
    if ($_FILES['img']['type'] != 'image/jpeg') sendMessage(28, '/load');
    if ($_FILES['img']['size'] > 2000000) sendMessage(29, '/load');
    if ($_SESSION['user_group'] == 2) $active = 1;
    else $active = 0;
    //echo $active;
    $name = checkForm($_POST['name']);
    $category = checkForm($_POST['category']);
    $text = checkForm($_POST['text']);
    //echo "$name $category $text";

    $res = mysqli_query($cnn, "SELECT id FROM loads ORDER BY id DESC LIMIT 1");
    $maxId = mysqli_fetch_row($res);
    $maxId[0] += 1;

    foreach(glob('catalog/img/*', GLOB_ONLYDIR) as $num => $Dir) {
        $num_img ++;
        $Count = sizeof(glob($Dir.'/*.*'));
        if ($Count < 250) {
            move_uploaded_file($_FILES['img']['tmp_name'], $Dir.'/'.$maxId[0].'.jpg');
            break;
    }
    }
        $sql = "INSERT INTO loads VALUES ('','$name','$category','0', '0','$_SESSION[user_login]','$text', NOW(), '$active', '$num_img')";
        mysqli_query($cnn, $sql);
        sendMessage(24, '/load');

}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Додати новину</title>
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

    <!-- Content -->
    <div id='content'>
        <div class='inner'>
            <?showMessage();?>
            <b> Додати новину :</b>
            <form method='POST' action='/load/add' enctype="multipart/form-data">
                Назва <input type='text' name='name' maxlength='50' >
                Виберіть категорію <select name="category">
                    <option ></option>
                    <option >PHP</option>
                    <option >JS</option>
                    <option >mysql</option>
                </select><br>
                <input type="file" name="img"> Фото <br><br>
                Текст новини <textarea class="myArea" name="text"></textarea><br>
                <input type='submit' name='enter' value='Додати'>
                <input type='reset' value='Очистити'>
            </form>
        </div>
    </div>


<?php leftMenu(); ?>

</body>
</html>

