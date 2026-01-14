$(document).ready(function(){
  console.log("script.js: Document ready");
  
  // Wrap in try-catch to prevent theme errors from breaking our code
  try {
    // Check if we're on the new order page
    if ($("#neworder_category").length > 0) {
      console.log("script.js: New order page detected, initializing category handler");
      
      // Bind category change handler
      $("#neworder_category").off('change').on('change', function(){
        console.log("script.js: Category changed to " + $(this).val());
        category_detail();
      });
      
      // Initial load of services (delayed to ensure DOM is ready)
      setTimeout(function() {
        console.log("script.js: Initial category_detail call");
        category_detail();
      }, 100);
    }
  } catch(e) {
    console.log("script.js: Error in initialization", e);
  }

  // Original event bindings (wrapped)
  try {
    category_detail();
  } catch(e) {}
  $("#neworder_category").change(function(){
    category_detail();
  });
  /* Katogeriye ait servisleri ÃƒÂ§ek */
  /* Servise ait verileri ÃƒÂ§ek */
  $("#neworder_services").change(function(){
    service_detail();
  });
  /* Servise ait verileri ÃƒÂ§ek */
  /* SipariÃ…Å¸ miktarÃ„Â± deÃ„Å¸iÃ…Å¸ince fiyat hesapla */
  $(document).on('keyup', '#order_quantity', function() {
    var service   = $("#neworder_services").val();
    var quantity  = $("#neworder_quantity").val();
    var runs      = $("#dripfeed-runs").val();
      if( $("#dripfeedcheckbox").prop('checked') ){
        var dripfeed  = "var";
      }else{
        var dripfeed  = "bos";
      }
    $.post('ajax_data',{action:'service_price',service:service,quantity:quantity,dripfeed:dripfeed,runs:runs}, function(data){
        $("#charge").val(data.price);
        $("#dripfeed-totalquantity").val(data.totalQuantity);
    }, 'json');
  });
  $(document).on('keyup', '#dripfeed-runs', function() {
    var service   = $("#neworder_services").val();
    var quantity  = $("#neworder_quantity").val();
    var runs      = $("#dripfeed-runs").val();
      if( $("#dripfeedcheckbox").prop('checked') ){
        var dripfeed  = "var";
      }else{
        var dripfeed  = "bos";
      }
    $.post('ajax_data',{action:'service_price',service:service,quantity:quantity,dripfeed:dripfeed,runs:runs}, function(data){
        $("#charge").val(data.price);
        $("#dripfeed-totalquantity").val(data.totalQuantity);
    }, 'json');
  });
  $(document).on('keyup', '#neworder_comment', function() {
    comment_charge();
  });
  /* SipariÃ…Å¸ miktarÃ„Â± deÃ„Å¸iÃ…Å¸ince fiyat hesapla */
  /* Dripfeed deÃ„Å¸iÃ…Å¸tir */
  $(document).on('change', '#dripfeedcheckbox', function() {
    var dripfeed = $(this).prop('checked');
    if( dripfeed ){
      $("#dripfeed-options").removeClass();
      dripfeed_charge();
    }else{
      $("#dripfeed-options").addClass('hidden');
      dripfeed_charge();
    }
  });
  /* Dripfeed deÃ„Å¸iÃ…Å¸tir */

$(".currencies-item").click(function(){
var key = $(this).attr("data-rate-key");
var sym = $(this).attr("data-rate-symbol");
$.ajax({
url:'/account/change_currency',
data:'rate_key='+key+'&sym='+sym,
type:'POST',
success:function(resp){
window.location.reload();
}
});
});
});


function funBroadcast() {
    $.ajax({
        url: "/broadcast/",
        type: 'GET',
        success: function(data) {
            data = JSON.parse(data);
            if (data.id != "undefined") {
                var div = document.createElement("div");
                div.innerHTML = data.BROADCAST_DESCRIPTION;
                swal({
                    title: data.BROADCAST_TITLE,
                    content: div,
                    icon: data.BROADCAST_ICON,
                    allowOutsideClick: false,
                    button: 'Ok!',
                    width: '650px'
                }).then((result) => {
                    funBroadcast()
                })
            }
        }
    })
}
$(document).ready(function() {
    funBroadcast();
    $("#randomize_password").click(function(){
var input = $("#childpanel_admin_password");
var  input2 = $("#childpanel_admin_confirm_password");
var pass = password_generator(15);
input.val(pass);
input2.val(pass);
});
});


function category_detail() {
    var category_now = $("#neworder_category").val();
    if (!category_now) {
        console.log("category_detail: No category selected");
        return;
    }
    console.log("category_detail: Fetching services for category " + category_now);
    $.ajax({
        url: 'ajax_data',
        type: 'POST',
        data: {
            action: 'services_list',
            category: category_now
        },
        dataType: 'json',
        success: function(data) {
            console.log("category_detail: Response received", data);
            if (data && data.services) {
                $("#neworder_services").html(data.services);
                $("#neworder_services").trigger("change");
                service_detail();
            } else {
                console.log("category_detail: No services in response");
                $("#neworder_services").html('<option value="0">No services found</option>');
            }
        },
        error: function(xhr, status, error) {
            console.log("category_detail: AJAX error", status, error);
            console.log("category_detail: Response text", xhr.responseText);
        }
    });
}

