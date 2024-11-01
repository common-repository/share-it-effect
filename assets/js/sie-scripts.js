jQuery(function(sieJQ){
    var prod_id; 

    if( sieJQ('#SIE-Badge').length ){
        window.addEventListener("message", (event) => {    
            if( event.origin == "https://dev.shareiteffect.com"  || event.origin == "https://app.shareiteffect.com"){      
                var data = event.data.toString();
                    opt1 = data.split('=');
                
                if( opt1[1] === 'send coupon' ){   
                    sieJQ.ajax({
                        type: "POST",
                        url: sie_ajax.ajax_url,                                                 
                        data: { 
                            action: 'sie_send_coupon',
                            prod_id: prod_id   
                        },                   
                        success: function (response) {   
                            var  res = JSON.parse(response); 
                            createCookie('sie_shared','1',10); 
                            sieJQ("#sie-ifrm").attr('class','d-none');           
                            /* sieJQ('#SIE-Modal').html('<div class="alert alert-success"><span class="sie-btn-close float-right p-3">x</span>To show our appreciation, <br> copy the promo code below and receive<br> your <span class="sie_pop_bold"> ' + res.discount + ' discount</span> today!</p> <div class="sie_pop_code">' + res.ccode + '</div></div>'); */
                            sieJQ('#SIE-Modal').html('<div class="sie-modal text-center" id="template-four-simple" tabindex="-1" role="dialog"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header pb-0 border-bottom-0"><button type="button" class="close sie-popup-close"><span aria-hidden="true">×</span></button></div><div class="modal-body pt-0"><h2 id="popup-line1" class="font-weight-bold pb-2 blink-1 text-primary">Congratulations!</h2><h5 id="popup-line2" class="border-top border-bottom-0 pt-3 pb-2 mb-0 font-weight-light">To show our appreciation, <br>copy the promo code below and receive <br>your <span class="sie_pop_bold"> ' + res.discount + ' discount</span> today!</h5><button id="tool-tip-btn" class="btn btn-sie-success btn-lg" data-tooltip="tooltip" data-placement="top" title="Click to copy" onclick="copyCouponCode()"><span class="tooltiptext" id="sie_ccode_tooltip"></span><div class="sie_pop_code">' + res.ccode + ' </div></button></div><div class="modal-footer bg-light text-dark justify-content-center"><img src="' + sie_ajax.sie_path + '/assets/images/poweredby.svg" width="80" alt="Powered by ShareitEffect" title="Powered by ShareitEffect"></div></div></div><input id="sie_pop_code" type="hidden" value="'+ res.ccode +'"> </div>');
                        },
                        error: function (xhr, status) {
                            console.log(JSON.stringify(xhr))
                            alert(xhr.responseText);
                        }         
                    });
                }else if( opt1[1] === 'close popup' ){                
                    var cancel_count = getCookie('sie_cancel_count')
                    if( cancel_count < 2 ){
                        createCookie('sie_cancel_count',cancel_count+1,10); 
                    }else{
                        createCookie('sie_shared','1',10); 
                        createCookie('sie_cancel_count',0,1); 
                    }
                    sieJQ('#SIE-Modal').hide();
                }
            }
        }, false);

        sieJQ('body').append(
            '<div id="SIE-Modal" class="sie-modal"><iframe id="sie-ifrm" src="https://dev.shareiteffect.com/woocommerce/sharer" height="1000px" width="100%" scrolling="no" style="border: none;"></iframe></div>'
        );

        prod_id = sieJQ('.sie-product-id').val();

        /* sieJQ.ajax({
            type: "POST",
            url: sie_ajax.ajax_url,                                                 
            data: { 
                action: 'sie_get_badge_content',
            },                   
            success: function (response) {    
                var res = JSON.parse(response);
                if( res['count'] < 2){
                    sieJQ(res['field']).append('<div id="SIE-Badge" class="sie-badge"><div class="sie-sharer sie-body"><div class="sie-icon"><img src="' + sie_ajax.sie_path + '/assets/images/logo6.svg" alt="sie-logo" width="23"></div><div class="sie-discount-content">Special Offer ' + res['discount'] + ' Off Today\!</div></div></div>');
                }
            }, 
            error: function (xhr, status) {
                console.log(JSON.stringify(xhr))
                alert(xhr.responseText);
            }         
        }); */

        sieJQ("body").on('click','.sie-sharer',function(){    
            //if( typeof(getCookie('sie_shared')) == "undefined" ){
                if( checkBrowser() ){
                    getPopupContent(prod_id); 
                    return false;
                }   
            //}
        });
    }    

    sieJQ("body").on('click','.sie-popup-close',function(){  
        sieJQ('#SIE-Modal').hide();     
    }); 

    function getPopupContent(prod_id){
        sieJQ.ajax({
            type: "POST",
            url: sie_ajax.ajax_url,                                                 
            data: { 
                action: 'sie_get_popup_content',
                prod_id: prod_id,               
            },                   
            success: function (response) {    
                var res = JSON.parse(response);
                if( res.count < 2 ){
                    sieJQ("#sie-ifrm").removeClass('d-none');                
                    sieJQ('#SIE-Modal').show();
                    var ifrm_popup = document.getElementById('sie-ifrm').contentWindow;
                    ifrm_popup.postMessage(response, 'https://dev.shareiteffect.com/woocommerce/sharer');
                }
            }, 
            error: function (xhr, status) {
                console.log(JSON.stringify(xhr))
                alert(xhr.responseText);
            }         
        });
    }
});

function copyCouponCode() {
    var copyText = document.getElementById("sie_pop_code");
    copyText.type = 'text';
    copyText.select();
    copyText.select();
    document.execCommand("copy");
    copyText.type = 'hidden';
    document.getElementById("sie_ccode_tooltip").textContent = "Copied!";
    setTimeout(function(){
        document.getElementById("sie_ccode_tooltip").textContent = "";
    }, 5000);
}

function createCookie(name,value,hours) {
    if (hours) {
        var date = new Date();
        date.setTime(date.getTime()+(hours*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    } else {
        var expires = "";
    }
    document.cookie = name+"="+value+expires+"; path=/";
}

function checkBrowser(){
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if( /Android/i.test(navigator.userAgent) && isChrome ) {
        return false;
    }
    return true;
}

window.getCookie = function(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) return match[2];
}
