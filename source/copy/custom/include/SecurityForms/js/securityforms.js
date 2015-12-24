/**
 * @license http://hardsoft321.org/license/ GPLv3
 * @author Evgeny Pervushin <pea@lab321.ru>
 * @package SecurityForms
 */
if (!lab321) var lab321 = {};
if (!lab321.sform) lab321.sform = {};

lab321.sform.disableForm = function(formId, enabledFields) {
    if(typeof enabledFields === 'undefined') enabledFields = [];
    $('#'+formId).find('select:visible:not(.sf-disabled), input:not(.button), textarea').each(function() {
        for(var i in enabledFields)
            if(enabledFields[i] == this.name || (!this.name && (enabledFields[i]+'_date' == this.id || enabledFields[i]+'_hours' == this.id || enabledFields[i]+'_minutes' == this.id || enabledFields[i]+'_meridiem' == this.id)))
                return;
        lab321.sform.disableElement(this);
    });
    if(enabledFields.indexOf('emailAddress') == -1) {
        lab321.sform.disableEmailAddress(formId);
    }
}

lab321.sform.disableFields = function(formId, disabledFields) {
    $('#'+formId).find('select:visible:not(.sf-disabled), input:not(.button), textarea').each(function() {
        for(var i in disabledFields)
            if(disabledFields[i] == this.name || (!this.name && (disabledFields[i]+'_date' == this.id || disabledFields[i]+'_hours' == this.id || disabledFields[i]+'_minutes' == this.id || disabledFields[i]+'_meridiem' == this.id))) {
                lab321.sform.disableElement(this);
            }
    });
    if(disabledFields.indexOf('emailAddress') >= 0) {
        lab321.sform.disableEmailAddress(formId);
    }
}

lab321.sform.disableElement = function(elem) {
    var x = $(elem);
    var img = $('img#'+elem.id+'_trigger:visible:not(.sf-dummy-trigger)');
    img.after(img.clone().addClass('sf-dummy-trigger')).hide();
    if(x.is(':checkbox'))
        x.attr('disabled', 'disabled');
    $('#btn_'+elem.id+', #btn_clr_'+elem.id).attr('disabled', 'disabled');
    if(x.is('select')) {
        var ul = $('<ul id="sf-'+elem.name+'" class="sf-select"></ul>').insertAfter(x);
        x.hide().find('option:selected').each(function() {
            ul.append('<li>'+$(this).text()+'</li>');
        });
    }
    x.attr('readOnly', 'readOnly').addClass('sf-disabled');
}

lab321.sform.disableEmailAddress = function(formId) {
    if(typeof SUGAR.EmailAddressWidget === "undefined") {
        if(typeof console !== "undefined") {
            console.error("No SUGAR.EmailAddressWidget");
        }
        return;
    }
    SUGAR.EmailAddressWidget.prototype.prefillEmailAddresses_orig = SUGAR.EmailAddressWidget.prototype.prefillEmailAddresses;
    SUGAR.EmailAddressWidget.prototype.prefillEmailAddresses = function(tableId,o) {
        this.prefillEmailAddresses_orig(tableId,o);
        if($('#'+formId).find('#'+tableId).length)
            lab321.sform.disableEmailAddressesTable(tableId);
    };
    SUGAR.EmailAddressWidget.prototype.addEmailAddress_orig = SUGAR.EmailAddressWidget.prototype.addEmailAddress;
    SUGAR.EmailAddressWidget.prototype.addEmailAddress = function(tableId,address,primaryFlag,replyToFlag,optOutFlag,invalidFlag,emailId) {
        this.addEmailAddress_orig(tableId,address,primaryFlag,replyToFlag,optOutFlag,invalidFlag,emailId);
        if($('#'+formId).find('#'+tableId).length)
            lab321.sform.disableEmailAddressesTable(tableId);
    }
}

lab321.sform.disableEmailAddressesTable = function(tableId) {
    $('#'+tableId).find('input, button').each(function() {
        $(this).attr('disabled', 'disabled').attr('readOnly', 'readOnly').addClass('sf-disabled');
    });
}

lab321.sform.enableForm = function(formId, disabledFields) {
    if(typeof disabledFields === 'undefined') disabledFields = [];
    $('#'+formId).find('select.sf-disabled, input.sf-disabled:not(.button), textarea.sf-disabled').each(function() {
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
