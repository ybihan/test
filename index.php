<?
include_once "setting.php";
session_start();
$cnn = mysqli_connect(HOST, LOGIN, PASS, DB_NAME);
//$cnn = mysqli_connect(S_HOST,S_LOGIN, S_PASS,S_DB_NAME);

if ($_SESSION['user_log_in'] != 1 && $_COOKIE['user']){
    $queryRes = mysqli_query($cnn, "SELECT id, email,name,  regdate FROM u1 WHERE password = '$_COOKIE[user]'");
    $res2 = mysqli_fetch_assoc($queryRes);
    $_SESSION['user_id'] = $res2['id'];
    $_SESSION['user_email'] = $res2['email'];
    $_SESSION['user_name'] = $res2['name'];
    $_SESSION['user_regdate'] = $res2['regdate'];
    $_SESSION['user_log_in'] = 1;
}

if ($_SERVER['REQUEST_URI'] == "/") {
    $page = 'index';
    $module = 'index';
} else {
    $URL_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $URL_parts = explode('/', trim($URL_path, '/'));
    $page = array_shift($URL_parts);
    $module = array_shift($URL_parts);
}

if (!empty($module)) {
    $param = [];
    for ($i = 0; $i < count($URL_parts); $i++) {
        $param[$URL_parts[$i]] = $URL_parts[++$i];
    }
}

//// Провірка і переадесація на сторінку
if ($page == 'index') include 'page/index.inc.php';
if ($page == 'register') include 'page/register.inc.php';
if ($page == 'login') include 'page/login.inc.php';
if ($page == 'account') include 'form/account.php';
if ($page == 'profile') include 'page/profile.inc..php';

else if ($page == 'load') {
    if (!$module or $page == 'load' and $module == 'category' or $page == 'load' and $module == 'main') include('module/load/main.php');
    else if ($module == 'material') include('module/load/material.php');
    else if ($module == 'add') include 'module/load/add.php';
    else if ($module == 'edit') include 'module/load/edit.php';
    else if ($module == 'control') include 'module/load/control.php';
}


// Групи користувачів для доступу до сторінок сайту
function userGroup($group)
{
    if ($group == 0) return "Користувач";
    else if ($group == 1) return "Модератор";
    else if ($group == 2) return "Адміністратор";
    else if ($group == -1) return "Заблоковано";
}

// надає доступ користувача до сторінок редагування новин
function userAccess($p1){

        if($_SESSION['user_group'] < $p1) sendMessage(23,'/');
}

// Генерація випадкового паролю
function randomString($num){
    $char = '0123456789abcdefghijopkrstvwxyzABSDEFGHIJOPQRSTUVWXYZ!@#$%^&*()_';
    $str='';
    for ($i=0;$i<=$num; $i++)
        $str .=$char[rand(0, strlen($char)-1)];
    return $str;
}

// Приховування частини емайл адреси
function hideEmail($mail){
    $explode = explode('@',$mail);
    return $explode[0].'*****';
}

// Провірка значень
function userLogin($dostup){
    if ($dostup <= 0 && $_SESSION['user_log_in'] != $dostup)  sendMessage(10,"/");
    elseif($_SESSION['user_log_in'] != $dostup)  sendMessage(11,"/");
}

