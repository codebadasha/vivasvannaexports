$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Append Applicable Attributes value on select product category fuction
$(document).on('change', '.selectProductCategory', function(){
    var category_id = $(this).val();

    $.ajax({
        url: "/jmarkt-admin/product/add-applicable-attributes",
        method:'POST',
        data:{ 
        	category_id: category_id,
        },
        success: function(data){
        	$(".productAttributes").empty();
        	$.each(data,function(key,value){
                $(".productAttributes").append('<option value="'+value.attribute.id+'">'+value.attribute.name+'</option>');
            });
        }
    });
});

// Append Available Volumes value on select product category fuction
$(document).on('change', '.selectProductCategory', function(){
    var category_id = $(this).val();
    var productTitle = $('.productTitle').val();

    $.ajax({
        url: "/jmarkt-admin/product/add-available-volume",
        method:'POST',
        data:{ 
        	category_id: category_id,
        },
        success: function(data){
        	
        	$(".productVolumes").empty();

        	$.each(data,function(key,value){

                $(".productVolumes").append('<div class="form-check mb-3" dir="ltr"><input class="form-check-input productCategoryStatus" type="checkbox" id="customSwitch'+value.id+'" name="available_volume[]" value="'+value.id+'" checked><label class="form-check-label" for="customSwitch'+value.id+'">'+value.value+ '-' +value.unit+ '('+value.abbreviation+')</label></div>');

                $(".checkedVolumeVariationCard").show();
                $(".checkedVolumeVariationCard").append('<div class="row remove_'+value.id+'"><h5>'+productTitle+ ' ' +value.value+ '-' +value.unit+ '('+value.abbreviation+')</h5><div class="col-lg-6"><div class="card"><div class="card-body"><div class="mb-3"><label>Product Promo Image<span class="mandatory">*</span></label><input type="file" class="form-control dropify" id="blog_promo_image" name="variation['+value.id+'][product_variation_promo_image]" placeholder="Product Promo Image" autocomplete="off" data-msg="Please upload product promo image" data-max-file-size="5M" data-allowed-file-extensions="jpeg png jpg" required/></div><div class="mb-3"><label>Other Images</label><div class="fine-uploader-gallery" name="other_iamges" id="fine-uploader-gallery-other-'+value.id+'"></div></div><div class="mb-3"><label>Variation SKU<span class="mandatory">*</span></label><input type="text" class="form-control" id="variation_sku" name="variation['+value.id+'][variation_sku]" placeholder="Variation SKU" data-msg="Please enter variation sku" autocomplete="off" required/></div><div class="mb-3"><label>Base Price<span class="mandatory">*</span></label><input type="text" class="form-control basePrice" id="base_price" name="variation['+value.id+'][base_price]" data-msg="Please enter base price" data-id="'+value.id+'" placeholder="Base Price" autocomplete="off" required/></div></div></div></div><div class="col-lg-6"><div class="card"><div class="card-body"><div class="mb-3 row"><div class="col-lg-6"><label>Want to Apply Discount?</label></div><div class="form-check form-switch form-switch-md mb-3 col-lg-6" dir="ltr"><input class="form-check-input productDiscountSwitch" type="checkbox" id="customSwitch{{ $ck }}" name="variation['+value.id+'][discount]" value="1" data-id="'+value.id+'"><label class="form-check-label" for="customSwitch{{ $ck }}"></label></div></div><div class="productDiscountFields'+value.id+'"></div><div class="mb-3"><label>GST<span class="mandatory">*</span></label><input type="text" class="form-control gstPercentage" id="gst" name="variation['+value.id+'][gst]" placeholder="GST" autocomplete="off" value="'+value.category.gst+'" readonly required/></div><div class="mb-3"><label>MRP<span class="mandatory">*</span></label><input type="text" class="form-control finalMrp'+value.id+'" id="mrp" name="variation['+value.id+'][mrp]" placeholder="MRP" autocomplete="off" readonly/></div><div class="mb-3 row"><div class="col-lg-6"><label>Mark Out of Stock</label></div><div class="form-check form-switch form-switch-md mb-3 col-lg-6" dir="ltr"><input class="form-check-input productOutOfStock" type="checkbox" id="customSwitch{{ $ck }}" name="variation['+value.id+'][stock]" value="1" data-id="'+value.id+'"><label class="form-check-label" for="customSwitch{{ $ck }}"></label></div><div class="mb-3 add_attribute" style="display: none;"></div><div class="mb-3"><label>Ecommerce Portal Title 1</label><input type="url" class="form-control" id="portal_title_1" name="variation['+value.id+'][portal_title_1]" placeholder="Ecommerce Portal Title 1" autocomplete="off" /></div><div class="mb-3"><label>Ecommerce Portal Title 2</label><input type="url" class="form-control" id="portal_title_2" name="variation['+value.id+'][portal_title_2]" placeholder="Ecommerce Portal Title 2" autocomplete="off" /></div></div></div></div></div></div>');

                var id = value.id;

	            var galleryUploader = new qq.FineUploader({
	                element: document.getElementById("fine-uploader-gallery-other-"+id),
	                template: 'qq-template-gallery',
	                request: {
	                    endpoint: "/jmarkt-admin/product/multiple-other-image-uploader",
	                    params: {
	                      	id: value.id,
	                    },
	                },
	                multiple: true,
	                thumbnails: {
	                    placeholders: {
	                        waitingPath: "{{ asset('js/fine-uploader/placeholders/waiting-generic.png') }}",
	                        notAvailablePath: "{{ asset('js/fine-uploader/placeholders/not_available-generic.png') }}"
	                    }
	                },
	                validation: {
	                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png','pdf'],
	                    itemLimit: 10,
	                    sizeLimit: 5217152,
	                },
	                deleteFile: {
	                    enabled: true,
	                    method: "POST",
	                    forceConfirm: true,
	                    endpoint: "{{ route('admin.removeFile') }}",
	                    customHeaders: {
	                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                    }
	                },
	                text: {
	                    uploadButton: 'Click or Drop for upload images',
	                    waitingForResponse: 'Processing...',
	                    retryButton: 'Retry',
	                    cancelButton: 'Cancel',
	                    failUpload: 'Upload failed',
	                    deleteButton: 'Delete',
	                    deletingStatusText: 'Deleting...',
	                    formatProgress: '{percent}% of {total_size}'
	                },
	                debug: true,
	                callbacks: {
	                    onComplete:function(id, fileName, responseJSON){
	                        if (responseJSON.success) {
	                            var li = $('.qq-upload-list li')[id];
	                            $(li).append('<input type="hidden" id="other_product_additional_images_'+responseJSON.key+'" name="variation['+responseJSON.key+'][other_product_images][]" value="'+responseJSON.name+'"></input>');
	                            $('#other_v_product_additional_images_error_'+responseJSON.key).text('');
	                        }
	                    },
	                    onDelete: function(id, responseJSON) {
	                    
	                   },
	                },
	            });
            });
            $('.dropify').dropify();
            
        }
    });
	
	// Discount switch toggle on this feilds append below discount toggle
	$(document).on('change', '.productDiscountSwitch', function(){

    	if(this.checked){
	        option = 1;
	    } else {
	        option = 0;
	    }

    	var id = $(this).data('id');

    	if(option == 1){
    		$(".productDiscountFields"+id).append('<div class="mb-3"><label>Discount %<span class="mandatory">*</span></label><input type="text" class="form-control discountPercentage" id="discount_percentage" name="variation['+id+'][discount_percentage]" data-id="'+id+'" placeholder="Discount %" autocomplete="off" required/></div><div class="mb-3"><label>Valid From<span class="mandatory">*</span></label><input type="text" class="form-control disattr" id="valid_from" name="variation['+id+'][valid_from]" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" autocomplete="off" data-date-format="dd/mm/yyyy" data-date-start-date="0d"></div><div class="mb-3"><label>Valid Till<span class="mandatory">*</span></label><input type="text" class="form-control disattr" id="valid_till" name="variation['+id+'][valid_till]" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" autocomplete="off" data-date-format="dd/mm/yyyy" data-date-start-date="0d"></div>');
    	} else {
    		$(".productDiscountFields"+id).empty();
    	}
    });

});

