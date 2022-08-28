<?php
require_once 'includes/functions.php';

$sqlstring = '';

if (isset($_POST['abon_id']))
{
  $sqlstring = 'UPDATE abonents_tv SET ';

  foreach ($_POST as $index => $item)
  {
    if ($index != 'abon_id' && $index != 'rayon_id')
    {
    $sqlstring .= sanitizeMySQL(db(), $index) . '="' . sanitizeMySQL(db(), $item) . '", ';
    }
  }
  $sqlstring = substr($sqlstring, 0, -2) . 'WHERE abon_id=' . sanitizeMySQL(db(), $_POST['abon_id']);

} else
  {

  $sqlstring = "SELECT abon_id FROM abonents_tv WHERE street_id=" . sanitizeMySQL(db(), $_POST['street_id']) .
                                                  " AND home_id=" . sanitizeMySQL(db(), $_POST['home_id']) .
                                                  " AND appartment_number=" . sanitizeMySQL(db(), $_POST['appartment_number']);

  $result = db_query ($sqlstring);

  if ($result->num_rows)
  {
    die ($result->fetch_assoc()['abon_id']);
  }
    
  $sqlstring = "INSERT INTO `abonents_tv` VALUES (" .
             "NULL, " . '"' .
              sanitizeMySQL(db(), $_POST['abon_name']) . '", "' .
              sanitizeMySQL(db(), $_POST['phone_number']) . '", "' .
              sanitizeMySQL(db(), $_POST['notes']) . '", "' .
              "0" . '", "' .
              sanitizeMySQL(db(), $_POST['street_id']) . '", "' .
              sanitizeMySQL(db(), $_POST['home_id']) . '", "' .
              sanitizeMySQL(db(), $_POST['appartment_number']) . '", "' .
              '0")';
  }

db_query ($sqlstring);
echo 'true';
                                            
?>
