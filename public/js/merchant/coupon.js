$(document).ready(function(){
    $("#productFilterSearch").DataTable({
        "columns": [{ "width": "10%" },null,null],
        paging: false,
        lengthChange: !1,
    });
});

$(document).on('change','#discountType',function(){
    $('.all').addClass('hide').attr('required',false);
    if($(this).val() == 'PERCENTAGE'){
        $('.percentage').removeClass('hide').attr('required',true);
    } else if($(this).val() == 'AED'){
        $('.aed').removeClass('hide').attr('required',true);
    }
});

//category
$(document).on('change','#category',function(){
    var cat_id = $(this).val();
    $.ajax({
        url: "/jmarkt-merchant/coupon/subcategory",
        method:'POST',
        data:{ cat_id : cat_id},
        success: function(data){
            $('#subCategory').find('option').remove();
            $.each(data, function(key, value) {   
                $('#subCategory').append($("<option></option>").attr("value", value.id).text(value.cat_name)); 
            });
        }
    });
})

$(document).on('change','.checkall',function(){
    if(this.checked){
        $('.checkbox').prop('checked',true);
    } else {
        $('.checkbox').prop('checked',false);
    }
})

$(document).on("change",".subcategories",function(){
    var id = $(this).val();
    $('#productFilterSearch').DataTable().clear().destroy();
    $.ajax({
        method:"POST",
        data:{ subcategory_id: id },
        url:"/jmarkt-merchant/coupon/get-product-list",
        success:function(res){
            if(res){
                $.each(res,function(key,value){
                    $('.productSkuList').append('<tr><td><input type="checkbox" class="checkbox" name="product[]" value="'+value.id+'"></td><td>'+value.title+'</td><td>'+value.sku+'</td></tr>');
                });
                $('.productList').show();
                $("#productFilterSearch").DataTable({
                    "columns": [{ "width": "10%" },null,null],
                    paging: false,
                    lengthChange: !1,
                });
            }
        }
    });
})


//Category Switch Status Change
$(document).on('change', '.verificationStatus', function(){
    var id = $(this).data('id');
    $.ajax({
        url: "/jmarkt-merchant/coupon/change-verification-status",
        method:'POST',
        data:{ value: $(this).val(),id:$(this).data('id')},
        success: function(data){
            toastr.success('Verification Status updated');    
        }
    });
});


//Category Switch Status Change
$(document).on('change', '.couponStatus', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');
    $.ajax({
        url: "/jmarkt-merchant/coupon/change-coupon-status",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Coupon successfully activated');    
                }else if(option == 0){
                    toastr.success('Coupon successfully deactivated');    
                }else{
                    toastr.success('Something Went Wrong!');    
                }
            }else{
                toastr.success('Coupon status successfully changed');
            }
        }
    });
});