// Applicable Attributes wise attribute add function
$(document).on('change','.productAttributes',function(){

    var attribute = $(this).val();
    
    $.ajax({
        url: "/jmarkt-admin/product/show-applicable-attribute",
        type: "POST",
        data: {attribute_id:attribute},
        success: function(data){
            $('.add_attribute').html(data);
            $('.add_attribute').show();
            $('.select2').select2();
            $('.dropify').dropify();
        }
    });
});

// Append product cateogry status
$(document).on('click', '.productCategoryStatus', function(){
	var id = $(this).val();

	if(this.checked){
        option = 1;
    } else {
        option = 0;
    }

	
	if(option == 0){
		$('.remove_'+id).remove();
	} else {
		$.ajax({
        	url: "/jmarkt-admin/product/volume-details",
        	method:'POST',
        	data:{ 
        		id: id,
        	},
        	success: function(data){
				var productTitle = $('.productTitle').val();
				console.log(data)
				$(".checkedVolumeVariationCard").append('<div class="row remove_'+id+'"><h5>'+productTitle+ ' ' +data.value+ '-' +data.unit+ '('+data.abbreviation+')</h5><div class="col-lg-6"><div class="card"><div class="card-body"><div class="mb-3"><label>Product Promo Image<span class="mandatory">*</span></label><input type="file" class="form-control dropify" id="blog_promo_image" name="variation['+id+'][product_variation_promo_image]" placeholder="Product Promo Image" autocomplete="off" data-msg="Please upload product promo image" data-max-file-size="5M" data-allowed-file-extensions="jpeg png jpg" required/></div><div class="mb-3"><label>Other Images</label><div class="fine-uploader-gallery" name="other_iamges" id="fine-uploader-gallery-other-'+id+'"></div></div><div class="mb-3"><label>Variation SKU<span class="mandatory">*</span></label><input type="text" class="form-control" id="variation_sku" name="variation['+id+'][variation_sku]" placeholder="Variation SKU" data-msg="Please enter variation sku" autocomplete="off" required/></div><div class="mb-3"><label>Base Price<span class="mandatory">*</span></label><input type="text" class="form-control basePrice" id="base_price" name="variation['+id+'][base_price]" data-msg="Please enter base price" data-id="'+id+'" placeholder="Base Price" autocomplete="off" required/></div></div></div></div><div class="col-lg-6"><div class="card"><div class="card-body"><div class="mb-3 row"><div class="col-lg-6"><label>Want to Apply Discount?</label></div><div class="form-check form-switch form-switch-md mb-3 col-lg-6" dir="ltr"><input class="form-check-input productDiscountSwitch" type="checkbox" id="customSwitch{{ $ck }}" name="variation['+id+'][discount]" value="1" data-id="'+id+'"><label class="form-check-label" for="customSwitch{{ $ck }}"></label></div></div><div class="productDiscountFields'+id+'"></div><div class="mb-3"><label>GST<span class="mandatory">*</span></label><input type="text" class="form-control gstPercentage" id="gst" name="variation['+id+'][gst]" placeholder="GST" autocomplete="off" value="'+data.category.gst+'" readonly required/></div><div class="mb-3"><label>MRP<span class="mandatory">*</span></label><input type="text" class="form-control finalMrp'+id+'" id="mrp" name="variation['+id+'][mrp]" placeholder="MRP" autocomplete="off" readonly/></div><div class="mb-3 row"><div class="col-lg-6"><label>Mark Out of Stock</label></div><div class="form-check form-switch form-switch-md mb-3 col-lg-6" dir="ltr"><input class="form-check-input productOutOfStock" type="checkbox" id="customSwitch{{ $ck }}" name="variation['+id+'][stock]" value="1" data-id="'+id+'"><label class="form-check-label" for="customSwitch{{ $ck }}"></label></div><div class="mb-3 add_attribute" style="display: none;"></div><div class="mb-3"><label>Ecommerce Portal Title 1</label><input type="url" class="form-control" id="portal_title_1" name="variation['+id+'][portal_title_1]" placeholder="Ecommerce Portal Title 1" autocomplete="off" /></div><div class="mb-3"><label>Ecommerce Portal Title 2</label><input type="url" class="form-control" id="portal_title_2" name="variation['+id+'][portal_title_2]" placeholder="Ecommerce Portal Title 2" autocomplete="off" /></div></div></div></div></div></div>');

				
				$('.productAttributes').change();

				$('.dropify').dropify();

				var galleryUploader = new qq.FineUploader({
	                element: document.getElementById("fine-uploader-gallery-other-"+id),
	                template: 'qq-template-gallery',
	                request: {
	                    endpoint: "/jmarkt-admin/product/multiple-other-image-uploader",
	                    params: {
	                      	id: data.id,
	                    },
	                },
	                multiple: true,
	                thumbnails: {
	                    placeholders: {
	                        waitingPath: "{{ asset('js/fine-uploader/placeholders/waiting-generic.png') }}",
	                        notAvailablePath: "{{ asset('js/fine-uploader/placeholders/not_available-generic.png') }}"
	                    }
	                },
	                validation: {
	                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png','pdf'],
	                    itemLimit: 10,
	                    sizeLimit: 5217152,
	                },
	                deleteFile: {
	                    enabled: true,
	                    method: "POST",
	                    forceConfirm: true,
	                    endpoint: "{{ route('admin.removeFile') }}",
	                    customHeaders: {
	                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                    }
	                },
	                text: {
	                    uploadButton: 'Click or Drop for upload images',
	                    waitingForResponse: 'Processing...',
	                    retryButton: 'Retry',
	                    cancelButton: 'Cancel',
	                    failUpload: 'Upload failed',
	                    deleteButton: 'Delete',
	                    deletingStatusText: 'Deleting...',
	                    formatProgress: '{percent}% of {total_size}'
	                },
	                debug: true,
	                callbacks: {
	                    onComplete:function(id, fileName, responseJSON){
	                        if (responseJSON.success) {
	                            var li = $('.qq-upload-list li')[id];
	                            $(li).append('<input type="hidden" id="other_product_additional_images_'+responseJSON.key+'" name="variation['+responseJSON.key+'][other_product_images][]" value="'+responseJSON.name+'"></input>');
	                            $('#other_v_product_additional_images_error_'+responseJSON.key).text('');
	                        }
	                    },
	                    onDelete: function(id, responseJSON) {
	                    
	                   },
	                },
	            });
			}
		});
	}
});