function service_detail() {
    var service_now = $("#neworder_services").val();
    $.post('ajax_data', {
        action: 'service_detail',
        service: service_now
    }, function(data) {
        if (data.empty == 1) {
            $("#charge_div").hide()
        } else {
            $("#charge_div").show();
            $("#neworder_fields").html(data.details);
            $("#charge").val(data.price)
        }
        $(".datetime").datepicker({
            format: "dd/mm/yyyy",
            language: "tr",
            startDate: new Date(),
        }).on('change', function(ev) {
            $(".datetime").datepicker('hide')
        });
        $("#clearExpiry").click(function() {
            $("#expiryDate").val('')
        });
        var dripfeed = $("#dripfeedcheckbox").prop('checked');
        if (dripfeed) {
            $("#dripfeed-options").removeClass()
        }
        comment_charge();
        if ($("#dripfeedcheckbox").prop('checked')) {
            dripfeed_charge()
        }
        if (data.sub) {
            $("#charge_div").hide()
        } else {
            $("#charge_div").show()
        }
    }, 'json')
}

function comment_charge() {
    var service = $("#neworder_services").val();
    var comments = $("#neworder_comment").val();
    if (comments) {
        $.post('ajax_data', {
            action: 'service_price',
            service: service,
            comments: comments
        }, function(data) {
            $("#neworder_quantity").val(data.commentsCount);
            $("#charge").val(data.price)
        }, 'json')
    }
}

function dripfeed_charge() {
    var service = $("#neworder_services").val();
    var quantity = $("#neworder_quantity").val();
    var runs = $("#dripfeed-runs").val();
    if ($("#dripfeedcheckbox").prop('checked')) {
        var dripfeed = "var"
    } else {
        var dripfeed = "bos"
    }
    $.post('ajax_data', {
        action: 'service_detail',
        service: service,
        quantity: quantity,
        dripfeed: dripfeed,
        runs: runs
    }, function(data) {
        $("#charge").val(data.price)
    }, 'json')
}



function copyToClipboard(text) {

    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
}

function password_generator( len ) {
    var length = (len)?(len):(10);
    var string = "abcdefghijklmnopqrstuvwxyz"; //to upper 
    var numeric = '0123456789';
    var punctuation = '!@#$%^&*()_+|}{[]\:;?><,./-=';
    var password = "";
    var character = "";
    var crunch = true;
    while( password.length<length ) {
        entity1 = Math.ceil(string.length * Math.random()*Math.random());
        entity2 = Math.ceil(numeric.length * Math.random()*Math.random());
        entity3 = Math.ceil(punctuation.length * Math.random()*Math.random());
        hold = string.charAt( entity1 );
        hold = (password.length%2==0)?(hold.toUpperCase()):(hold);
        character += hold;
        character += numeric.charAt( entity2 );
        character += punctuation.charAt( entity3 );
        password = character;
    }
    password=password.split('').sort(function(){return 0.5-Math.random()}).join('');
    return password.substr(0,len);
}

// ============================================================================
// INDEPENDENT INITIALIZATION - Bypasses jQuery ready queue errors
// This runs separately from jQuery's document.ready to avoid theme file errors
// ============================================================================
(function() {
    'use strict';
    
    function initCategoryHandler() {
        console.log("Independent init: Running category handler initialization");
        
        var categorySelect = document.getElementById('neworder_category');
        var serviceSelect = document.getElementById('neworder_services');
        
        if (!categorySelect || !serviceSelect) {
            console.log("Independent init: Not on new order page, skipping");
            return;
        }
        
        console.log("Independent init: Found category and service dropdowns");
        
        // Fetch services for the selected category
        function fetchServicesForCategory(categoryId) {
            console.log("Independent init: Fetching services for category " + categoryId);
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'ajax_data', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    console.log("Independent init: XHR response status " + xhr.status);
                    if (xhr.status === 200) {
                        try {
                            var data = JSON.parse(xhr.responseText);
                            console.log("Independent init: Parsed response", data);
                            if (data && data.services) {
                                serviceSelect.innerHTML = data.services;
                                console.log("Independent init: Updated services dropdown");
                                // Refresh bootstrap-select widget if it exists
                                if (typeof $ !== 'undefined' && $.fn && $.fn.selectpicker) {
                                    try {
                                        $(serviceSelect).selectpicker('refresh');
                                        console.log("Independent init: Refreshed selectpicker");
                                    } catch(e) {
                                        console.log("Independent init: selectpicker refresh failed", e);
                                    }
                                }
                                // Trigger service detail fetch
                                if (typeof service_detail === 'function') {
                                    service_detail();
                                }
                            } else {
                                console.log("Independent init: No services in response");
                                serviceSelect.innerHTML = '<option value="0">No services found</option>';
                                // Refresh bootstrap-select widget
                                if (typeof $ !== 'undefined' && $.fn && $.fn.selectpicker) {
                                    try {
                                        $(serviceSelect).selectpicker('refresh');
                                    } catch(e) {}
                                }
                            }
                        } catch(e) {
                            console.log("Independent init: Parse error", e);
                            console.log("Independent init: Raw response", xhr.responseText.substring(0, 500));
                        }
                    } else {
                        console.log("Independent init: XHR error", xhr.status);
                    }
                }
            };
            xhr.send('action=services_list&category=' + encodeURIComponent(categoryId));
        }
        
        // Bind change event using native JavaScript
        categorySelect.addEventListener('change', function() {
            var selectedCategory = this.value;
            console.log("Independent init: Category changed to " + selectedCategory);
            fetchServicesForCategory(selectedCategory);
        });
        
        console.log("Independent init: Category change handler bound successfully");
    }
    
    // Run after everything has loaded (bypasses jQuery ready queue issues)
    if (document.readyState === 'complete') {
        setTimeout(initCategoryHandler, 100);
    } else {
        window.addEventListener('load', function() {
            setTimeout(initCategoryHandler, 100);
        });
    }
})();
