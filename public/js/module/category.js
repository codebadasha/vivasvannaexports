//Show or Hide Parent Category Multi-Select - Add Category
$('.select_cat').on('change',function(){
	var type = $(this).val();
    if(type != ''){
        $('#cate_type-error').text('');
    }
	if(type == 'subcategory'){
        $('.parent_label').show();
        $('.parent_selection').val(null).trigger('change');
        $('.parent_selection').next(".select2-container").show();
        $('.parent_selection').attr('datareq','yes');
        $('.parent_selection').attr('required',true);

        //Create slug
        var cat = $("#cat_name").val();
        var parent_cat = $('.parent_selection').val();
        if(cat != '' && parent_cat != ''){
            $.ajax({
                type: 'post',
                url: '/jmarkt-admin/category/view/create-slug',
                data: {
                    'cat': cat,
                    'parent_cat': parent_cat,
                },
                success: function(data) {
                    $('#cat_slug').val(data);
                    $('#cat_slug-error').text('');
                }
            });
        }

	} else {
        $('.parent_label').hide();
        $('.parent_selection').val(null).trigger('change');
        $('.parent_selection').next(".select2-container").hide();
        $('.parent_selection').attr('datareq','no');
        $('.parent_selection').attr('required',false);
        $('#parent_category_error').text('');
        $('#parent_cat-error').text('');

        //Create slug
        var cat = $("#cat_name").val();
        var parent_cat = '';
        if(cat != ''){
            $.ajax({
                type: 'post',
                url: '/jmarkt-admin/category/view/create-slug',
                data: {
                    'cat': cat,
                    'parent_cat': parent_cat,
                },
                success: function(data) {
                    $('#cat_slug').val(data);
                    $('#cat_slug-error').text('');
                }
            });
        }
	}
});

//Show or Hide Parent Category Multi-Select - Edit Category
$(document).ready(function() {
	var type = $('.select_cat').val();
	if(type == 'subcategory'){
        $('.parent_label').show();
        $('.parent_selection').next(".select2-container").show();
        $('.parent_selection').attr('datareq','yes');
        $('.parent_selection').attr('required',true);
	}else{
        $('.parent_label').hide();
        $('.parent_selection').val(null).trigger('change');
        $('.parent_selection').next(".select2-container").hide();
        $('.parent_selection').attr('datareq','no');
        $('.parent_selection').attr('required',false);
	}
    //$('#datatable-buttons_filter').hide();
});

//Create slug on Parent Category selection
$(document).on('change', '.parent_selection', function(){
    var cat = $("#cat_name").val();
    var parent_cat = $(this).val();
    if(parent_cat != ''){
        $('#parent_category_error').text('');
        $('#parent_cat-error').text('');
    }
    if(cat != '' && parent_cat != ''){
        $.ajax({
            type: 'post',
            url: '/jmarkt-admin/category/view/create-slug',
            data: {
                'cat': cat,
                'parent_cat': parent_cat,
            },
            success: function(data) {
                $('#cat_slug').val(data.slug);
                $('.mainSlug').text(data.mainSlug);
                $('#cat_slug-error').text('');
            }
        });
    }
});

//Add Automatic Slug according to Category Name Inserted
$("#cat_name").keyup(function(){
	var cat = $(this).val();
    var parent_cat = $('#parent_cat').val();
    
    $.ajax({
        type: 'post',
        url: '/jmarkt-admin/category/view/create-slug',
        data: {
            'cat': cat,
            'parent_cat': parent_cat,
        },
        success: function(data) {
            $('#cat_slug').val(data.slug);
            $('.mainSlug').text(data.mainSlug);
            $('#cat_slug-error').text('');
        }
    });
});

//Add/Remove Attribute Cards
$('.attributes').on('change',function(){
	var id = $(this).val();
    
    if(id != ''){
        $("#attributes-error").text('');
    }

    $.ajax({
        type: 'post',
        url: '/jmarkt-admin/category/view/remove-attribute-select',
        data: {
            'id': id
        },
        success: function(data) {
            
        }
    });

	if (id != '') {
        $.ajax({
            url:'/jmarkt-admin/category/view/add-attribute',
            method:'post',              
            data:{
                id:id,
            },
            success:function(data)
            {
                $('.add_attribute').empty();
                $('.add_attribute').append(data.html);
                $('.add_attribute').show();
            },
        });
    } else if(id == '') {
        $('.add_attribute').empty();
        $('.add_attribute').css('display','none');
    }
});

//Remove Attribute Card
$(document).on("click",".remove_attribute_field", function(e){ 
    e.preventDefault(); 
    var button_id = $(this).attr("id");

    $.ajax({
        type: 'post',
        url: '/jmarkt-admin/category/view/remove-attribute-close',
        data: {
            'id': button_id
        },
        success: function(data) {
            
        }
    });

    $('#attribute_'+button_id+'').remove();
    var id = parseFloat(button_id); 
    
    //Remove Attribute from Multi Select
    var wanted_option = $('.attributes_id option[value="'+ button_id +'"]');
	wanted_option.prop('selected', false);
	$('.attributes_id').trigger('change.select2');
});

//Crop Image
$(document).on('click','#cropImageBtn',function(){
    var image = $('.item-img').val();
    if(image !== undefined && image != ''){
        $('#my_file-error').text('');
    }
});