// Calculate final price with include gst
$(document).on('change','.basePrice',function(){
	var price = $(this).val();
	var id = $(this).data('id');
	var gst = $('.gstPercentage').val();
	
	$.ajax({
        url: "/jmarkt-admin/product/calculate-gst-mrp",
        type: "POST",
        data: { id:id, price:price, gst:gst },
        success: function(data){
            $('.finalMrp'+id).val(data);
        }
    });
});

// Calculate final mrp with discount added percentage
$(document).on('change','.discountPercentage',function(){
	var id = $(this).data('id');
	var discount = $(this).val();
	var gst = $('.gstPercentage').val();
	var basePrice = $('.basePrice').val();
	
	$.ajax({
        url: "/jmarkt-admin/product/calculate-mrp-with-discount",
        type: "POST",
        data: { id:id, discount:discount, gst:gst, basePrice:basePrice },
        success: function(data){
            $('.finalMrp'+id).val(data);
        }
    });
});

// Change product status in product listing page
$(document).on('change','.productStatus',function(){
	var status = $(this).val();
	var id = $(this).data('id');

	$.ajax({
        type:"POST",
        data:{ status:status, id:id },
        url:"/jmarkt-admin/product/change-product-status",
        success:function(res){
            if(res == 'true'){
                toastr.success('Poduct status successfully changed to '+status);
            } else {
                toastr.error('Something Went Wrong!');
            }
        }
    });

});

