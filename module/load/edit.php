<?php
userLogin(1);
userAccess(2);
$param['id'] += 0;
if ($param['id'] == 0) sendMessage(21, '/load');
$query = mysqli_query($cnn, "SELECT name, category, text, active, dirimg FROM loads WHERE id = '$param[id]'");
$row = mysqli_fetch_assoc($query);
//var_dump($row);
if ($_POST['enter'] and $_POST['category'] and $_POST['text'] and $_POST['name']) {
    $name = checkForm($_POST['name']);
    $category = checkForm($_POST['category']);
    $text = checkForm($_POST['text']);
    //echo "$name $category $text";
    if ($_FILES['img']['tmp_name']) move_uploaded_file($_FILES['img']['tmp_name'], 'catalog/img/'.$row['dirimg']."/".$param['id'].".jpg");

mysqli_query($cnn, "UPDATE loads SET name ='$name', category = '$category', text = '$text' WHERE id = '$param[id]'");
    sendMessage(19, '/load/material/id/' . $param['id']);
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Редагувати новину</title>
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
            <? showMessage(); ?>
            <b> Редагувати новину :</b>

            <form method='POST' action='<?= "/load/edit/id/$param[id]"; ?>' enctype="multipart/form-data">
                Назва <input type='text' name='name' maxlength='50' value="<?= $row['name'] ?>">
                Виберіть категорію <select name="category">
                    <option selected><?= $row['category'] ?></option>
                    <option>PHP</option>
                    <option>JS</option>
                    <option>mysql</option>
                </select>
                <br>
                <input type="file" name="img" ><br><br>

                Текст новини <textarea class="myArea" name="text"> <?= $row['text'] ?></textarea><br>
                <input type='submit' name='enter' value='Додати'>
                <input type='reset' value='Очистити'>
            </form>

        </div>
    </div>


    <?php leftMenu(); ?>

</body>
</html>

