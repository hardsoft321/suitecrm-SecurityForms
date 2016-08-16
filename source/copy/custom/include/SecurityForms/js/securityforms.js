/**
 * @license http://hardsoft321.org/license/ GPLv3
 * @author Evgeny Pervushin <pea@lab321.ru>
 * @package SecurityForms
 */
if (!lab321) var lab321 = {};
if (!lab321.sform) lab321.sform = {};

lab321.sform.disableForm = function(formSelector, enabledFields) {
    if(typeof enabledFields === 'undefined') enabledFields = [];
    enabledFields.push('_sform_onoffswitch');
    $(formSelector).find('select:visible:not(.sf-disabled), input:not(.button), textarea').each(function() {
        for(var i in enabledFields)
            if(enabledFields[i] == this.name || (!this.name && (enabledFields[i]+'_date' == this.id || enabledFields[i]+'_hours' == this.id || enabledFields[i]+'_minutes' == this.id || enabledFields[i]+'_meridiem' == this.id)))
                return;
        lab321.sform.disableElement(this);
    });
    if(enabledFields.indexOf('emailAddress') == -1) {
        lab321.sform.disableEmailAddress(formSelector);
    }
    if(lab321.sform.isAdmin) {
        lab321.sform.showEnableDialog('MODE_DEFAULT_DISABLED', formSelector, enabledFields, null);
    }
}

lab321.sform.disableFields = function(formSelector, disabledFields) {
    $(formSelector).find('select:visible:not(.sf-disabled), input:not(.button), textarea').each(function() {
        for(var i in disabledFields)
            if(disabledFields[i] == this.name || (!this.name && (disabledFields[i]+'_date' == this.id || disabledFields[i]+'_hours' == this.id || disabledFields[i]+'_minutes' == this.id || disabledFields[i]+'_meridiem' == this.id))) {
                lab321.sform.disableElement(this);
            }
    });
    if(disabledFields.indexOf('emailAddress') >= 0) {
        lab321.sform.disableEmailAddress(formSelector);
    }
    if(lab321.sform.isAdmin) {
        lab321.sform.showEnableDialog('MODE_DEFAULT_ENABLED', formSelector, null, disabledFields);
    }
}

lab321.sform.allowAllFieldsSave = function(formSelector) {
    $(formSelector).append($('<input type="hidden" name="allowAllFieldsSave" value="1">'));
}
lab321.sform.disallowAllFieldsSave = function(formSelector) {
    $(formSelector+' input[name="allowAllFieldsSave"]').remove();
}

lab321.sform.disableElement = function(elem) {
    var x = $(elem);
    var img = $('img#'+elem.id+'_trigger:visible:not(.sf-dummy-trigger)');
    img.after(img.clone().addClass('sf-dummy-trigger')).hide();
    if(x.is(':checkbox'))
        x.attr('disabled', 'disabled');
    $('#btn_'+elem.id+', #btn_clr_'+elem.id).attr('disabled', 'disabled');
    $(x).closest('td').find('#remove_button').attr('disabled', 'disabled');
    if(x.is('select')) {
        var ul = $('<ul id="sf-'+elem.name+'" class="sf-select"></ul>').insertAfter(x);
        x.hide().find('option:selected').each(function() {
            ul.append('<li>'+$(this).text()+'</li>');
        });
    }
    x.attr('readOnly', 'readOnly').addClass('sf-disabled');
}

lab321.sform.disableEmailAddress = function(formSelector) {
    if(typeof SUGAR.EmailAddressWidget === "undefined") {
        return;
    }
    SUGAR.EmailAddressWidget.prototype.prefillEmailAddresses_orig = SUGAR.EmailAddressWidget.prototype.prefillEmailAddresses;
    SUGAR.EmailAddressWidget.prototype.prefillEmailAddresses = function(tableId,o) {
        this.prefillEmailAddresses_orig(tableId,o);
        if($(formSelector).find('#'+tableId).length)
            lab321.sform.disableEmailAddressesTable(tableId);
    };
    SUGAR.EmailAddressWidget.prototype.addEmailAddress_orig = SUGAR.EmailAddressWidget.prototype.addEmailAddress;
    SUGAR.EmailAddressWidget.prototype.addEmailAddress = function(tableId,address,primaryFlag,replyToFlag,optOutFlag,invalidFlag,emailId) {
        this.addEmailAddress_orig(tableId,address,primaryFlag,replyToFlag,optOutFlag,invalidFlag,emailId);
        if($(formSelector).find('#'+tableId).length)
            lab321.sform.disableEmailAddressesTable(tableId);
    }
}

lab321.sform.disableEmailAddressesTable = function(tableId) {
    $('#'+tableId).find('input, button').each(function() {
        $(this).attr('disabled', 'disabled').attr('readOnly', 'readOnly').addClass('sf-disabled');
    });
}

lab321.sform.enableForm = function(formSelector, disabledFields) {
    if(typeof disabledFields === 'undefined') disabledFields = [];
    $(formSelector).find('select.sf-disabled, input.sf-disabled:not(.button), textarea.sf-disabled').each(function() {
        for(var i in disabledFields)
            if(disabledFields[i] == this.name || (!this.name && (disabledFields[i]+'_date' == this.id || disabledFields[i]+'_hours' == this.id || disabledFields[i]+'_minutes' == this.id || disabledFields[i]+'_meridiem' == this.id)))
                return;
        var x = $(this);
        $('img#'+this.id+'_trigger.sf-dummy-trigger').remove();
        $('img#'+this.id+'_trigger').show();
        if(x.is(':checkbox'))
            x.removeAttr('disabled');
        $('#btn_'+this.id+', #btn_clr_'+this.id).removeAttr('disabled');
        if(x.is('select')) {
            x.show();
            $('#sf-'+this.name).remove();
        }
        x.removeAttr('readOnly').removeClass('sf-disabled');
    });
}

lab321.sform.showEnableDialog = function(mode, formSelector, enabledFields, disabledFields) {
    if($('.enable-dialog').length)
        return;
    $('<div class="enable-dialog">\
<table>\
  <tr>\
    <td><span>'+SUGAR.language.get("app_strings", "MSG_ALLOW_ALL_FIELDS_SAVE")+'</span></td>\
    <td class="buttons">\
      <div class="onoffswitch">\
        <input type="checkbox" name="_sform_onoffswitch" class="onoffswitch-checkbox" id="sform-switch">\
        <label class="onoffswitch-label" for="sform-switch">\
          <span class="onoffswitch-inner"></span>\
          <span class="onoffswitch-switch"></span>\
        </label>\
      </div>\
    </td>\
  </tr>\
</table>\
</div>')
    .find('#sform-switch').change(function() {
        lab321.sform.toggleForm($(this).is(':checked'), mode, formSelector, enabledFields, disabledFields);
    })
    .end()
    .prependTo($(formSelector+' #EditView_tabs').length ? $(formSelector+' #EditView_tabs') : $(formSelector));
}

lab321.sform.toggleForm = function(enable, mode, formSelector, enabledFields, disabledFields) {
    if(enable) {
        lab321.sform.enableForm(formSelector);
        lab321.sform.allowAllFieldsSave(formSelector);
    }
    else {
        if(mode == 'MODE_DEFAULT_ENABLED')
            lab321.sform.disableFields(formSelector, disabledFields);
        else if(mode == 'MODE_DEFAULT_DISABLED')
            lab321.sform.disableForm(formSelector, enabledFields);
        lab321.sform.disallowAllFieldsSave(formSelector);
    }
}
