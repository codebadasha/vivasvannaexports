// Customer Switch Status Change
$(document).on('change', '.customerStatus', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');

    $.ajax({
        url: "/jmarkt-admin/customers/change-customer-status",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Customer successfully activated');    
                } else if(option == 0){
                    toastr.success('Customer successfully deactivated');    
                } else {
                    toastr.error('Something Went Wrong!');    
                }
            } else {
                toastr.success('Customer status successfully changed');
            }
        }
    });
});

// Customer Switch Status Change
$(document).on('change', '.kycStatus', function(){
    var id = $(this).data('id');
    var status = $(this).val();

    $.ajax({
        url: "/jmarkt-admin/customers/change-kyc-status",
        method:'POST',
        data:{ kyc: status,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                toastr.success('KYC status successfully changed');    
            } else {
                toastr.error('Something went wrong');
            }
        }
    });
});


// Default address function
$(document).on('click', '.defaultAddress', function(){
    var element = $(this);
    var addressId = element.data('id');
    var userId = element.data('user');

    $.ajax({
        url:'/jmarkt-admin/customers/default-address',
        method:'post',
        data: { addressId:addressId, userId:userId },
        success: function(data){
            if(data == 'true'){
                toastr.success('Default address successfully changed');
            } else {
                toastr.error('Something Went Wrong!');    
            }
        }
    });

});