// Remove added basic additional images
$( ".remove_additional_image" ).click(function(e) {
    e.preventDefault();

    var productId = $(this).data('proid');
    var image = $(this).data('image');
    var full_image = $(this).data('fullimg');
    var variation_id = $(this).data('varid');

    $.ajax({
        url:'/jmarkt-admin/product/remove-product-other-image',
        method:'post',              
        data:{ productId:productId, image: image, variation_id: variation_id},
        success:function(data){
            if(data.data == 'true'){
            	$('.already_added_other_'+variation_id).remove();
                toastr.success('Product other image removed successfully');
            } else if(data.data == 'false'){
                toastr.error('Something went wrong!');
            }
        },
    });
});

// Add faq fields in product seofaqlisting page
var x = '<?= $i;?>';
$(document).on('click','.addFaqFields',function(e){
	e.preventDefault();

	$('.faqFields').append('<div id="row'+x+'"><div class="form-group remove'+x+'"><a style="float:right;" href="javascript:void(0);" class="btn btn-danger btn-sm remove_faq_field" id="'+x+'" style="margin-bottom: 5px !important;">&#9747</a><div class="mb-3"><label>Question<span class="mandatory">*</span></label><input type="text" class="form-control" id="question" name="product['+x+'][question]" placeholder="Question" data-msg="Please enter question" autocomplete="off" required/></div><div class="mb-3"><label>Answer<span class="mandatory">*</span></label><input type="text" class="form-control" id="answer" name="product['+x+'][answer]" placeholder="Answer" autocomplete="off" data-msg="Please enter answer" required/></div><div class="mb-3"><label>Priority</label><input type="text" class="form-control numeric" id="priority" name="product['+x+'][priority]" placeholder="Priority" autocomplete="off" /></div></div></div>');
	x++;

});

// Remove faq fields
$(document).on("click",".remove_faq_field", function(e){
    e.preventDefault();
    var button_id = $(this).attr("id");
    $('#row'+button_id+'').remove();
});


