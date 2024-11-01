jQuery(function($){
    $('body').on('click','#sie-save-settings',function(){
        var discount_type;
        if($("#sie-discount-type1").prop("checked") == true){
            discount_type = "%";
        }
        else {
            discount_type = "$";
        }
        $.ajax({
            type: "POST",
            url: sie_ajax.ajax_url,                                                 
            data: { 
                action: 'sie_save_settings',
                discount_amt: $('#sie-discount-amt').val(),   
                discount_type: discount_type, 
                hashtag: $('#sie-hashtag').val(), 
                marketing_content: $('#sie-marketing-content').val(),        
                //append_to: $('#sie-append-to').val(), 
                //field_element: $('#sie-field-element').val(),        
            },                   
            success: function (response) {                 
                $('.sie-alert').removeClass('d-none');
                setTimeout(function(){
                    $('.sie-alert').addClass('d-none');
                },5000);
            }, 
            error: function (xhr, status) {
                console.log(JSON.stringify(xhr))
                alert(xhr.responseText);
            }         
        });
    });
    $('body').on('click','.sie-sharer',function(){
        $('.sie-ex-modal').removeClass('d-none');
        $("#SIE-Badge").addClass('d-none');
    });
    
    $('body').on('click','.close-modal',function(){
        $('.sie-ex-modal').addClass('d-none');
        $("#SIE-Badge").removeClass('d-none');
        $('#kuyapanUY').removeClass('show');
    });
});