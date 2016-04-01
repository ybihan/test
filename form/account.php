<?
if ($module == "logout" && $_SESSION['user_log_in'] == 1) {
    if ($_COOKIE['user']) {
        setcookie('user', '', strtotime('-30 days'), '/');
        unset($_COOKIE['user']);
    }
    session_unset();
    exit(header('Location: /login'));
}

if ($module == 'edit' and $_POST['enter']){
    userLogin(1);

    $login = checkForm($_POST['login']);
    $email = checkForm($_POST['email']);
    $oldPassword = checkForm($_POST['oldPassword']);
    $newPassword = checkForm($_POST['newPassword']);

    if ($oldPassword or $newPassword){
        if (!$oldPassword) sendMessage(1);
        if (!$newPassword) sendMessage(1);

        //$res = mysqli_query($cnn,"SELECT password FROM u1 WHERE login='$_SESSION[user_login]'");
        //$row = mysqli_fetch_assoc($res);

        if (!password_verify($oldPassword, $_SESSION['user_pass'])) sendMessage(18);
        else{
            $newHashPassword = password_hash($newPassword,PASSWORD_BCRYPT);
            mysqli_query($cnn,"UPDATE u1 SET password='$newHashPassword' WHERE id='$_SESSION[user_id]'");
            $_SESSION['user_pass']= $newHashPassword;

        }

    }

    if ($email != $_SESSION['user_email'] ){
        if($email != ''){
            mysqli_query($cnn,"UPDATE u1 SET email='$email' WHERE id='$_SESSION[user_id]'");
            $_SESSION['user_email']= $email;

        }

    }

    if ($login != $_SESSION['user_login']){
        if ($login != '' ){
            mysqli_query($cnn,"UPDATE u1 SET login ='$login' WHERE id='$_SESSION[user_id]'");
            $_SESSION['user_login']= $login;

        }

    }

    sendMessage(19);

}

userLogin(0);



if ($module == 'register' and $_POST['enter']) {
    $login = checkForm($_POST['login']);
    $email = checkForm($_POST['email']);
    $password = checkForm($_POST['password']);
    $hashPass = password_hash($password, PASSWORD_BCRYPT);
    $name = checkForm($_POST['name']);
    $captcha = checkForm($_POST['captcha']);

    // Дата для вставки в БД
    $date = date("Y:m:d H:i", time());

    // Провірка чи не пусті поля
    if (!$login or !$email or !$password or !$name or !$captcha) sendMessage(1);

    /// Провірка капчі
    if ($_SESSION['captcha'] != md5($captcha)) sendMessage(3);

    // Провірка на наявність такого логіна в БД
    $result = mysqli_query($cnn, "SELECT login FROM u1 WHERE login = '$login'");
    $row = mysqli_fetch_assoc($result);
    if ($row['login']) {
        sendMessage("Логін ".$login." вже використовується", '/register');
        exit;
    }

    // Провірка на наявність такого емайла в БД
    $result2 = mysqli_query($cnn, "SELECT email FROM u1 WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result2);
    if ($row['email']) {
        exit("E-Mail " . $email . " вже використовується" . "<br>");
    }
    $sql = "INSERT INTO u1 VALUES ('', '$login', '$email', '$hashPass','$name', '$date', 0, 0)";
    if (!$reselt = mysqli_query($cnn, $sql)) echo "Дані не добавлено";

    /// Відправка коду підтвердження на емайл
    $encode = base64_encode($email);
    mail($email, "Реєстрація на блогові",
        "Посилання на раєстрацію http://site.local/account/activate/code/" . substr($encode, -5)
        . substr($encode, 0, -5), "from Yura :");
    sendMessage(4);

}

else if ($module == 'activate' and $param['code']) {
    $emailEnc = base64_decode(substr($param['code'], 5) . substr($param['code'], 0, 5));
    $result = mysqli_query($cnn, "SELECT active FROM u1 WHERE email='$emailEnc' ");
    $row = mysqli_fetch_assoc($result);
    if ($_SESSION['user_active_email'] !== $emailEnc && $row['active'] == 0) {
        mysqli_query($cnn, "UPDATE u1  SET active = 1 WHERE email = '$emailEnc '");
        $_SESSION['user_active_email'] = $emailEnc;
        sendMessage(5, '/login'); // підтверджено
    } else {
        sendMessage(7, '/login');// Вже підтверджено
    }
}

else if ($module == 'login' and $_POST['enter']) {
    $login = $_POST['login'];
    $pass = $_POST['password'];
    $captcha = $_POST['captcha'];

    if (!$login or !$pass or !$captcha) sendMessage(1);
    if ($_SESSION['captcha'] != md5($captcha)) sendMessage(3);
    $result2 = mysqli_query($cnn, "SELECT password, active FROM u1 WHERE login = '$login'");
    $row = mysqli_fetch_assoc($result2);

    if (strlen($row['password'])<10){
        if ($row['password'] != $pass ) sendMessage(9,'/login');
        if ($row['active']==0) sendMessage(8);
    }else {
        if (!password_verify($pass,$row['password'])) sendMessage(9,'/login');
        if ($row['active']==0) sendMessage(8);
    }


    $queryResu = mysqli_query($cnn, "SELECT id, login, email,name,regdate, password, userGroup
                                     FROM u1 WHERE login = '$login' ");
    $res2 = mysqli_fetch_assoc($queryResu);
    //var_dump($res2);
    $_SESSION['user_id'] = $res2['id'];
    $_SESSION['user_login'] = $res2['login'];
    $_SESSION['user_email'] = $res2['email'];
    $_SESSION['user_name'] = $res2['name'];
    $_SESSION['user_regdate'] = $res2['regdate'];
    $_SESSION['user_pass'] = $res2['password'];
    $_SESSION['user_group'] = $res2['userGroup'];
    $_SESSION['user_log_in'] = 1;
    if ($_REQUEST['remember']){setcookie('user',$row['password'],strtotime("+10 days"),"/");
    //print_r($row['password']);
    }
    //else {echo}
    exit(header('Location: /profile'));
}



