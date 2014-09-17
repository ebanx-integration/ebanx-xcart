<table cellspacing="1" cellpadding="5" class="settings-table">

  <tr>
    <td class="setting-name">
    <label for="settings_integrationkey">{t(#Integration Key#)}</label>
    </td>
    <td>
    <input type="text" id="settings_integrationkey" name="settings[integrationkey]" value="{paymentMethod.getSetting(#integrationkey#)}" class="validate[required,maxSize[255]]" />
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_test">{t(#Test Mode#)}</label>
    </td>
    <td>
    <select id="settings_test" name="settings[test]">
      <option value="true" selected="{isSelected(paymentMethod.getSetting(#test#),#true#)}">Enabled</option>
      <option value="false" selected="{isSelected(paymentMethod.getSetting(#test#),#false#)}">Disabled</option>
    </select>
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_installments">{t(#Installments#)}</label>
    </td>
    <td>
    <select id="settings_installments" name="settings[installments]">
      <option value="true" selected="{isSelected(paymentMethod.getSetting(#installments#),#true#)}">Enabled</option>
      <option value="false" selected="{isSelected(paymentMethod.getSetting(#installments#),#false#)}">Disabled</option>
    </select>
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_installments">{t(#Installments#)}</label>
    </td>
    <td>
    <select id="settings_installments" name="settings[installments]">
      <option value="true" selected="{isSelected(paymentMethod.getSetting(#installments#),#true#)}">Enabled</option>
      <option value="false" selected="{isSelected(paymentMethod.getSetting(#installments#),#false#)}">Disabled</option>
    </select>
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_rate">{t(#Installments interest rate (%)#)}</label>
    </td>
    <td>
    <input type="text" id="settings_rate" name="settings[rate]" value="{paymentMethod.getSetting(#rate#)}" class="validate[required,maxSize[255]]" />
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_boleto">{t(#Enable boleto payments#)}</label>
    </td>
    <td>
    <select id="settings_boleto" name="settings[boleto]">
      <option value="true" selected="{isSelected(paymentMethod.getSetting(#boleto#),#true#)}">Enabled</option>
      <option value="false" selected="{isSelected(paymentMethod.getSetting(#boleto#),#false#)}">Disabled</option>
    </select>
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_ccard">{t(#Enable credit card payments#)}</label>
    </td>
    <td>
    <select id="settings_ccard" name="settings[ccard]">
      <option value="true" selected="{isSelected(paymentMethod.getSetting(#ccard#),#true#)}">Enabled</option>
      <option value="false" selected="{isSelected(paymentMethod.getSetting(#ccard#),#false#)}">Disabled</option>
    </select>
    </td>
  </tr>

  <tr>
    <td class="setting-name">
    <label for="settings_tef">{t(#Enabled TEF payments#)}</label>
    </td>
    <td>
    <select id="settings_tef" name="settings[tef]">
      <option value="true" selected="{isSelected(paymentMethod.getSetting(#tef#),#true#)}">Enabled</option>
      <option value="false" selected="{isSelected(paymentMethod.getSetting(#tef#),#false#)}">Disabled</option>
    </select>
    </td>
  </tr>
</table>
