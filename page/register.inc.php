<?php
userLogin(0);
headerPage('Реєстрація');?>
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
            <b> Заповніть форму будь - ласка :</b>
            <form method='POST' action='/account/register'>
                Логін <input type='text' name='login' maxlength='50'>
                E-Mail <input type='email' name='email'maxlength='50' required>
                Пароль <input type='password' name='password' maxlength='50' required>
                Ім'я <input type='text' name='name' maxlength='50' required>
                Ведіть капчу <input type="text" name="captcha" placeholder="Капча" required><br>
                <img id="logo", src="/form/captcha.php" alt="Каптча">
                <br><br><input type='submit' name='enter' value='Реєстрація'> <input type='reset' value='Очистити'>
            </form>
        </div>
    </div>


<?php leftMenu(); ?>

</body>
</html>

