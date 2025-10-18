// On add volume button click show fields
$(document).on('click', ".add_commission_btn", function() {
    $(".add_commission").show("slow");
});

// Save available volume with validation function
$(document).ready(function() {

    $('form').on('submit', function (e){
    
        e.preventDefault();
        var value = $(".available_value").val();
        var unit = $(".select_unit").val();
        var abbreviation = $(".abbreviation").val();
        
        if((value != '') && (unit != '') && (abbreviation != '')){
            e.currentTarget.submit();
            
        } else {

            if(value == ''){

                $(".available_value_error").css("display", "block");
                $(".available_value_error").html("Please enter value");
                $('.available_value_error').fadeIn();
                $('.available_value_error').fadeOut(10000000000000000000000000000);
            }

            if(unit == ''){

                $(".unit_error").css("display", "block");
                $(".unit_error").html("Please select unit");
                $('.unit_error').fadeIn();
                $('.unit_error').fadeOut(10000000000000000000000000000);
            }

            if(abbreviation == ''){

                $(".abbreviation_error").css("display", "block");
                $(".abbreviation_error").html("Please enter abbreviation");
                $('.abbreviation_error').fadeIn();
                $('.abbreviation_error').fadeOut(10000000000000000000000000000);
            }
        }
    
    });
});

// Update volume function with valiation check
$(".update_volume").click(function() {

    var id = $(this).data('id');
    var categoryId = $(this).data('category');

    var value = $('.available_value_'+id).val();
    var unit = $('.available_unit_'+id).val();
    var abbreviation = $('.available_abbreviation_'+id).val();

    if((value != '') && (abbreviation != '') && (unit != '')){

        $.ajax({
            url: "/jmarkt-admin/product-category/update-available-volume",
            method:'POST',
            data:{ 
                id: id,
                categoryId:categoryId,
                value:value,
                unit:unit,
                abbreviation:abbreviation
            },
            success: function(data){
                if(data == 'true'){
                    toastr.success('Product category available volume successfully updated');
                } else {
                    toastr.error('Available volume already exists');
                }
            }
        });

    } else {

        if(value == ''){

            $(".available_value_error_"+id).css("display", "block");
            $(".available_value_error_"+id).html("Please enter value");
            $('.available_value_error_'+id).fadeIn();
            $('.available_value_error_'+id).fadeOut(100000);
        }

        if(unit == ''){
            $(".unit_error_"+id).css("display", "block");
            $(".unit_error_"+id).html("Please enter unit");
            $('.unit_error_'+id).fadeIn();
            $('.unit_error_'+id).fadeOut(100000);
        }

        if(abbreviation == ''){
            $(".abbreviation_error_"+id).css("display", "block");
            $(".abbreviation_error_"+id).html("Please enter abbreviation");
            $('.abbreviation_error_'+id).fadeIn();
            $('.abbreviation_error_'+id).fadeOut(100000);
        }    
    }

});

// Add volume ajax call function
/*$(document).on('click', '.addVolume', function() {

    var categoryId = $('#category_id').val();
    var value = $(".available_value").val();
    var unit = $(".select_unit").val();
    var abbreviation = $(".abbreviation").val();
    
    if((value != '') && (unit != '') && (abbreviation != '')){
        $.ajax({
            url: "/jmarkt-admin/product-category/save-available-volume",
            method:'POST',
            data:{ 
                categoryId:categoryId,
                value:value,
                unit:unit,
                abbreviation:abbreviation
            },
            success: function(data){
                if(data == 'true'){
                    toastr.success('Product category available volume successfully added');
                } else {
                    toastr.error('Available volume already exists');
                }
            }
        });
        
    } else {

        if(value == ''){

            $(".available_value_error").css("display", "block");
            $(".available_value_error").html("Please enter value");
            $('.available_value_error').fadeIn();
            $('.available_value_error').fadeOut(10000000000000000000000000000);
        }

        if(unit == ''){

            $(".unit_error").css("display", "block");
            $(".unit_error").html("Please select unit");
            $('.unit_error').fadeIn();
            $('.unit_error').fadeOut(10000000000000000000000000000);
        }

        if(abbreviation == ''){

            $(".abbreviation_error").css("display", "block");
            $(".abbreviation_error").html("Please enter abbreviation");
            $('.abbreviation_error').fadeIn();
            $('.abbreviation_error').fadeOut(10000000000000000000000000000);
        }
    }
    
});*/