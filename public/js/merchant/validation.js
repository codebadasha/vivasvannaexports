$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    //custom validation method
    $.validator.addMethod("customemail", 
        function(value, element) {
            if(value == ""){
                return true;
            } else {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);    
            }
            
        }, 
        "Please enter email id along with domain name."
    );

    $(document).on("input", ".numeric", function() {
        this.value = this.value.replace(/\D/g,'');  
    });

    $('input.width').keyup(function() {

        match = (/(\d{0,40})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
        this.value = match[1] + match[2];
    });

    jQuery.validator.addMethod('ckrequired', function (value, element, params) {
        var idname = jQuery(element).attr('id');
        var messageLength =  jQuery.trim ( CKEDITOR.instances[idname].getData() );
        return !params  || messageLength.length !== 0;
    }, "Image field is required");

    $.validator.addMethod("greaterThan", 
        function (value, element, param) {
            var $otherElement = $(param);
            return parseInt(value, 10) > parseInt($otherElement.val(), 10);
        }, 
    );

    $.validator.addMethod(
        "regexGst",
        function(value, element, regexp) {
            var gstinformat = new RegExp('^[0-9]{2}[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}[1-9A-Za-z]{1}Z[0-9A-Za-z]{1}$');
            if (gstinformat.test(value)) {
              return true;
            } else {
                return false;
            }
        },
        "Please add valid GSTIN"
    );

    $.validator.addMethod(
        "regexIfsc",
        function(value, element, regexp) {
            var ifscformat = new RegExp('^[A-Za-z]{4}[0][A-Za-z0-9]{6}$');
            if (ifscformat.test(value)) {
              return true;
            } else {
                return false;
            }
        },
        "Please add valid IFSC code"
    );

    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var passwordformat = new RegExp('^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$');
            if (passwordformat.test(value)) {
              return true;
            } else {
                return false;
            }
        },
        "Please add valid password"
    );

    jQuery.validator.addMethod('COMP_WORD', function (value, element, param) { 
        var string = $('#post_title').val();
        return string.indexOf(value) !== -1 ? true : false;
    }, "Enter the highlighted string which is a part of the Post Title string.");

    $("#loginForm").validate({
        errorElement : 'div',
        rules: {
            email: {
                required: true,
                customemail:true
            },
            password: {
                required: true,
                minlength: 8
            },
        },
        messages: {
            email: {
                required: 'Please enter email',
            },
            password: {
                required: 'Please enter password',
                minlength: 'Password must have at least 8 characters'
            },
        }
    });

    $("#forgotPassword").validate({
        errorElement : 'div',
        rules: {
            email: {
                required: true,
                customemail:true
            },
        },
        messages: {
            email: {
                required: 'Please enter email',
            },
        }
    });

    $("#resetPassword").validate({
        errorElement : 'div',
        rules: {
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation : {
                required: true,
                minlength: 8,
                equalTo: "#password"
            }

        },
        messages: {
            password: {
                required: "Enter new password",
                minlength: "Your password must be at least 8 characters long",
            },
            password_confirmation : {
                required: "Enter confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Confirm password does not match with new password"
            }
        }
    });
    
    $("#changePassword").validate({
        errorElement : 'div',
        rules: {
            old_password: {
                required: true,
                minlength: 8
            },
            new_password: {
                required: true,
                minlength: 8
            },
            confirm_password : {
                required: true,
                minlength: 8,
                equalTo: "#new_password"
            }

        },
        messages: {
            old_password: {
                required: "Please enter current password",
            },
            new_password:{
                required: "Please enter new password",
                minlength: "Your password must be at least 8 characters long",
            },
            confirm_password:{
                required: "Please enter confirm new password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Confirm password does not match with new password"
            }
        }
    });
   
    // Update profile form 
    $("#adminProfile").validate({
        errorElement: 'span',
        rules: {
            name: {
                required: true,
            },
            mobile_number: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            email: {
                required: true,
                email: true,
                customemail : true,
            },
        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            mobile_number: {
                required: 'Please enter mobile number',
                minlength:"Please enter 10 digit mobile number",
                maxlength:"Please enter 10 digit mobile number",
            },
            email: {
                required: 'Please enter email id',
                email: 'Please enter valid email id',
            },
        }
    });
    
    // Add team member form validation
    $("#addStaffMember").validate({
        errorElement: 'span',
        rules: {
            full_name: {
                required: true,
            },
            role_id: {
                required: true,
            },
            mobile: {
                required: true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-merchant/staff-member/check-staff-member-mobile-exists",
                    method: "post"
                },
            },
            email: {
                required: true,
                email: true,
                customemail : true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-merchant/staff-member/check-staff-member-email-exists",
                    method: "post"
                },
            },
            password: {
                required: true,
                minlength: 8
            },
            confirm_password : {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
        },
        errorPlacement: function(error, element) {
            
            if(element.attr("name") == 'role_id'){ 
                error.insertAfter('#role');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            full_name: {
                required: 'Please enter full name',
            },
            role_id: {
                required: 'Please select role',
            },
            mobile: {
                required: 'Please enter mobile number',
                remote:'mobile id already exists'
            },
            email: {
                required: 'Please enter email id',
                email: 'Please enter valid email id',
                remote:'Email id already exists'
            },
            password:{
                required: "Please enter password",
                minlength: "Your password must be at least 8 characters long",
            },
            confirm_password:{
                required: "Please enter confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Confirm password does not match with password"
            },
        }
    });

    // Edit team member form validation
    $("#editStaffmember").validate({
        errorElement: 'span',
        rules: {
            full_name: {
                required: true,
            },
            role_id: {
                required: true,
            },
            mobile: {
                required: true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-merchant/staff-member/check-staff-member-mobile-exists",
                    method: "post"
                },
            },
            email: {
                required: true,
                email: true,
                customemail : true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-merchant/staff-member/check-staff-member-email-exists",
                    method: "post"
                },
            },
            password: {
                minlength: 8
            },
            confirm_password : {
                minlength: 8,
                equalTo: "#password"
            },
        },
        errorPlacement: function(error, element) {
            
            if(element.attr("name") == 'role_id'){ 
                error.insertAfter('#role');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            full_name: {
                required: 'Please enter full name',
            },
            role_id: {
                required: 'Please select role',
            },
            mobile: {
                required: 'Please enter mobile number',
                remote:'Mobile already exists'
            },
            email: {
                required: 'Please enter email id',
                email: 'Please enter valid email id',
                remote:'Email id already exists'
            },
            password:{
                minlength: "Your password must be at least 8 characters long",
            },
            confirm_password:{
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Confirm password does not match with password"
            },
        }
    });

    // Add role form validation
    $("#addRole").validate({
        errorElement: 'span',
        rules: {
            name: {
                required: true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-merchant/role/check-role-exists",
                    method: "post"
                },
            },
            'modules[]': {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            
            if(element.attr("name") == 'modules[]'){ 
                error.insertAfter('#module');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            name: {
                required: validationMsg.name_required,
                remote: validationMsg.role_exists
            },
            'modules[]':{
                required: validationMsg.module_required,
            },
        }
    });

    // Add blog category form validation
    $("#addBlogCategory").validate({
        errorElement: 'span',
        rules: {
            name: {
                required: true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-admin/blog-category/check-blog-category-exists",
                    method: "post"
                },
            },
        },
        messages: {
            name: {
                required: 'Please enter blog category',
                remote:'Blog category already exists',
            },
        },
    });
    
    // Add blog form validation
    $("#addBlog").validate({
        errorElement: 'span',
        ignore:[],
        rules: {
            blog_category: {
                required: true,
            },
            title: {
                required: true,
            },
            blog_promo_image: {
                required: true,
            },
            page_title: {
                required: true,
            },
            details: {
                required: function(mydata) {
                    CKEDITOR.instances[mydata.id].updateElement();
                    var memberdatacontent = mydata.value.replace(/<[^>]*>/gi, '');
                    return memberdatacontent.length === 0;
                }
            },
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == 'blog_category'){ 
                error.insertAfter('#category');
            } else if(element.attr("name") == 'details'){ 
                error.insertAfter('#details_error');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            blog_category: {
                required: 'Please select blog category'
            },
            title: {
                required: 'Please enter blog title'
            },
            blog_promo_image: {
                required: 'Please upload blog promo image'
            },
            page_title: {
                required: 'Please enter page title'
            },
            details: {
                required: 'Please enter blog details'
            },
        }
    });

    // Edit blog form validation
    $("#editBlog").validate({
        errorElement: 'span',
        ignore:[],
        rules: {
            blog_category: {
                required: true,
            },
            title: {
                required: true,
            },
            page_title: {
                required: true,
            },
            details: {
                required: function(mydata) {
                    CKEDITOR.instances[mydata.id].updateElement();
                    var memberdatacontent = mydata.value.replace(/<[^>]*>/gi, '');
                    return memberdatacontent.length === 0;
                }
            },
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == 'blog_category'){ 
                error.insertAfter('#blogCategory');
            } else if(element.attr("name") == 'details'){ 
                error.insertAfter('#details_error');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            blog_category: {
                required: 'Please select blog category'
            },
            title: {
                required: 'Please enter blog title'
            },
            page_title: {
                required: 'Please enter page title'
            },
            details: {
                required: 'Please enter blog details'
            },
        }
    });

    /*CKEDITOR.instances.details.on('key', function(e) {
        var self = this;
        var messageLength = self.getData().replace(/<[^>]*>/gi, '').length;
        if(messageLength > 0) {
            $('#details-error').remove();
        }
    });*/

    // Add & edit aatribute from validation
    $("#addAttribute").validate({
        errorElement: 'div',
        rules: {
            attribute_name: "required",
            attribute_id:
            {
                required: true,
                remote: {
                    data:{'id' : $("#id").val(), 'name': function () { return $('#attribute_name').val(); }},
                    url: "/jmarkt-admin/attribute/check-attribute-exists",
                    type: "post"
                },
            },
            'attribute_type':{
                required: true,
            },
            'is_required':{
                required: true,
            },
            'input_validation':{
                required: true,
            },
        }, 
        errorPlacement: function(error, element) {
            
            if(element.attr("name") == 'attribute_type'){ 
                error.insertAfter('#attribute_type');
            } else if(element.attr("name") == 'input_validation'){ 
                error.insertAfter('#input_validation');
            } else if(element.attr("id") == 'is_required'){ 
                error.insertAfter('#is_required_error');
            } else { 
                error.insertAfter( element );
            }
        }, 
        messages: {
            attribute_name: "Please enter attribute name",
            attribute_id:
            {
                required: "Please enter attribute ID",
                remote: "Combination of attribute name and id is in use",
            },
            'attribute_type':{
                required: 'Please select attribute type',
            },
            'is_required':{
                required: 'Please choose is required',
            },
            'input_validation':{
                required: 'Please select input validation',
            },
        },
    });
    
    // Add ecommerce portal from validation
    $("#addEcommercePortal").validate({
        errorElement: 'div',
        rules: {
            name: {
                required: true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-admin/ecommerce-portal/check-ecommerce-portal-name-exists",
                    method: "post"
                },
            },
            logo: "required",
        },
        messages: {
            name: {
                required: "Please enter ecommerce portal name",
                remote: "Ecommerce portal name already exists",
            },
            logo: "Please upload portal logo"
        },
    });


    // Edit ecommerce portal from validation
    $("#editEcommercePortal").validate({
        errorElement: 'div',
        rules: {
            name: {
                required: true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-admin/ecommerce-portal/check-ecommerce-portal-name-exists",
                    method: "post"
                },
            },
        },
        messages: {
            name: {
                required: "Please enter ecommerce portal name",
                remote: "Ecommerce portal name already exists",
            },
        },
    });
    
    // Add & edit city from validation
    $("#addCity").validate({
        errorElement: 'div',
        rules: {
            name: {
                required: true,
            },
            state: {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == 'state'){ 
                error.insertAfter('#state');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            name: {
                required: "Please enter city",
            },
            state: {
                required: "Please select state",
            }
        },
    });
    
    // Add product category from validation
    $("#addProductCategory").validate({
        errorElement: 'div',
        rules: {
            category: {
                required: true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-admin/product-category/check-product-category-exists",
                    method: "post"
                },
            },
            image: {
                required: true,
            },
            gst: {
                required: true,
            },
            'attributes[]':{
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == 'attributes[]'){ 
                error.insertAfter('#attributes_error');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            category: {
                required: "Please enter product category",
                remote: "Product category already exists",
            },
            image: {
                required: "Please upload category image",
            },
            gst: {
                required: "Please enter applicable GST"
            },
            'attributes[]':{
                required: 'Please select attributes',
            },
        },
    });

    // Edit product category from validation
    $("#editProductCategory").validate({
        errorElement: 'div',
        rules: {
            category: {
                required: true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-admin/product-category/check-product-category-exists",
                    method: "post"
                },
            },
            gst: {
                required: true,
            },
            'attributes[]':{
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == 'attributes[]'){ 
                error.insertAfter('#attributes_error');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            category: {
                required: "Please enter product category",
                remote: "Product category already exists",
            },
            gst: {
                required: "Please enter applicable GST"
            },
            'attributes[]':{
                required: 'Please select attributes',
            },
        },
    });

    // Add product form validation
    $("#addProduct").validate({
        errorElement: 'div',
        rules: {
            title: {
                required: true,
            },
            product_category: {
                required: true,
            },
            product_promo_image:{
                required: true,
            },
            product_status:{
                required: true,
            },
            description:{
                required: true,
            },
            'product_attributes[]':{
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == 'product_category'){ 
                error.insertAfter('#category');
            } else if(element.attr("name") == 'product_status'){ 
                error.insertAfter('#status');
            } else if(element.attr("name") == 'product_attributes[]'){ 
                error.insertAfter('#attributes');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            title: {
                required: "Please enter product title",
            },
            product_category: {
                required: "Please select product category"
            },
            product_promo_image:{
                required: 'Please upload product promo image',
            },
            product_status:{
                required: 'Please select status',
            },
            description:{
                required: 'Please enter product description'
            },
            'product_attributes[]':{
                required: 'Please select applicable attributes'
            },
        },
    });

    // Edit product form validation
    $("#editProduct").validate({
        errorElement: 'div',
        rules: {
            title: {
                required: true,
            },
            product_category: {
                required: true,
            },
            product_status:{
                required: true,
            },
            description:{
                required: true,
            },
            'product_attributes[]':{
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == 'product_category'){ 
                error.insertAfter('#category');
            } else if(element.attr("name") == 'product_status'){ 
                error.insertAfter('#status');
            } else if(element.attr("name") == 'product_attributes[]'){ 
                error.insertAfter('#attributes');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            title: {
                required: "Please enter product title",
            },
            product_category: {
                required: "Please select product category"
            },
            product_status:{
                required: 'Please select status',
            },
            description:{
                required: 'Please enter product description'
            },
            'product_attributes[]':{
                required: 'Please select applicable attributes'
            },
        },
    });
    
    // Add seofaq form validation
    $("#addProductSeoFaq").validate({
        errorElement: 'div',
        rules: {
            tab_title: {
                required: true,
            },
        },
        messages: {
            tab_title: {
                required: "Please enter tab title",
            },
        },
    });

    // Add/Edit discount coupon form validation
    $("#addDiscountCoupon").validate({
        errorElement: 'div',
        rules: {
            type: {
                required: true,
            },
            minimum_cart_value: {
                required: true,
            },
            coupon_code: {
                required: true,
            },
            valid_from: {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == 'type'){ 
                error.insertAfter('#coupon_type');
            } else {
                error.insertAfter( element );
            }
        },
        messages: {
            type: {
                required: "Please select coupon type",
            },
            minimum_cart_value: {
                required: "Please enter minimum cart value",
            },
            coupon_code: {
                required: "Please enter coupon code",
            },
            valid_from: {
                required: "Please select valid from",
            },
        },
    });

    $("#delearForm").validate({
        errorElement: 'div',
        rules: {
            name_of_firm:{
                required : true
            },
            owner_name:{
                required : true
            },
            mobile:{
                required : true
            },
            email:{
                required : true
            },
            address:{
                required : true
            },
            gst_number:{
                required : true,
                minlength: 15,
                regexGst : '^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$'
            },
            fassi_number:{
                required : true,
                maxlength:14,
                minlength:14,
            },
            fssai_valid_till:{
                required : true
            },
            bank_name:{
                required : true
            },
            bank_account_number:{
                required : true
            },
            ifsc:{
                required : true,
                minlength: 11,
                regexIfsc : '^[A-Z]{4}[0][A-Z0-9]{6}$'
            },
        },
        messages: {
            name_of_firm:{
                required : "Please enter name of firm"
            },
            owner_name:{
                required : "Please enter owner name"
            },
            mobile:{
                required : "Please enter mobile number"
            },
            email:{
                required : "Please enter email"
            },
            address:{
                required : "Please enter address"
            },
            gst_number:{
                required : "Please enter GST number"
            },
            fassi_number:{
                required : "Please enter FASSI number"
            },
            fssai_valid_till:{
                required : "Please select FASSI valid date"
            },
            bank_name:{
                required : "Pleae enter bank name"
            },
            bank_account_number:{
                required : "Please enter bank account number"
            },
            ifsc:{
                required : "Please enter IFSC"
            },
        },
    });

    $("#addMerchant").validate({
        errorElement: 'div',
        rules: {
            company_name:{
                required : true
            },
            brand_name:{
                required : true
            },
            brand_logo:{
                required : true
            },
            email:{
                required : true,
                customemail:true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-admin/merchant/check-merchant-email-exists",
                    method: "post"
                },
            },
            password:{
                required : true,
                minlength: 8,
                regex : '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$'
            },
            confirm_password:{
                required : true,
                equalTo: "#password"
            },
            website:{
                required : true,
                url : true
            },
            contact_person_name:{
                required : true
            },
            contact_person_email:{
                required : true
            },
            country_code:{
                required : true
            },
            contact_person_mobile:{
                required : true
            },
            bank_name:{
                required : true
            },
            account_number:{
                required : true
            },
            confirm_account_number:{
                required : true,
                equalTo: "#account_number"
            },
            iban:{
                required : true
            },
            swift_code:{
                required : true
            },
            memorandum:{
                required : true
            },
            license:{
                required : true
            },
            idproof:{
                required : true
            },
        },
        messages: {
            company_name:{
                required : "Please enter company name"
            },
            brand_name:{
                required : "Please enter brand name"
            },
            brand_logo:{
                required : "Please select brand logo"
            },
            email:{
                required : "Please enter official email",
                remote:'Email already exists'
            },
            password:{
                required : "Please enter password"
            },
            confirm_password:{
                required : "Please enter confirm password",
                equalTo: "Confirm password does not match with new password"
            },
            website:{
                required : "Please enter website"
            },
            contact_person_name:{
                required : "Please enter contact person name"
            },
            contact_person_email:{
                required : "Please enter contact person email"
            },
            contact_person_mobile:{
                required : "Please enter contact person mobile"
            },
            bank_name:{
                required : "Please enter bank name"
            },
            account_number:{
                required : "Please enter account number"
            },
            confirm_account_number:{
                required : "Please enter confirm account number",
                equalTo: "Confirm account number does not match with account number"
            },
            iban:{
                required : "Please enter IBAN"
            },
            swift_code:{
                required : "Please enter swift code"
            },
            memorandum:{
                required : "Please upload memorandum of association or CR"
            },
            license:{
                required : "Please upload license for retail gold trade practice"
            },
            idproof:{
                required : "Please upload valid id proof of company director or focal person"
            },
        },
    });

    $("#editMerchant").validate({
        errorElement: 'div',
        rules: {
            company_name:{
                required : true
            },
            brand_name:{
                required : true
            },
            email:{
                required : true,
                customemail:true,
                remote: {
                    data:{'id' : $("#id").val()},
                    url: "/jmarkt-admin/merchant/check-merchant-email-exists",
                    method: "post"
                },
            },
            confirm_password:{
                equalTo: "#password"
            },
            password:{
                minlength: 8,
            },
            website:{
                required : true,
                url : true
            },
            contact_person_name:{
                required : true
            },
            contact_person_email:{
                required : true
            },
            country_code:{
                required : true
            },
            contact_person_mobile:{
                required : true
            },
            bank_name:{
                required : true
            },
            account_number:{
                required : true
            },
            confirm_account_number:{
                required:true,
                equalTo: "#account_number"
            },
            iban:{
                required : true
            },
            swift_code:{
                required : true
            },
        },
        messages: {
            company_name:{
                required : "Please enter company name"
            },
            brand_name:{
                required : "Please enter brand name"
            },
            email:{
                required : "Please enter official email",
                remote:'Email already exists'
            },
            confirm_password:{
                equalTo: "Confirm password does not match with new password"
            },
            website:{
                required : "Please enter website"
            },
            contact_person_name:{
                required : "Please enter contact person name"
            },
            contact_person_email:{
                required : "Please enter contact person email"
            },
            contact_person_mobile:{
                required : "Please enter contact person mobile"
            },
            bank_name:{
                required : "Please enter bank name"
            },
            account_number:{
                required : "Please enter account number"
            },
            confirm_account_number:{
                required : "Please enter confirm account number",
                equalTo: "Confirm account number does not match with account number"
            },
            iban:{
                required : "Please enter IBAN"
            },
            swift_code:{
                required : "Please enter swift code"
            },
        },
    });

    $("#addMerchantBranch").validate({
        errorElement: 'div',
        rules: {
            branch_name:{
                required : true
            },
            branch_contact_person:{
                required : true
            },
            contact_person_mobile:{
                required : true
            },
            contact_person_email:{
                required : true
            },
            branch_phone_number:{
                required : true
            },
            address:{
                required : true
            },
            city:{
                required : true
            },
            state:{
                required : true
            },
            emirate:{
                required : true
            },
            zipcode:{
                required : true
            },
            rental_contract:{
                required : true
            },
        },
        messages: {
            branch_name:{
                required : "Please enter branch name"
            },
            branch_contact_person:{
                required : "Please enter branch contact person"
            },
            contact_person_mobile:{
                required : "Please enter contact person mobile"
            },
            contact_person_email:{
                required : "Please enter contact person email"
            },
            branch_phone_number:{
                required : "Please enter branch phone number"
            },
            address:{
                required : "Please enter address"
            },
            city:{
                required : "Please enter city"
            },
            state:{
                required : "Please select state"
            },
            emirate:{
                required : "Please select emirate"
            },
            zipcode:{
                required : "Please enter zipcode"
            },
            rental_contract:{
                required : "Please upload rental contract"
            },
        },
    });

    $("#editMerchantBranch").validate({
        errorElement: 'div',
        rules: {
            branch_name:{
                required : true
            },
            branch_contact_person:{
                required : true
            },
            contact_person_mobile:{
                required : true
            },
            contact_person_email:{
                required : true
            },
            branch_phone_number:{
                required : true
            },
            address:{
                required : true
            },
            city:{
                required : true
            },
            state:{
                required : true
            },
            emirate:{
                required : true
            },
            zipcode:{
                required : true
            },
        },
        messages: {
            branch_name:{
                required : "Please enter branch name"
            },
            branch_contact_person:{
                required : "Please enter branch contact person"
            },
            contact_person_mobile:{
                required : "Please enter contact person mobile"
            },
            contact_person_email:{
                required : "Please enter contact person email"
            },
            branch_phone_number:{
                required : "Please enter branch phone number"
            },
            address:{
                required : "Please enter address"
            },
            city:{
                required : "Please enter city"
            },
            state:{
                required : "Please select state"
            },
            emirate:{
                required : "Please select emirate"
            },
            zipcode:{
                required : "Please enter zipcode"
            },
        },
    });
});