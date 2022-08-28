<!-- модальное окно редактирования карты абонента -->
<div id="abon-card" class="modal abon-card">
  <div id="abon-edit" class="modal-dialog">

    <div class="modal-header">
      <img id="icon-for-card" src="/icons/user_edit_256.png">
      <h3 id="modal-title" class="modal-title">Карточка абонента id 0000</h3>
      <button id="aboncard-modal-close-button" class="modal-close-button">&times;</button>
    </div>
    <!-- .modal-header -->

      <form class="modal-body" action="#">

        <fieldset class="modal-form-data">
          <legend> Данные абонента </legend>
            <label class="modal-row" for="abon_name">ФИО
              <input class="field-for-send" name = "abon_name" id="abon_name" type="text" maxlength="60" placeholder="Фамилия Имя Отчество" required>
            </label> 

            <label class="modal-row" for="phone_number">Телефон
              <input class="field-for-send" id="phone_number" maxlength="12" placeholder="38 097 524 32 32" autocomplete="off" type="phone"> 
            </label> 		

            <label class="modal-row" maxlength="512" for="notes">Примечания
              <textarea class="field-for-send" id="notes" placeholder="Дополнительные данные" type="text"></textarea>
            </label>
        </fieldset>

        <fieldset class="modal-form-data">
          <legend>Адрес</legend>

          <label class="modal-row" for="rayon-name-modal">Район
            <select class="field-for-send" name="rayon-name-modal" id="rayon_id" maxlength="60" required></select>
          </label>

          <label class="modal-row" for="street-name-modal">Улица
            <select class="field-for-send" name="street-name-modal" id="street_id" required></select>
          </label>

          <div class="modal-row">
              <label for="home-number-modal">Дом
                <select class="field-for-send" name="home-number-modal" id="home_id" required></select>
              </label>

              <label for="appartment-number-modal">Квартира
                <input class="field-for-send" name="appartment-number-modal" id="appartment_number" maxlength="10" type="text">
              </label>
            </div>
        </fieldset>
      </form>
      <!-- /.modal-body -->
      <div id="modal-error-messages" class="modal-error-messages"></div>
      <div class="footer-buttons">
        <button id="aboncard-modal-cancel-button" class="button cancel">Отмена</button>
        <button id="modal-save-button" class="button button-save">Сохранить изменения</button>
      </div>
      <!-- .footer-buttons -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->