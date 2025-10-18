// Role Switch Status Change
$(document).on('change', '.roleStatus', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');

    $.ajax({
        url: "/jmarkt-admin/role/change-role-status",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Role successfully activated');    
                } else if(option == 0){
                    toastr.success('Role successfully deactivated');    
                } else {
                    toastr.error('Something Went Wrong!');    
                }
            } else {
                toastr.success('Role status successfully changed');
            }
        }
    });
});

// Remove error message of lead module
$(document).on('change', '#role_modules', function(){
    $('#addRole').valid();
});