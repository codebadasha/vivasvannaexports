// Add/Remove Attribute Cards
$('.attributes').on('change',function(){
	var id = $(this).val();
    
    if(id != ''){
        $("#attributes-error").text('');
    }

    $.ajax({
        type: 'post',
        url: '/jmarkt-admin/product-category/remove-attribute-select',
        data: {
            'id': id
        },
        success: function(data) {
            
        }
    });

	if (id != '') {
        $.ajax({
            url:'/jmarkt-admin/product-category/add-attribute',
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

// Remove Attribute Card
$(document).on("click",".remove_attribute_field", function(e){ 
    e.preventDefault(); 
    var button_id = $(this).attr("id");

    $.ajax({
        type: 'post',
        url: '/jmarkt-admin/product-category/remove-attribute-close',
        data: {
            'id': button_id
        },
        success: function(data) {
            
        }
    });

    $('#attribute_'+button_id+'').remove();
    var id = parseFloat(button_id); 
    
    // Remove Attribute from Multi Select
    var wanted_option = $('.attributes_id option[value="'+ button_id +'"]');
	wanted_option.prop('selected', false);
	$('.attributes_id').trigger('change.select2');
});

// Category Switch Status Change
$(document).on('change', '.productCategoryStatus', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');
    $.ajax({
        url: "/jmarkt-admin/product-category/change-product-category-status",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1) {
                    toastr.success('Product category successfully activated');    
                } else if(option == 0) {
                    toastr.success('Product category successfully deactivated');    
                } else {
                    toastr.success('Something Went Wrong!');    
                }
            } else {
                toastr.success('Product category status successfully changed');
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
        url: "/jmarkt-admin/product-category/important-category-status-change",
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

// Same Priority Validation
$(document).on("focusin",".priority",function(){
    var id = $(this).data('id');
    var val = $(this).val();
    
    if(repeat_priority.includes(val)){
        repeat_priority.splice($.inArray(val, repeat_priority), 1);
    }
});

// Same Priority Validation and Save Priority in Session Variable
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
        url: '/jmarkt-admin/product-category/category-session-store',
        data: {
            'priority': add_priority
        },
        success: function(data) {
            
        }
    });
});

// Add/Edit Category Refresh Attribute Cards
$("#refresh_attributes").click(function(e) {
    e.preventDefault(); 
    var id = $('.attributes').val();

    if (id != '') {
        $.ajax({
            url:'/jmarkt-admin/product-category/add-attribute',
            method:'post',              
            data:{
                id:id,
            },
            success:function(data)
            {
                $.ajax({
                    type: 'post',
                    url: '/jmarkt-admin/product-category/category-refresh-store',
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
