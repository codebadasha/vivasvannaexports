$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Discount coupon Switch Status Change
$(document).on('change', '.discountCouponStatus', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');

    $.ajax({
        url: "/jmarkt-admin/discount/change-discount-coupon-status",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Discount Coupon successfully activated');    
                } else if(option == 0){
                    toastr.success('Discount Coupon successfully deactivated');    
                } else {
                    toastr.error('Something Went Wrong!');
                }
            } else {
                toastr.success('Discount Coupon status successfully changed');
            }
        }
    });
});

// Select coupon type show fields
$(document).on('change', '.couponType', function(){
    var type = $(this).val();

    if(type == 'FIX'){
        $('.discountPercentage').hide();
        $('.discountAmount').show();
    } else if(type == 'DISCOUNT'){
        $('.discountAmount').hide();
        $('.discountPercentage').show();
    }
});

// On/Off switch of all customer show & hide function
$(document).on('change', '.allCustomer', function(){

    if(this.checked){
        $('.customerFilter').hide();
    } else {
        $('.customerFilter').show();
        $('.select2').select2();
    }
});

var userId = [];
// Search & select customer mobile number on keyup function
$(document).on('keyup', '.mobileNumber', function(){
    $.ajax({
        url: "/jmarkt-admin/discount/user-mobile-number-suggestions",
        type: "POST",
        dataType: "JSON",
        success: function(data){
            autocompletedatalist = data;
            $('.mobileNumber').autocomplete({ 
                source: autocompletedatalist,
                focus: function(event, ui) {
                    event.preventDefault();
                    this.value = ui.item.label;
                },
                select: function(event, ui) {
                    event.preventDefault();
                    $('.mobileNumber').val(ui.item.label);
                    $('#user_id').val(ui.item.value);
                    userId.push(ui.item.value);
                    return false;
                },
            });
        }
    });
});

// Search filter - Add user list function
$("#searchUser").click(function(e) {
    e.preventDefault();

    var mobile = $('#search_mobile').val();
    var order = $('#min_order').val();

    $.ajax({
        data:{mobile: mobile, order: order },
        url:"/jmarkt-admin/discount/search-user-mobile",
        method:'post',
    }).done( 
        function(data) {
            $('.userList').empty();
            $('.userList').append('<tr><td><div class="form-check mb-3"><input class="form-check-input" type="checkbox" data-id="1" name="add[]" id="add"></div></td><td>1</td><td>'+data.name+'</td><td>'+data.mobile+'</td><td>5</td></tr>');
        }
    );
    if(sku.length || name.length){
        $( "#resetUser" ).show();
    }
    
});

// Remove error message for select coupon type
$(document).on('change', '#type', function(){
    var value = $('#type').val();
    if(value != ''){
        $('#type-error').text('');
    }
});

// Remove error message for select valid from
$(document).on('change', '#valid_from', function(){
    var value = $('#valid_from').val();
    if(value != ''){
        $('#valid_from-error').text('');
    }
});