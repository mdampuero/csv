function preRequest(){
    return {};
}
function showRequest(formData, form, options) { 
    let formID='';
    if(typeof form.attr('id') != 'undefined')
        formID='#'+form.attr('id')+' ';
    loading.show('Cargando...');
    var inputs=form.closest('form').find(':input:not(.dropify)');
    inputs.removeClass('error');
    inputs.next('small').html('');
    form.closest('form').find(':submit').attr('disabled',true);

    var data=preRequest();
    data['plainPassword']={ 
                first:'',
                second:''
            }
    for (var i = formData.length - 1; i >= 0; i--) {
        checkArray(data,formData[i]);
        if(formData[i].name=='plainPassword[first]'){
            data['plainPassword'].first=formData[i].value;
        }else if(formData[i].name=='plainPassword[second]'){
            data['plainPassword'].second=formData[i].value;
        }else{
            data[formData[i].name]=formData[i].value;
        }
    }
    
    // console.log($(".dropify-preview span.dropify-render img").attr("src"));
    // console.log(data);
    // return false;

    /** Add elements Gallery **/
    data.gallery=gallery;
    if(typeof form.attr('id') != 'undefined'){
        method=form.attr("method");
        var method=($('#'+form.attr('id')+' input[name="_method"]').length>0)?$('#'+form.attr('id')+' input[name="_method"]').val():form.attr("method");
    }else{
        var method=($('input[name="_method"]').length>0)?$('input[name="_method"]').val():form.attr("method");
    }
    $.ajax({
        url: form.attr("action"),
        type: method.toUpperCase(),
        data:JSON.stringify(data),
        crossDomain: true,
        success: function(data) {
            dataCallbackForm=data;
            if(typeof form.attr('callback') != 'undefined')
                eval(form.attr('callback'));
            else
                beforeSuccess(data);
        },  
        complete:function(){
            form.closest('form').find(':submit').attr('disabled',false);
        },
        error: function(data, status, error) {
            console.log(formID);
            loading.hide();
            data.responseJSON.form=data.responseJSON.form.errors;
            console.log(data.responseJSON.form);
            form.closest('form').find(':submit').attr('disabled',false);
            $.toast({
                heading: 'UPS!',
                text: 'Algo no salió bien.',
                position: 'top-right',
                icon: 'error',
                hideAfter: 3000, 
                stack: 6
            });
            $.each( data.responseJSON.form.children, function( index, item ){
                if(typeof item.children != "undefined"){
                    //console.log("children",item);
                    $.each( item.children, function( index2, children_ ){
                        if(typeof children_.errors != "undefined" && children_.errors.length>0){
                            data.responseJSON.form.children[index+'_'+index2]=children_;
                        }
                    });
                    
                }
            });
            $.each( data.responseJSON.form.children, function( index, item ){ 
                if(typeof item.errors != "undefined" && item.errors.length>0){
                    if($(formID+'#error_'+form.attr("name")+'_'+index).length > 0){
                        if(form.attr("name")!=undefined){
                            $(formID+'#error_'+form.attr("name")+'_'+index).html(item.errors[0]);
                        }else{
                            $(formID+'#error_'+index).html(item.errors[0]);
                        }
                        $(formID+'#error_'+index).html(item.errors[0]);
                    }else{
                        if(form.attr("name")!=undefined){
                            var input=$(formID+'#'+form.attr("name")+'_'+index);
                        }else{
                            var input=form.closest('form').find(':input[name='+index+']');
                        }
                        var input=$(formID+'#'+index);
                        input.addClass('error');
                        input.after('<small class="text-danger">'+item.errors[0]+'</small>');
                    }
                }
                
            });
        }
    });
    return false;
}
$(function (){
    var options = {
        dataType:'json',
        beforeSubmit: showRequest
    };
    $( "form.sendToApi" ).ajaxForm(options);
});