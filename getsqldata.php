<?php
require_once 'includes/functions.php';

if (isset($_POST['abon_id']))
{

  $abon_id = sanitizeMySQL(db(), $_POST['abon_id']);
  $sqlstring = "SELECT * FROM `abonents_tv` 
                                JOIN streets ON abonents_tv.street_id=streets.street_id 
                                JOIN rayons ON streets.rayon_id=rayons.rayon_id
                                JOIN homes ON abonents_tv.home_id=homes.home_id
                                WHERE abon_id=$abon_id";

} elseif (isset($_POST['table']) && isset($_POST['filter']))

  {
    $table = sanitizeMySQL(db(), $_POST['table']);
    $filter = sanitizeMySQL(db(), $_POST['filter']);

    $idfilter = ($table == 'streets') ? 'rayon_id' : 'street_id';
    $field =    ($table == 'streets') ? 'street_id, street_name' : 'home_id, home_number';

    $sqlstring = "SELECT $field FROM $table WHERE $idfilter=$filter";

  } elseif (isset($_POST['table']))

    {
      $table = sanitizeMySQL(db(), $_POST['table']);
      $sqlstring = "SELECT * FROM $table";

    } else die ('Ошибка получения данных - не сформирован запрос');

  $result = db_query($sqlstring);
  

  $arrayObjectJson = "[ ";
  
  for ($i = 0; $i < $result->num_rows; $i++)
  {
    $result->data_seek($i);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $arrayObjectJson = $arrayObjectJson . getObjectJson($row) . ", ";
  }
  
  echo mb_substr($arrayObjectJson, 0, mb_strlen($arrayObjectJson)-2)  . "]";
  
$result->close();


function getObjectJson($row)
{
  $objectJson = '{';
  
  foreach ($row as $item => $description)
  {
    $objectJson = $objectJson . '"' . $item . '": ' . '"' . $description . '", ';
  }

  return mb_substr($objectJson, 0, mb_strlen($objectJson)-2)  . "} ";
 
}
?>