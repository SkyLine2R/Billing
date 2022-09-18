<?php
include('modal_abon_card.php');
include('modal_pay.php');
//основа запроса
/* $query = "SELECT `abon_id`, `abon_name`, `balance`, `phone_number`, `notes`, `street_id`, `home_id`, `appartment_number`,  `tarif_tv_name` 
          FROM `abonents_tv` 
          JOIN streets.street_name ON abonents_tv.street_id=streets.street_id
          JOIN rayons ON streets.rayon_id=rayons.rayon_id
          JOIN homes.home_number ON abonents_tv.home_id=homes.home_id
          JOIN tarifs_tv ON abonents_tv.tarif_tv_id=tarifs_tv.tarif_tv_id"; */



$query = "SELECT abon_id, abon_name, balance, phone_number, notes, abonents_tv.street_id, street_name, rayon_name, homes.home_number, abonents_tv.home_id, appartment_number, tarif_tv_name 
          FROM `abonents_tv` 
          JOIN streets ON abonents_tv.street_id=streets.street_id
          JOIN rayons ON streets.rayon_id=rayons.rayon_id
          JOIN homes ON abonents_tv.home_id=homes.home_id
          JOIN tarifs_tv ON abonents_tv.tarif_tv_id=tarifs_tv.tarif_tv_id";

// проверяем заполненность полей фильтра, при необходимости дополняем запрос
$where_or_and = 'WHERE ';

foreach($_POST as $item=>$description)
{ 
  if (($_POST[$item]) && ($item != "filter-button"))
  {
    $index_name = sanitizeMySQL(db(), $item);
    $value = dopsymhol_search (db(), trim($_POST[$item]));
    $query .= ($index_name == 'abon_name') ?
                                          " $where_or_and `$index_name` LIKE '%" . substr($value, 2, -1) . "%' " :
                                          " $where_or_and `$index_name`$value ";
    $where_or_and = 'AND ';
  }
}
$query .= " LIMIT 50"; //добавить функционал количества отображения, пролистываения
//echo $query;
?>
  <header>
  <button class="button" id="add-abonent">Добавить абонента</button>
	<div class="filter-fields">
        <form action="index.php" method="post" >
        <legend>Фильтр</legend>
        <table>
            <tr>
                <td>
                    <label class="filter-label" for="abon_id">ID</label>
                    <input type="search" name="abon_id" maxlength="6" size="4" placeholder="Все">
                </td>
                <td>
                    <label class="filter-label" for="abon_name">ФИО</label>
                    <input type="search" name="abon_name" maxlength="40" size="25" placeholder="Все абоненты">
                </td>
                <td>
                    <label class="filter-label" for="balance">Баланс</label>
                    <input type="text" name="balance" maxlength="5" size="5" placeholder="Любой">
                </td>
                <td>
                    <label class="filter-label" for="rayon_name">Район</label>
                    <input name="rayon_name" type="text" list="all-rayons" maxlength="15" size="12" placeholder="Все">
                    <datalist id="all-rayons">
                      <select>
                          <?php echo get_data_for_options("rayons", "rayon_name") ?>
                      </select>
                    </datalist>
                </td>
                <td>
                    <label class="filter-label" for="street_name">Улица</label>
                    <input name="street_name" type="text" list="all-streets" maxlength="40" size="15" placeholder="Все">
                    <datalist id="all-streets">
                      <select>
                          <?php echo get_data_for_options("streets", "street_name") ?>
                      </select>
                    </datalist>
                </td>
                <td>
                    <label class="filter-label" for="home_number">Дом</label>
                    <input type="text" name="home_number" maxlength="15" size="4" placeholder="Все">     
                </td>
                <td>
                    <label class="filter-label" for="appartment_number">Кв.</label>
                    <input type="text" name="appartment_number" maxlength="4" size="3" placeholder="Все">
                </td>
                <td>
                    <label class="filter-label" for="tarif_tv_name">Пакет</label>
                    <input name="tarif_tv_name" list="all-tarif" type="text" maxlength="25" size="20" placeholder="Все">
                    <datalist id="all-tarif">
                      <select>
                          <?php echo get_data_for_options("tarifs_tv", "tarif_tv_name") ?>
                      </select>
                    </datalist>
                </td>
            </tr>
        </table>
        <div class="buttons-filter">
          <input class="button" type="submit" name="filter-button" value="Обновить" />
        </div>
        </form>
      </div>
	</header>

<main>
	
  <div class="back-red">

<?php
$result = db_query($query);
$rows = $result->num_rows;
if ($rows == 0)
{
  echo "<h3 class=\"main-db\">По вашему запросу ничего не найдено.</h3>";
  die;
};
  echo <<<_END

    <table class="main-db">
      <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Баланс</th>
        <th>Район</th>
        <th>Улица</th>
        <th>Дом</th>
        <th>Квартира</th>
        <th>Пакет</th>
      </tr>
  _END;


  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $phone_number = substr($row['phone_number'], 0, 2) . ' ' 
                  . substr($row['phone_number'], 2, 3) . ' ' 
                  . substr($row['phone_number'], 5, 3) . ' ' 
                  . substr($row['phone_number'], 8, 2) . ' ' 
                  . substr($row['phone_number'], 10, 2);
    printf( <<<_END
    <tr id="tr$row[abon_id]" class="tr-activ">
      <td class="abon-id">$row[abon_id]</td>
      <td class="abon-name">
      <details>
      <summary> $row[abon_name] </summary>
      <p class="notes-text"><b>Телефон:</b> $phone_number </p>
      <p class="notes-text"><b>Примечания:</b> $row[notes] </p>
    </details>
      </td>
      <td class="balans-in-table"> %.2f </td>
      <td> $row[rayon_name] </td>
      <td> $row[street_name] </td>
      <td> $row[home_number] </td>
      <td> $row[appartment_number] </td>
      <td class="tarif-tv-name">$row[tarif_tv_name] </td>
    </tr>
    _END, $row['balance']);
  };
echo "</table>";
  
$result->close();

?>

<div>
</main>

</body>
