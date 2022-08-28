<?php
require_once 'loginDB.php';

function db() {
  $conn = new mysqli(HN, UN, PW, DB);
  if ($conn->connect_error) die($conn->connect_error);
  return $conn;
}

function db_query($query)
{
  $result = db()->query($query);
  if (!$result) die ($conn->error);
  return $result;
}

function add_user($connection, $fn, $sn, $ln, $pw) 
{
  $query = "INSERT INTO users VALUES('$fn', '$sn', '$ln', '$pw')";
  $result = $connection->query($query);
  if (!$result) return $connection->error;
  
}

function get_data_for_options ($table_name, $row_name)
{ $options = "";
  $all_options = db_query("SELECT $row_name FROM " . $table_name . " WHERE 1");
  for ($j = 0 ; $j < $all_options->num_rows ; ++$j)
  {
    $all_options->data_seek($j);
    $row = $all_options->fetch_array(MYSQLI_ASSOC);
    $options = $options . 
              <<<_END
                    <option value="$row[$row_name]">$row[$row_name]</option>
                _END;
  }
  return $options;
}

function get_post($conn, $var) 
{
    return $conn->real_escape_string($_POST[$var]); //real_escape_string - удаление любых символов используемых для взлома
}

function dopsymhol_search($open_db, $value_string) { //дополнительные символы для фильтров <>...
  
  $value_dopsymbol ='';

  if ($value_string[0] == '=')
  {
  $value_string = mb_substr($value_string, 1,);
  }

  if ($value_string[0] == '<' || $value_string[0] == '>')
  {
      $value_dopsymbol = $value_string[0];
      $value_string = mb_substr($value_string, 1,);

      if ($value_string[0] == '=')
      {
          $value_dopsymbol .= '=';
          $value_string = mb_substr($value_string, 1,);
      }
  } else $value_dopsymbol = '=';
   
  return $value_dopsymbol . "'" . sanitizeMySQL($open_db, $value_string) . "'";
}

function debug($var, $stop = false) {
  echo "<pre>";
  print_r($var);
  echo "</pre>";
  if ($stop) die;
}

function sanitizeString($var)
{
  $var = stripslashes($var);
  $var = strip_tags($var);
  $var = htmlentities($var);
  return $var;
}

function sanitizeMySQL($connection, $var)
{
  $var = $connection->real_escape_string($var);
  $var = sanitizeString($var);
  return $var;
}

function redirect($link = HOST)
{
  header("location: $link");
  die;
}

function logged_in()
{
  session_start();
  return isset($_SESSION['login']) &&
         isset($_SESSION['fullname']) &&
         ($_SESSION['check'] == hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
}

function session_destroing()
{
  session_start();
  $_SESSION = array();
  if (session_id() != "" || isset($_COOKIE[session_name()]))
    setcookie(session_name(), '', time() - 2592000, '/');
  session_destroy();
  redirect('login.php');
}

?>