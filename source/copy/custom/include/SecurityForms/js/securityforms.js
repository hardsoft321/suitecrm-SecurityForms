if (!lab321) var lab321 = {};
if (!lab321.sform) lab321.sform = {};

lab321.sform.disableForm = function(formId, enabledFields) {
    $(':form select:visible:not(.sf-disabled), :form input:not(.button), :form textarea'.replace(/:form/g, '#'+formId)).each(function() {
        if(enabledFields.indexOf(this.name) >= 0)
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
