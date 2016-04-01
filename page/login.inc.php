<?php
userLogin(0);
headerPage('Сторінка входу');?>
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
            <?php showMessage();?>
            <b>Вхід на сайт: </b>
            <form method='POST' action='/account/login'>
                Логін <input type='text' name='login' required>
                Пароль <input type='password' name='password' required>
                Ведіть капчу <input type="text" name="captcha" placeholder="Капча" required><br>
                <img id="logo", src="/form/captcha.php" alt="Каптча"><br>
                Запам'ятати мене<input type='checkbox' name='remember'><br><br>
                <input type='submit' name='enter' value='Вхід'>
                <input type='reset' value='Очистити'>
            </form>
        </div>
    </div>


<?php leftMenu(); ?>

</body>
</html>