//Відправка повідомлень
function sendMessage($p1,$p2 = '',$p3=''){
    if ($p1 == 1 ) $p1= "Будь - ласка заповніть всі поля";
    if ($p1 == 2 ) $p1= "Дякуємо за реєстрацію.";
    if ($p1 == 3 ) $p1= "Не правильно введено код провірки ";
    if ($p1 == 4 ) $p1= "Дякуємо ,  на указаний email адрес відправлено лист для підтвердження";
    if ($p1 == 5 ) $p1="Дякуємо за реєстрацію Ваш e-mail  підтверджено";
    if ($p1 == 6 ) $p1="Ваш e-mail   адрес НЕ підтверджено.";
    if ($p1 == 7 ) $p1='E-mail адреса  вже підтверджена.';
    if ($p1 == 8 ) $p1="Аккаунт користувача не активований";
    if ($p1 == 9 ) $p1="Не правильний логін або пароль";
    if ($p1 == 10 ) $p1="Ця сторінка доступна тільки для гостей";
    if ($p1 == 11 ) $p1="Ця сторінка доступна тільки для користувачів";
    if ($p1 == 12 ) $p1="Ви вже надіслали заявку на відновлення пароля, провірте свій
    E-mail адрес ".$p3;
    if ($p1 == 13) $p1="Ваш пароль змінено, для входу на сайт використовуйте новий пароль ".$p3;
    if ($p1 == 14 ) $p1="Користувач не знайдений";
    if ($p1 == 15 ) $p1="На ваш e-mail ".$p3." надіслано лист для підтвердження";
    if ($p1 == 16 ) $p1="Неможливо відновити пароль";
    if ($p1 == 17 ) $p1="Пароль успішно змінено, для входу використовуйте новий пароль".$p3;
    if ($p1 == 18 ) $p1="Не вірно введено старий пароль";
    if ($p1 == 19 ) $p1="Дані змінено";
    if ($p1 == 20 ) $p1="Категорія відсутня";
    if ($p1 == 21 ) $p1="Адреса відсутня";
    if ($p1 == 22 ) $p1="Новина відсутня";
    if ($p1 == 23 ) $p1="Ви не надано права доступу для переглядання цієї сторінки";
    if ($p1 == 24 ) $p1="Вашу новину додано";
    if ($p1 == 25 ) $p1="Новина на провірці адміністратора";
    if ($p1 == 26 ) $p1="Новину активовано";
    if ($p1 == 27 ) $p1="Новину видалено";
    if ($p1 == 28 ) $p1="Невідомий формат зображення";
    if ($p1 == 29 ) $p1="Розмір файлу занадто великий";

    $_SESSION['message'] = "<div class='error'><b>$p1</b></div>";
    if ($p2) $_SERVER['HTTP_REFERER'] = $p2;
    exit(header("Location: ".$_SERVER['HTTP_REFERER']));
}

//Показ повідомлень і запис в сесію
function showMessage(){
    if ($_SESSION['message']) $message = $_SESSION['message'];
    echo $message;
    $_SESSION['message'] =[];
}

//Провірка даних форми
function checkForm($p1){
    return htmlspecialchars(trim($p1), ENT_NOQUOTES);
}

//перемикач сторінок
function nextPage($p1,$p2,$p3,$p4 = 6){
    /*
     * $p1 - URL (news/main/page)
     * $p2 - Поточна сторінка із ($param['page'])
     * $p3 - кількість новин отриманих з запиту
     * $p4 - кі -сть новин на сторінці
     *
     * */
    $page = $p3[0]/$p4;// кількість новин на кі-сть записів на сторінці
    if ($page>1){
        //echo "<div class='nextPage'>";
     for ($i = ($p2-3); $i<($page+1); $i++){
         if ($i > 0 and $i <= ($p2+3)){
             if ($p2 == $i) $switch = 'switchItemCur';
             else $switch = 'switchItem';
             $item = $p1.$i;

             //echo "<div class='pagination'><div class='pages'><a class='active' href='$item'>$i</a></div></div>";
             echo "<a class='$switch' href='$item'>$i</a>";
         }
        }
        //echo "</div>";
    }
}

//Шапка сторінки
function headerPage($title)
{
    echo "<!DOCTYPE HTML>
<html>
<head>
    <title>$title</title>
    <meta http-equiv='content-type' content='text/html; charset=utf-8' />
    <meta name='description' content='' />
    <meta name='keywords' content='' />
    <!--[if lte IE 8]>
    <script src='../css/ie/html5shiv.js'></script><![endif]-->
    <script src='/js/jquery.min.js'></script>
    <script src='/js/skel.min.js'></script>
    <script src='/js/skel-layers.min.js'></script>
    <script src='/js/init.js'></script>
    <noscript>
        <link rel='stylesheet' href='/css/skel.css' />
        <link rel='stylesheet' href='/css/style.css' />
        <link rel='stylesheet' href='/css/style-desktop.css' />
        <link rel='stylesheet' href='/css/style-wide.css' />
    </noscript>
    <!--[if lte IE 8]>
    <link rel='stylesheet' href='../css/ie/v8.css'/><![endif]-->
</head>";
}

//Ліве меню
function leftMenu()
{
    if ($_SESSION['user_log_in'] != 1){
       $menu = "
                <li><a href='/'>Головна</a></li>
                <li><a href='/load'>Новини</a></li>

                <li><a href='/login'>Вхід</a></li>
                <li><a href='/register'>Реєстрація</a></li>

                " ;
    }else {
        $menu = "

                <li><a href='/'>Головна</a></li>
                <li><a href='/load'>Новини</a></li>
                <li><a href='/profile'>Профіль</a></li>
                   " ;
    }
    echo "
<!-- Sidebar -->
    <div id='sidebar'>

        <!-- Logo -->
        <h1 id='logo'><a href='/'>PHP</a></h1>

        <!-- Nav -->
        <nav id='nav'>
            <ul>

                ".$menu."

            </ul>
        </nav>
 </div>

</div>";

}

