const modalAbonCard = O("abon-card"),
  modalPay = O("pay-card"),
  abonTableRow = C("tr-activ");

O("add-abonent").onclick = () => {
  refreshModal();
}; // добавление нового абонента

for (let i = 0; i < abonTableRow.length; i++) {
  // назначение событий редактирования для каждой строки таблицы

  abonTableRow[i].querySelector(".abon-id").onclick = () => {
    // клик по id абонента для вывода карточки

    const abonID = abonTableRow[i].querySelector(".abon-id").innerHTML,
      abonent = getAbonent(`abon_id=${abonID}`);
    refreshModal(abonent);
  };

  abonTableRow[i].querySelector(".balans-in-table").onclick = () => {
    // клик по балансу для финансовых махинаций

    const abonID = abonTableRow[i].querySelector(".abon-id").innerHTML,
      abonent = getAbonent(`abon_id=${abonID}`);
    refreshModalPay(abonent);

    //abonTableRow[i].querySelector('.abon-name').innerHTML = 'здесь будет форма'
  };
}
if (O("rayon_id")) {
  O("rayon_id").onchange = () => {
    //изменён район

    O("street_id").innerHTML = setDataForSelect(
      "streets",
      null,
      O("rayon_id").value
    );
    O("home_id").innerHTML = setDataForSelect(
      "homes",
      null,
      O("street_id").value
    );
  };

  O("street_id").onchange = () => {
    //изменена улица

    O("home_id").innerHTML = setDataForSelect(
      "homes",
      null,
      O("street_id").value
    );
  };
}

function abonentSave(abon_id) {
  let err =
    validateAbonName(O("abon_name").value) +
    validatePhone(O("phone_number").value);

  if (err) {
    O("modal-error-messages").innerHTML = err;
  } else {
    const fields = C("field-for-send");
    const arr = [];

    if (abon_id) {
      arr.push(`abon_id=${abon_id}`);
    }

    for (let i = 0; i < fields.length; i++) {
      arr.push(`${fields[i].id}=${fields[i].value}`);
    }

    alert(getAjax(arr.join("&"), (url = "putsqldata.php")));
  }
}

function getAjax(params, url = "getsqldata.php") {
  let responseData;

  if (!params) return;

  request = new XMLHttpRequest();

  with (request) {
    open("POST", url, false);
    setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    onreadystatechange = function () {
      if (this.readyState == 4)
        if (this.status == 200)
          if (this.response != null) {
            console.log(response);
            responseData =
              this.response[0] == "["
                ? JSON.parse(this.response)
                : this.response;
          } else console.warn("Ошибка AJAX: данные не получены");
    };
    send(params);
  }
  return responseData;
}

function getAbonent(postStr) {
  return getAjax(postStr)[0];
}

function setDataForSelect(table, abonValueId, filterValueId) {
  const dataSql = getAjax(
    table == "rayons"
      ? `table=${table}`
      : `table=${table}&filter='${filterValueId}'`
  );
  let htmls = "";

  for (let data in dataSql) {
    let value1 =
        dataSql[data].rayon_id ||
        dataSql[data].street_id ||
        dataSql[data].home_id,
      value2 =
        dataSql[data].rayon_name ||
        dataSql[data].street_name ||
        dataSql[data].home_number;

    htmls += `<option value="${value1}"
              ${value1 == abonValueId ? "selected" : ""}>${value2}</option>`;
  }

  return htmls;
}

function O(i) {
  return typeof i == "object" ? i : document.getElementById(i);
}
function S(i) {
  return O(i).style;
}
function C(i) {
  return document.getElementsByClassName(i);
}

function validateAbonName(field) {
  if (field == "") return "<p>Не введено имя абонента.</p>";
  else if (field.length < 5)
    return "<p>В имени абонента должно быть не менее 5 символов.</p>";
  //else if (/[^a-zA-Z0-9_-]/.test(field))  return '<p>В имени абонента разрешены только буквенные, числовые символы и знаки (" - _).</p>'
  return "";
}

function validatePhone(field) {
  if ((field.length < 9) & (field.length > 0))
    return "<p>Поле телефон должно содержать 9-11 числовых символов.</p>";
  else if (/[^0-9]/.test(field))
    return "<p>В поле телефон разрешены только числовые символы.</p>";
  return "";
}

function refreshModal(abonent = {}) {
  if (abonent.abon_id) {
    O("modal-title").innerHTML = `Карточка абонента (id ${abonent.abon_id})`;
    O("icon-for-card").src = "/icons/user_edit_256.png";
  } else {
    O("modal-title").innerHTML = `Регистрация нового абонента`;
    O("icon-for-card").src = "/icons/user_add_256.png";
  }

  O("abon_name").value = abonent.abon_name || "";
  O("phone_number").value = abonent.phone_number || "";
  O("notes").value = abonent.notes || "";
  O("rayon_id").innerHTML = setDataForSelect("rayons", abonent.rayon_id);

  O("street_id").innerHTML = abonent.abon_id
    ? setDataForSelect("streets", abonent.street_id, abonent.rayon_id)
    : setDataForSelect("streets", null, O("rayon_id").value);

  O("home_id").innerHTML = abonent.abon_id
    ? setDataForSelect("homes", abonent.home_id, abonent.street_id)
    : setDataForSelect("homes", null, O("street_id").value);

  O("appartment_number").value = abonent.appartment_number || "";
  O("modal-error-messages").innerHTML = "";

  modalAbonCard.style.display = "flex";

  closeModal("aboncard-", modalAbonCard);

  O("modal-save-button").onclick = () => {
    abonentSave(abonent.abon_id || null);
  }; //изменение данных или регистрация абонента
}

function refreshModalPay(abonent) {
  O(
    "pay-modal-title"
  ).innerHTML = `${abonent.abon_name} (id ${abonent.abon_id})`;

  modalPay.style.display = "flex";
  closeModal("pay-", modalPay);
}

function closeModal(buttonPrefix, windowName) {
  O(buttonPrefix + "modal-close-button").onclick = () => {
    windowName.style.display = "none";
  };

  O(buttonPrefix + "modal-cancel-button").onclick = () => {
    windowName.style.display = "none";
  };
}
