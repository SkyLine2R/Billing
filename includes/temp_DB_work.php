<?php
//вытаскиваем все улицы
/* 
$query1 = "SELECT DISTINCT E,Rayon_id FROM `abonents_tv` ORDER BY `abonents_tv`.`E`  ASC"; //выбираем все уникальные улицы + ID района
$result_all_streets = $connectDB->query($query1);
if (!$result_all_streets) die ($connectDB->error);
  $street_all = $result_all_streets->num_rows;

for ($i = 0 ; $i < $street_all; ++$i) {
  $result_all_streets->data_seek($i);
  $street = $result_all_streets->fetch_array(MYSQLI_ASSOC);
  echo $i . "<br />";
  print_r ($street);
  $query2 = "INSERT INTO `streets`(`Street`, `Rayon_ID`) VALUES (" . "\" $street[E] \"" . "," . "\" $street[Rayon_id]\"" . ")";
  echo $query2;
  $result_adding = $connectDB->query($query2);
  if (!$result_adding) die ($connectDB->error);
} die;
 */
//конец блока


//замена домов на id
require_once 'functions.php';
//вытаскиваем все уникальные дома на улицах из таблицы
/* $query1 = "SELECT street_id, home_number FROM `abonents_tv`";
$result_all_homs = db_query($query1);

if (!$result_all_homs) die ($connectDB->error);
  $home_all = $result_all_homs->num_rows;

  $result_all_homs->data_seek(0);
  $result_arr[] = $result_all_homs->fetch_array(MYSQLI_ASSOC);

for ($i = 1 ; $i < $home_all; ++$i) {
    $result_all_homs->data_seek($i);
    
    $arr = $result_all_homs->fetch_array(MYSQLI_ASSOC);
    $flag = true;

    foreach($result_arr as $value)
    {
      if (($value['street_id'] == $arr['street_id']) && ($value['home_number'] == $arr['home_number']))
      {
        $flag = false; break;
      }
    }

    if ($flag)
      {
        $result_arr[] = $arr;
        $queryAdd = "INSERT INTO `homs`(home_number, street_id) VALUES (\"" . $arr['home_number'] . "\"," . $arr['street_id'] . ")";
        
        echo '<pre>';
        echo $queryAdd;
        echo '<pre>';

        $resultAdd = db_query($queryAdd);

        if (!$resultAdd) echo "Сбой при вставке данных: $queryAdd <br>" . $connectDB->error . "<br><br>";
      }
} 
die('Всё ОК'); */
//конец блока

//$query1 = "SELECT abon_id, street_id, home_number FROM `abonents_tv`";

// добавляем id домов в основную таблицу
/* 
$query1 = "SELECT abonents_tv.abon_id, abonents_tv.street_id, abonents_tv.home_number, homs.home_id 
           FROM abonents_tv, homs
           WHERE abonents_tv.home_number=homs.home_number AND abonents_tv.street_id=homs.street_id";

$result = db_query($query1);

if (!$result) die ($connectDB->error);

for ($i = 0 ; $i < $result->num_rows; ++$i) {
    $result->data_seek($i);
    
    $arr = $result->fetch_array(MYSQLI_ASSOC);
       
    echo '<pre>';
    print_r ($arr);
    echo '<pre>';
        
    $queryUpdate = "UPDATE abonents_tv SET home_id='$arr[home_id]' WHERE abon_id='$arr[abon_id]'";
    $resultAdd = db_query($queryUpdate);

    if (!$resultAdd) echo "Сбой при вставке данных: $queryAdd <br>" . $connectDB->error . "<br><br>";
      
} 
die('Всё ОК');

 */
/* 
//замена улиц на id
$query1 = "SELECT * FROM `streets`"; //выбираем все улицы
$result_all_streets = $connectDB->query($query1);
if (!$result_all_streets) die ($connectDB->error);
  $street_all = $result_all_streets->num_rows;

for ($i = 0 ; $i < $street_all; ++$i) {
    $result_all_streets->data_seek($i);
    
    $arr = $result_all_streets->fetch_array(MYSQLI_ASSOC);
    $strId = $arr['id'];
    $strName = $arr['Street'];
    
    $queryAdd = "UPDATE `abonents_tv` SET `Street_id` =" . "\"" . $strId ."\"" . "WHERE `abonents_tv`.`E` =\"" . $strName . "\"";
    echo $queryAdd;
    
    $resultAdd = $connectDB->query($queryAdd);
    if (!$resultAdd) echo "Сбой при вставке данных: $queryAdd <br>" . $connectDB->error . "<br><br>";
 } die;
//конец блока
  */



//замена районов на id
/* 
    $query_find_id = "SELECT id FROM `rayon` WHERE rayon =\"" . $row['D'] . "\"";
    $numId = (($connectDB->query($query_find_id))->fetch_array(MYSQLI_ASSOC)['id']);
    $queryAdd = "UPDATE `abonents_tv` SET `Rayon_id` = $numId WHERE `abonents_tv`.`D` =\"" . $row['D'] . "\"";
    $resultAdd = $connectDB->query($queryAdd);
    if (!$resultAdd) echo "Сбой при вставке данных: $queryAdd <br>" . $connectDB->error . "<br><br>";
  */   
//конец блока








?>