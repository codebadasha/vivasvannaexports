$(document).on('click','.password',function(){
    if($('#password').attr('type') == 'text'){
        $('#password').attr('type','password');
        $(this).removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        $('#password').attr('type','text');
        $(this).removeClass('fa-eye-slash').addClass('fa-eye');
    }
})

$(document).on('click','.confirmpassword',function(){
    if($('#confirmPassword').attr('type') == 'text'){
        $('#confirmPassword').attr('type','password');
        $(this).removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        $('#confirmPassword').attr('type','text');
        $(this).removeClass('fa-eye-slash').addClass('fa-eye');
    }
})