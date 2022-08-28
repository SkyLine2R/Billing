<?php
include_once 'head.php';
include_once 'includes/functions.php';

if (isset($_POST['name']) &&
   isset($_POST['surname']) &&
   isset($_POST['login']) &&
   isset($_POST['password']) &&
   isset($_POST['password2']))
{
  if (($_POST['password']) != ($_POST['password2']))
  {
    $error_massage = "Пароли не совпадают!";
  }
  else
  {
    $name = sanitizeMySQL(db(), $_POST['name']);
    $surname = sanitizeMySQL(db(), $_POST['surname']);
    $login = sanitizeMySQL(db(), $_POST['login']);
    $token = hash('ripemd128', "$salt1" . sanitizeMySQL(db(), $_POST['password']) . "salt2");

    $result = add_user(db(), $name, $surname, $login, $token);

    $error_massage = $result ? $result : "Пользователь $login добавлен";
  }
} else $error_massage = "Заполните все поля!";

?>


<p class="background-text">админка</p>
<main class="login-form">
  <form action="admin_page.php" method="post" id="logInForm">
    <fieldset class="fieldset-login">
      <legend>Добавление пользователя</legend>
            <label for="name">Имя</label>
                <input id="name" name="name" class="field-login" type="text" required/>
            <label for="surname">Фамилия</label>
                <input id="surname" name="surname" class="field-login" type="text" required/>
                <br />
            <label for="login">Логин</label>
                <input id="login" name="login" class="field-login" type="text" required/>
            <label for="password">Пароль</label>
                <input id="password" name="password" class="field-login" type="password" required/>
            <label for="password2">Повторите пароль</label>
                <input id="password2" name="password2" class="field-login" type="password" required/>
                <input type="submit" class="submit" value="Добавить"/>
    </fieldset>
      <p class="error-massage"><?php echo $error_massage ?></p>
  </form>

</main>


