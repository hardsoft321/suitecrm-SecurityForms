if (!lab321) var lab321 = {};
if (!lab321.sform) lab321.sform = {};

lab321.sform.disableForm = function(formId, enabledFields) {
    if(typeof enabledFields === 'undefined') enabledFields = [];
    $('#'+formId).find('select:visible:not(.sf-disabled), input:not(.button), textarea').each(function() {
        for(var i in enabledFields)
            if(enabledFields[i] == this.name || (!this.name && (enabledFields[i]+'_date' == this.id || enabledFields[i]+'_hours' == this.id || enabledFields[i]+'_minutes' == this.id || enabledFields[i]+'_meridiem' == this.id)))
                return;
        var x = $(this);
        var img = $('img#'+this.id+'_trigger:visible:not(.sf-dummy-trigger)');
        img.after(img.clone().addClass('sf-dummy-trigger')).hide();
        if(x.is(':checkbox'))
            x.attr('disabled', 'disabled');
        $('#btn_'+this.id+', #btn_clr_'+this.id).attr('disabled', 'disabled');
        if(x.is('select')) {
            var ul = $('<ul id="sf-'+this.name+'" class="sf-select"></ul>').insertAfter(x);
            x.hide().find('option:selected').each(function() {
                ul.append('<li>'+$(this).text()+'</li>');
            });
        }
        x.attr('readOnly', 'readOnly').addClass('sf-disabled');
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
