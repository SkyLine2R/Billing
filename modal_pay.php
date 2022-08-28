<!-- модальное окно оплаты -->
<div id="pay-card" class="modal abon-card">
  <div id="pay-window" class="modal-dialog">

    <div class="modal-header">
      <img id="icon-for-card" src="/icons/pay_256.png">
      <h3 id="pay-modal-title" class="modal-title">Оплата услуг</h3>
      <button id="pay-modal-close-button" class="modal-close-button">&times;</button>
    </div>
    <!-- .modal-header -->

      <form class="modal-body" action="#">

        <fieldset class="modal-form-data">
          <legend> Данные абонента </legend>
            <p>Текущий баланс: <span>0.00</span></p>
            <p>Стоимость тарифа на 30 дней: <span>199.00</span></p>
            <p>Стоимость тарифа за 1 день <span>0.00</span></p>

            <label class="modal-row" for="pay-summ">Сумма для оплаты:
              <input class="field-for-send" name = "pay-summ" id="pay-summ" type="number" maxlength="60" placeholder="Сумма" required>
            </label> 


            <label class="modal-row" for="pay-days">Оплатить за дни:
              <input class="field-for-send" name = "pay-days" id="pay-days" type="number" maxlength="60" placeholder="Кол-во дней">
            </label> 


            <label class="modal-row" for="phone_number">Телефон
              <input class="field-for-send" id="phone_number" maxlength="12" placeholder="38 097 524 32 32" autocomplete="off" type="phone"> 
            </label> 		

            <label class="modal-row" maxlength="512" for="notes">Примечания
              <textarea class="field-for-send" id="notes" placeholder="Дополнительные данные" type="text"></textarea>
            </label>
        </fieldset>

      </form>
      <!-- /.modal-body -->
      <div id="modal-error-messages" class="modal-error-messages"></div>
      <div class="footer-buttons">
        <button id="pay-modal-cancel-button" class="button cancel">Отмена</button>
        <button id="pay-modal-save-button" class="button button-save">Сохранить изменения</button>
      </div>
      <!-- .footer-buttons -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->