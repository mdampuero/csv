var opendErrorMeesage=false;
$(function () {    
    $('form')
    .find('input, textarea','select')
    .blur(function(){
        // Run validation for this field
        // {# $(this).jsFormValidator('validate') #}
    })
    .focus(function() {
        // Reset markers when focus on a field
        $(this).removeClass('error');
        $(this).removeClass('ready');
    })
    .jsFormValidator({
        'showErrors': function(errors,sourceId) {
            if (errors.length) {
                if(!opendErrorMeesage){
                    opendErrorMeesage=true;
                    $.toast({
                        heading: 'Error',
                        text: 'Revise los campos del formulario',
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'error',
                        hideAfter: 2000,
                        maxOpened: 1,
                        afterHidden: function () {
                            opendErrorMeesage=false;
                        }
                    });
                }                
                $(this).removeClass('ready');
                $(this).addClass('error');
            } else {
                $(this).removeClass('error');
                $(this).addClass('ready');
            }
            var container = $(this).siblings('div.form-errors');
            if (!container.length) {
                $(this).after('<div class="form-errors"></div>');
                container=$(this).siblings('div.form-errors');
            }
            var list = $(container).find('ul');
            if (!list.length) {
                list = $('<ul></ul>');
                container.append(list);
            }
            list.find('.' + sourceId).remove();
            
            for (var i in errors) {
                var li = $('<li></li>', {
                    'class': sourceId,
                    'text': errors[i]
                });
                list.append(li);
            }
        }
    }); 
});