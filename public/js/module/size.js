$('#parent_cat').on('change',function(){
    var val = $(this).val();
    if(val != ''){
        $("#parent_cat-error").text('');
        $.ajax({
            type:"POST",
            data:{ cat_id: val },
            url:"/jmarkt-admin/size/view/get-subcat-list",
            success:function(res){
                if(res == 'false'){
                    $(".subcat").hide();
                    $("#sub_cat").empty();
                    $('.sub_label').hide();
                    $('.sub_selection').next(".select2-container").hide();
                    $('.sub_selection').attr('datareq','no');

                    var id = $('#id').val();
                    $.ajax({
                        type:"POST",
                        data:{ cat_id: val, id: id },
                        url:"/jmarkt-admin/size/view/check-main-category",
                        success:function(res){
                            if(res == 'false'){
                                $('.parent_cat').attr('exist','yes');
                                $('#parent_category_error').text('Sizes are already added for this category');
                            } else {
                                $('.parent_cat').attr('exist','no');
                                $('#parent_category_error').text('');
                            }
                        }
                    });
                }else{
                    $(".subcat").show();
                    $('.sub_label').show();
                    $('.sub_selection').next(".select2-container").show();
                    $('.sub_selection').attr('datareq','yes');
                    $("#sub_cat").empty();
                    $("#sub_cat").append('<option value="">Select Sub Category</option>');
                    $.each(res,function(key,value){
                        $("#sub_cat").append('<option value="'+key+'">'+value+'</option>');
                    });
                    $('.parent_cat').attr('exist','no');
                    $('#parent_category_error').text('');
                }
            }
        });
    }
});

//Add Options from + button
var i = $('#i').val();
if(i == undefined){
    var i = 1;
}

$(document).on('click','.add_option_button',function(e){
    e.preventDefault();
                  
    var html = '<div id="row'+i+'" class="options row" data-id="'+i+'"><div class="col-lg-11 col-11"><div class="form-group mb-3"><input type="text" class="form-control" name="multiple['+i+']" data-msg="Please enter option" placeholder="Enter option" autocomplete="off" required/></div></div><div class="col-lg-1 col-1"><div class="form-group remove'+i+'"><a style="float:right;" href="javascript:void(0);" class="btn btn-danger remove_option_field" id="'+i+'">&#9747</a></div></div></div>';
    $(".card2_add").append(html);
    i++;
});

//Remove option
$(document).on("click",".remove_option_field", function(e){ 
    e.preventDefault(); 
    var button_id = $(this).attr("id");
    $('#row'+button_id+'').remove(); 
    
});

$(document).on("change","#sub_cat",function(){
    var cat = $('.parent_cat').val();
    var subcat = $(this).val();
    var id = $('#id').val();
    if(subcat != ''){
        $('#sub_category_error').text('');
        $.ajax({
            type:"POST",
            data:{ cat_id: cat, id: id, subcat: subcat },
            url:"/jmarkt-admin/size/view/check-main-sub-category",
            success:function(res){
                if(res == 'false'){
                    $('#sub_cat').attr('exist','yes');
                    $('#main_sub_category_error').text('Sizes are already added fo this category and subcategory combination');
                }else{
                    $('#sub_cat').attr('exist','no');
                    $('#main_sub_category_error').text('');
                }
            }
        });
    }
});

$(document).on('submit',"#addSize",function(e) {
    $('#btn_submit').val($(document.activeElement).val());
    e.preventDefault();
    var req = $('.sub_selection').attr('datareq');
    var val = $('.sub_selection').val();
    
    var main_exist = $('.parent_cat').attr('exist');
    var main_sub_exist = $('#sub_cat').attr('exist');

    if(req == 'yes' && val == ''){
        e.preventDefault();
        $('#sub_category_error').text('Please select sub category');
    } else if(main_exist == 'yes'){
        e.preventDefault();
        $('#parent_category_error').text('Sizes are already added for this category');
    } else if(main_sub_exist == 'yes'){
        e.preventDefault();
        $('#main_sub_category_error').text('Sizes are already added fo this category and subcategory combination');
    } else {
         if($('#form_submit').val() == 0){
            $('#form_submit').val(1);
            $('#addSize')[0].submit();
        }
    }
});