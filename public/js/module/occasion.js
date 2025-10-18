$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Occassion Switch Status Change
$(document).on('change', '.occasionStatus', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');

    $.ajax({
        url: "/jmarkt-admin/occasion/change-occasion-status",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Occassion successfully activated');    
                } else if(option == 0){
                    toastr.success('Occassion successfully deactivated');    
                } else {
                    toastr.success('Something Went Wrong!');    
                }
            } else {
                toastr.success('Occassion status successfully changed');
            }
        }
    });
});

//Add Automatic Slug according to Category Name Inserted
$(document).on("focusout","#name",function(){
    var slug = $(this).val();
    
    if(slug != ''){
        $("#OccasionSlug-error").text('');
        $.ajax({
            type:"POST",
            data:{ slug:slug },
            url:"/jmarkt-admin/occasion/create-occasion-slug",
            success:function(res){
                $('#slug').val(res);
                $('#slug-error').text('');
            }
        });
    } 
});
