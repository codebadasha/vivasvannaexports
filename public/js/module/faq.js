$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Remove error message on typing
$(document).on('keyup', '.cke_inner', function(){
    $('#answer-error').text('');
    $('#answer_error').text('');
});

// Answer validation - Add/Edit FAQ
$(document).on('submit', '#addFaq', function(e){
    e.preventDefault();
    var val = $('#answer').val();
    
    if(val == '<p><br></p>'){
        e.preventDefault();
        $('#answer_error').text('Please enter answer');
    } else {
        $('#answer-error').text('');
        $('#addFaq')[0].submit();
    }
});

// FAQ Switch Status Change
$(document).on('change', '.faqStatus', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');

    $.ajax({
        url: "/jmarkt-admin/faq/change-faq-status",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1){
                    toastr.success('FAQ successfully activated');    
                }else if(option == 0){
                    toastr.success('FAQ successfully deactivated');    
                }else{
                    toastr.success('Something Went Wrong!');    
                }
            }else{
                toastr.success('FAQ status successfully changed');
            }
        }
    });
});

// Remove error message from faq select type
$(document).on('change', '.select_type', function(){
    var value = $('.select_type').val();
    if(value != ''){
        $('#type-error').text('');
    }
});

$(document).on('click','.form_btn',function(e){
    e.preventDefault();
    if($('#addFaq').valid()){
        var btnValue = $(this).val();
        if($('#btn_value').val() == ''){
            $('#btn_value').val(btnValue);
            $('#addFaq')[0].submit();
            return false;
        }
    }
})