//Category Switch Status Change
$(document).on('change', '.categoryStatus', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');
    $.ajax({
        url: "/jmarkt-admin/category/view/category-status-change",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Category successfully activated');    
                }else if(option == 0){
                    toastr.success('Category successfully deactivated');    
                }else{
                    toastr.success('Something Went Wrong!');    
                }
            }else{
                toastr.success('Category status successfully changed');
            }
        }
    });
});


// Important Category Switch Status Change
$(document).on('change', '.importantCategory', function(){
    
    var element = $(this);

    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    
    var id = element.data('id');
    $.ajax({
        url: "/jmarkt-admin/category/view/important-category-status-change",
        method:'POST',
        data:{ option: option,id:element.data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1) {
                    toastr.success('Important category successfully activated');    
                } else if(option == 0) {
                    toastr.success('Important category successfully deactivated');    
                } else {
                    toastr.success('Something Went Wrong!');    
                }
            } else {
                element.prop('checked',false);
                toastr.error('You can mark maximum 5 main categories as important'); 
            }
        }
    });
});

var add_priority = {};
var repeat_priority = [];

//Save Attribute-Priority - Edit Category
// $(document).ready(function() {

//     $(".priority").each(function(){
//         var id = $(this).data('id');
//         var val = $(this).val();
//         add_priority[id] = val;
//         repeat_priority[id] = val;
//     });
//     $.ajax({
//         type: 'post',
//         url: '/jmarkt-admin/category/view/category-session-store',
//         data: {
//             'priority': add_priority
//         },
//         success: function(data) {
            
//         }
//     });
// });

//Same Priority Validation
$(document).on("focusin",".priority",function(){
    var id = $(this).data('id');
    var val = $(this).val();
    
    if(repeat_priority.includes(val)){
        repeat_priority.splice($.inArray(val, repeat_priority), 1);
    }
});

//Same Priority Validation and Save Priority in Session Variable
$(document).on("keyup",".priority",function(){
    var id = $(this).data('id');
    var val = $(this).val();
    add_priority[id] = val;
    
    if(repeat_priority.includes(val)){
        $(this).val('');
        toastr.error('Please enter a different priority!');
    }else{
        repeat_priority[id] = val;
    }

    $.ajax({
        type: 'post',
        url: '/jmarkt-admin/category/view/category-session-store',
        data: {
            'priority': add_priority
        },
        success: function(data) {
            
        }
    });
});

//Add/Edit Category Refresh Attribute Cards
$("#refresh_attributes").click(function(e) {
    e.preventDefault(); 
    var id = $('.attributes').val();

    if (id != '') {
        $.ajax({
            url:'/jmarkt-admin/category/view/add-attribute',
            method:'post',              
            data:{
                id:id,
            },
            success:function(data)
            {
                $.ajax({
                    type: 'post',
                    url: '/jmarkt-admin/category/view/category-refresh-store',
                    data: {
                        'refresh': 'yes'
                    },
                    success: function(data) {
                        
                    }
                });
                
                $('.attributes').empty();
                $.each(data.all_attributes,function(key,value){
                    $(".attributes").append('<option data-id="'+value.id+'" value="'+value.id+'">'+value.name+'('+value.att_id+')</option>');
                });
                $(".attributes").val(null).trigger("change");
                $('.attributes').val(id);
                $('.attributes').trigger('change');

                $('.add_attribute').empty();
                $('.add_attribute').append(data.html);
                $('.add_attribute').show();
                $('.select2').select2();
            },
        });
    } else if(id == '') {
        $('.add_attribute').empty();
        $('.add_attribute').css('display','none');
    }
});

//File Size Validation
$(document).ready(function () {
    $('.dropify').dropify();
    $("[data-max-file-size]").dropify({
        error: {
            'fileSize': 'The file size is too big ({{ value }}B max).'
        }
    });
});

$('#select_parent').on('change',function(){
    var val = $(this).val();

    if(val != ''){
        $("#select_parent-error").text('');
        $('#select_sub').prop( "disabled", false );
        $.ajax({
            type:"POST",
            data:{ cat_id: val },
            url:"/jmarkt-admin/category/view/get-subcat-list",
            success:function(res){               
                if(res){
                    $("#select_sub").empty();
                    $("#select_sub").append('<option value="">Select Sub Category</option>');
                    $.each(res,function(key,value){
                        $("#select_sub").append('<option value="'+key+'">'+value+'</option>');
                    });
               
                }else{
                   $("#select_sub").empty();
                }
            }
        });
    }
});

//Category List Filters
$(document).on("change","#list_select_parent",function(){
    var id = $(this).val();
    
    $.ajax({
        type:"POST",
        data:{ id: id },
        url:"/jmarkt-admin/category/view/category-get-sub-category",
        success:function(res){
            $("#list_select_sub").empty();
            $("#list_select_sub").append('<option value="">Select Sub Category</option>');
            $.each(res,function(key,value){
                $("#list_select_sub").append('<option value="'+value.id+'">'+value.cat_name+'</option>');
            });
        }
    });
});

$(document).on('click','.addSizeGuide',function(){
    var id = $(this).data('id');
    $.ajax({
        type:"POST",
        data:{ id: id },
        url:"/jmarkt-admin/category/add-size-guide",
        success:function(data){
            $('#modalBody').html(data);
            $('#sizeGuideModal').modal('show');
            $('.dropify').dropify();
        }
    }); 
})