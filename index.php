<?php
include_once 'head.php';
include_once 'includes/functions.php';

if ($_POST['logout']) session_destroing();

if (logged_in()) include_once 'db_view.php';
	else redirect('login.php');


?>

<p>Оператор: <?php echo $_SESSION['fullname'] ?></p>
      <form action="index.php" method="post">
        <input type="submit" name="logout" value="Выход" />
				<?php echo ($_POST['logout']); ?>
      </form>

    