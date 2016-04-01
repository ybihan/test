<?php
userLogin(1);
headerPage('Профіль користувача');?>
<!--
    Note: Set the body element's class to "left-sidebar" to position the sidebar on the left.
    Set it to "right-sidebar" to, you guessed it, position it on the right.
-->

<body class="left-sidebar">
<!-- Wrapper -->

<div id='wrapper'>
    <div id='content'>
        <? showMessage();
        //echo $_SESSION['user_log_in'];
        //$group=(int)$_SESSION['user_group'];
        //echo $group;
        ?>
    <div><b>Вітаємо Вас в профілі користувача</b></div></<br>
        <div>
        <img src="../img/noavatar.jpg" align="bottom"><br>
            <b>Ім'я користувача </b>: <?=$_SESSION['user_name']?> <br>
            <b>Логін </b>: <?=$_SESSION['user_login']?> <br>
            <b>Ідентифікатор :</b> <?=$_SESSION['user_id'];?>
            (<?echo userGroup($_SESSION['user_group']);?>)<br>
            <b>Дата реєстрації : </b><?=$_SESSION['user_regdate']?><br>
           <b> E-mail  : </b><?=$_SESSION['user_email']?><br><br>

        <a href="/account/logout" class='button'>Вихід</a><br>
           <hr>
            <form method='POST' action='/account/edit'>
                Старий пароль<input type='password' name='oldPassword'
                                    maxlength='15' pattern='[A-Za-z-0-9]{5,15}' title='Не менее 5 и неболее 15 латынских символов или цифр.'>
                Новий пароль<input type='password' name='newPassword'
                                   maxlength='15' pattern='[A-Za-z-0-9]{5,15}' title='Не менее 5 и неболее 15 латынских символов или цифр.'>
                Новий e-mail<input type='email' name='email'  >
                Змінити логін <input type='text' name='login' >

                <br><input type='submit' name='enter' value='Зберегти зміни'>
                <input type='reset' value='Очистити'>
            </form>
    </div></div>




<?php leftMenu(); ?>

</body>

</html>