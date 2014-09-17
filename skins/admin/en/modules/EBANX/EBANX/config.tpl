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

</table>
