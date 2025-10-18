$(document).on('change', '.selectDefaultAddress', function(){
    var id = $(this).data('id');
    $.ajax({
        url: "/jmarkt-admin/branch/mark-as-main",
        method:'POST',
        data:{ id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                toastr.success('Default branch successfully changed');    
            } else {
                toastr.error('Something went wrong');
            }
        }
    });
});

$(document).on('change', '.branchStatus', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');

    $.ajax({
        url: "/jmarkt-admin/branch/change-branch-status",
        method:'POST',
        data:{option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Branch successfully activated');    
                } else if(option == 0){
                    toastr.success('Branch successfully deactivated');    
                } else {
                    toastr.error('Something Went Wrong!');    
                }
            } else {
                toastr.success('Branch status successfully changed');
            }
            
        }
    });
});

$(document).on('change', '.promoteTopProducts', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');

    $.ajax({
        url: "/jmarkt-admin/merchant/promote-merchant",
        method:'POST',
        data:{option: option,id:$(this).data('id')},
        success: function(data){
            toastr.success('Merchant successfully changed');    
        }
    });
});

$(document).on('change', '.changeMerchantStatus', function(){
    var id = $(this).data('id');
    var status = $(this).val();

    $.ajax({
        url: "/jmarkt-admin/merchant/change-merchant-status",
        method:'POST',
        data:{status: status,id:id},
        success: function(data){
            if(data == 'true'){
                toastr.success('Merchant\'s status is succssfully updated');    
            } else {
                toastr.success('Something went wrong');
            }
            
        }
    });
});

$(document).on('click', '.addRow', function(){
    if($(this).data('value') == 'ALLOY'){
        $('.addAlloyCommission').removeClass('hide');
    }
    if($(this).data('value') == 'GEMESTONE'){
        $('.addGemestoneCommission').removeClass('hide');   
    }
    if($(this).data('value') == 'JEWELLERY'){
        $('.addJewelleryCommission').removeClass('hide');
    }
});

$(document).on('click', '.removeRow', function(){
    if($(this).data('value') == 'ALLOY'){
        $('.addAlloyCommission').addClass('hide');
    }
    if($(this).data('value') == 'GEMESTONE'){
        $('.addGemestoneCommission').addClass('hide');   
    }
    if($(this).data('value') == 'JEWELLERY'){
        $('.addJewelleryCommission').addClass('hide');
    }
});
