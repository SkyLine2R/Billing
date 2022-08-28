<?php
include_once 'head.php';
include_once 'includes/functions.php';

if (logged_in()) redirect('index.php');

if (($_POST['login']) && ($_POST['password']))
{
    $login = sanitizeMySQL(db(), $_POST['login']);
    $token = hash('ripemd128', "$salt1" . sanitizeMySQL(db(), $_POST['password']) . "salt2");

    $query = "SELECT * FROM `users` WHERE `login`='$login' AND `password`='$token'";
    $result = db_query($query)->fetch_array(MYSQLI_ASSOC);

    if ($result)
    {   
        session_start();
        $_SESSION['login'] = $result['login'];
        $_SESSION['fullname'] = $result['forename'] . ' ' . $result['surname'];
        //привязка сессии к IP и агенту пользователя, если нет возможности использовать https
        $_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

        redirect("index.php");
    }
    else $error_massage = 'Неверная пара логин/пароль. Если у вас возникли проблемы со входом - обратитесь к системному администратору.';
    
}    

?>
<p class="background-text">авторизация</p>
<main class="login-form">
  <form action="login.php" method="post" id="logInForm">
    <fieldset class="fieldset-login">
      <legend>Авторизация</legend>
            <label for="login">Логин
                <input id="login" name="login" class="field-login" type="text" required/>
            </label>
            <label for="password">Пароль
                <input id="password" name="password" class="field-login" type="password" required/>
            </label>
                <input type="submit" class="submit" value="Войти"/>
    </fieldset>
    <p class="error-massage"><?php echo $error_massage ?></p>
</form>
</main>


<!-- 
$username = 'admin';
$password = 'admin';
if (isset($_SERVER['PHP_AUTH_USER']) &&
    isset($_SERVER['PHP_AUTH_PW']))
{
    if ($_SERVER['PHP_AUTH_USER'] == $username &&
        $_SERVER['PHP_AUTH_PW'] == $password)
        echo "Регистрация прошла успешно";
    else die("Неверная комбинация имя пользователя — пароль");
}
else
{
    header('WWW-Authenticate: Basic realm="Restricted Section"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Пожалуйста, введите имя пользователя и пароль");
}

?> -->