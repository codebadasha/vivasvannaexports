$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //custom validation method
    $.validator.addMethod("customemail",
        function (value, element) {
            if (value == "") {
                return true;
            } else {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            }

        },
        "Please enter email id along with domain name."
    );

    $(document).on("input", ".numeric", function () {
        this.value = this.value.replace(/\D/g, '');
    });

    $('input.gemstonecarat').keyup(function () {
        match = (/(\d{0,40})[^.]*((?:\.\d{0,5})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
        this.value = match[1] + match[2];
    });

    $('input.width').keyup(function () {

        match = (/(\d{0,40})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
        this.value = match[1] + match[2];
    });

    $.validator.addMethod('validUrl', function (value, element) {
        var url = $.validator.methods.url.bind(this);
        return url(value, element) || url('http://' + value, element) || url('http://www.' + value, element);
    }, 'Please enter a valid URL');

    $.validator.addMethod("customUrl", function (value, element) {
        // Customize the regular expression based on your requirements
        return /^(https?:\/\/)?(www\.)?[a-z\d.-]+\.[a-z]{2,}$/i.test(value);
    }, "Please enter a valid website URL");

    jQuery.validator.addMethod('ckrequired', function (value, element, params) {
        var idname = jQuery(element).attr('id');
        var messageLength = jQuery.trim(CKEDITOR.instances[idname].getData());
        return !params || messageLength.length !== 0;
    }, "Image field is required");

    $.validator.addMethod("greaterThan",
        function (value, element, param) {
            var $otherElement = $(param);
            return parseInt(value, 10) > parseInt($otherElement.val(), 10);
        },
    );

    $.validator.addMethod(
        "regexGst",
        function (value, element, regexp) {
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
        "regexCin",
        function (value, element) {
            // CIN (21 characters: L/U + 5 digits + 2 letters + 4 digits + 3 letters + 6 digits)
            var cinRegex = /^[LU][0-9]{5}[A-Z]{2}[0-9]{4}[A-Z]{3}[0-9]{6}$/;

            // LLPIN (e.g., AAA-1234 or AAA1234)
            var llpRegex = /^[A-Z]{3}-?[0-9]{4}$/;

            return this.optional(element) || cinRegex.test(value) || llpRegex.test(value);
        },
        "Please enter a valid CIN or LLPIN"
    );


    $.validator.addMethod(
        "regexIfsc",
        function (value, element, regexp) {
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
        function (value, element, regexp) {
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
        errorElement: 'div',
        rules: {
            email: {
                required: true,
                customemail: true
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

    $("#clientLoginForm").validate({
        errorElement: 'div',
        rules: {
            username: {
                required: true,
            },
            password: {
                required: true,
                minlength: 8
            },
        },
        messages: {
            username: {
                required: 'Please enter GSTN or CIN',
            },
            password: {
                required: 'Please enter password',
                minlength: 'Password must have at least 8 characters'
            },
        }
    });


    $("#registerForm").validate({
        errorElement: 'div',
        rules: {
            logo: {
                required: true,
            },
            name: {
                required: true,
            },
            email: {
                required: true,
                customemail: true
            },
            gstn: {
                required: true,
                regexGst: true,
                remote: {
                    url: "/client/check-gst",
                    method: "post"
                },
            },
            cin: {
                required: true,
                remote: {
                    url: "/client/check-cin",
                    method: "post"
                },
            },
            password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                minlength: 8,
                equalTo: '#password'
            },
        },
        messages: {
            logo: {
                required: "Please upload company logo",
            },
            name: {
                required: "Please enter company name",
            },
            email: {
                required: "Plese enter email",
            },
            gstn: {
                required: "Please enter GSTN",
                remote: "This GSTN is already exists in our records"
            },
            cin: {
                required: "Please enter CIN",
                remote: "This CIN is already exists in our records"
            },
            password: {
                required: "Please enter password",
                minlength: "Pleae enter 8 charater long password"
            },
            confirm_password: {
                required: "Please enter confirm password",
                minlength: "Please enter 8 charater long password",
                equalTo: "Confirm password is not matched with password"
            },
        }
    });


    $("#forgotPassword").validate({
        errorElement: 'div',
        rules: {
            email: {
                required: true,
                customemail: true
            },
        },
        messages: {
            email: {
                required: 'Please enter email',
            },
        }
    });

    $("#resetPassword").validate({
        errorElement: 'div',
        rules: {
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation: {
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
            password_confirmation: {
                required: "Enter confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Confirm password does not match with new password"
            }
        }
    });

    $("#changePassword").validate({
        errorElement: 'div',
        rules: {
            old_password: {
                required: true,
                minlength: 8
            },
            new_password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                minlength: 8,
                equalTo: "#new_password"
            }

        },
        messages: {
            old_password: {
                required: "Please enter current password",
            },
            new_password: {
                required: "Please enter new password",
                minlength: "Your password must be at least 8 characters long",
            },
            confirm_password: {
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
                customemail: true,
            },
        },
        messages: {
            name: {
                required: 'Please enter name',
            },
            mobile_number: {
                required: 'Please enter mobile number',
                minlength: "Please enter 10 digit mobile number",
                maxlength: "Please enter 10 digit mobile number",
            },
            email: {
                required: 'Please enter email id',
                email: 'Please enter valid email id',
            },
        }
    });

    // Add team member form validation
    $("#addInvestor").validate({
        errorElement: 'span',
        rules: {
            investor_name: {
                required: true,
            },
            mobile_number: {
                required: true,
                minlength: 10,
                maxlength: 10,
                remote: {
                    url: "/admin/investor/check-investor-mobile",
                    method: "post"
                },
            },
            email_id: {
                required: true,
                customemail: true,
                remote: {
                    url: "/admin/investor/check-investor-email",
                    method: "post"
                },
            },
            password: {
                required: true,
                minlength: 8,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
        },
        errorPlacement: function (error, element) {

            if (element.attr("name") === "password" || element.attr("name") === "password_confirmation") {
                // For password fields inside input-group
                error.appendTo(element.closest(".form-group"));

            } else {
                // Default
                error.insertAfter(element);
            }
        },
        messages: {
            investor_name: {
                required: "Investor name is required.",
            },
            mobile_number: {
                required: "Mobile number is required.",
                minlength: "Mobile number must be exactly 10 digits.",
                maxlength: "Mobile number must be exactly 10 digits.",
                remote: "This mobile number is already registered.",
            },
            email_id: {
                required: "Email address is required.",
                remote: "This email address is already registered.",
            },
            password: {
                required: "Password is required.",
                minlength: "Password must be at least 8 characters long.",
                pattern: "Password must contain uppercase, lowercase, number, and special character.",
            },
            password_confirmation: {
                required: "Please confirm your password.",
                equalTo: "Passwords do not match.",
            }
        }

    });

    $("#editInvestor").validate({
        errorElement: 'span',
        rules: {
            investor_name: {
                required: true,
            },
            mobile_number: {
                required: true,
                minlength: 10,
                maxlength: 10,
                remote: {
                    url: "/admin/investor/check-investor-mobile",
                    method: "post",
                    data: {
                        id: function () {
                            return $("input[name='id']").val(); // assuming you have a hidden input with investor id
                        }
                    }
                },
            },
            email_id: {
                required: true,
                customemail: true,
                remote: {
                    url: "/admin/investor/check-investor-email",
                    method: "post",
                    data: {
                        id: function () {
                            return $("input[name='id']").val(); // assuming you have a hidden input with investor id
                        }
                    }
                },
            },
            password: {
                required: false,
                minlength: 8,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
            },
            password_confirmation: {
                required: false,
                minlength: 8,
                equalTo: "#password"
            },
        },
        errorPlacement: function (error, element) {

            if (element.attr("name") === "password" || element.attr("name") === "password_confirmation") {
                // For password fields inside input-group
                error.appendTo(element.closest(".form-group"));

            } else {
                // Default
                error.insertAfter(element);
            }
        },
        messages: {
            investor_name: {
                required: "Investor name is required.",
            },
            mobile_number: {
                required: "Mobile number is required.",
                minlength: "Mobile number must be exactly 10 digits.",
                maxlength: "Mobile number must be exactly 10 digits.",
                remote: "This mobile number is already registered.",
            },
            email_id: {
                required: "Email address is required.",
                remote: "This email address is already registered.",
            },
            password: {
                minlength: "Password must be at least 8 characters long.",
                pattern: "Password must contain uppercase, lowercase, number, and special character.",
            },
            password_confirmation: {
                required: "Please re-enter your password.",
                equalTo: "Passwords do not match. Please try again.",
            }
        }

    });

    // Edit team member form validation
    $("#addTeamMember").validate({
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
                minlength: 10,
                maxlength: 10,
                remote: {
                    url: "/admin/team/check-member-mobile",
                    method: "post"
                },
            },
            email: {
                required: true,
                email: true,
                customemail: true,
                remote: {
                    url: "/admin/team/check-member-email",
                    method: "post"
                },
            },
            password: {
                required: true,
                minlength: 8,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
        },
        errorPlacement: function (error, element) {

            if (element.attr("name") == 'role_id') {
                error.insertAfter('#role');
            } else if (element.attr("name") === "password" || element.attr("name") === "password_confirmation") {
                // For password fields inside input-group
                error.appendTo(element.closest(".form-group"));

            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            full_name: {
                required: "Full name is required.",
            },
            role_id: {
                required: 'Please select role',
            },
            mobile: {
                required: "Mobile number is required.",
                minlength: "Mobile number must be exactly 10 digits.",
                maxlength: "Mobile number must be exactly 10 digits.",
                remote: "This mobile number is already registered.",
            },
            email: {
                required: "Email address is required.",
                email: 'Please enter valid email id',
                remote: "This email address is already registered.",
            },
            password: {
                required: "Password is required.",
                minlength: "Password must be at least 8 characters long.",
                pattern: "Password must contain uppercase, lowercase, number, and special character.",
            },
            confirm_password: {
                required: "Please confirm your password.",
                equalTo: "Passwords do not match.",
            }
        }
    });

    $("#editTeamMember").validate({
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
                    data: { 'id': $("input[name='id']").val() },
                    url: "/admin/team/check-member-mobile",
                    method: "post"
                },
            },
            email: {
                required: true,
                email: true,
                customemail: true,
                remote: {
                    data: { 'id': $("input[name='id']").val() },
                    url: "/admin/team/check-member-email",
                    method: "post"
                },
            },
            password: {
                required: false,
                minlength: 8,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
            },
            password_confirmation: {
                required: false,
                minlength: 8,
                equalTo: "#password"
            },
        },
        errorPlacement: function (error, element) {

            if (element.attr("name") == 'role_id') {
                error.insertAfter('#role');
            } else if (element.attr("name") === "password" || element.attr("name") === "password_confirmation") {
                error.appendTo(element.closest(".form-group"));
            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            full_name: {
                required: "Investor name is required.",
            },
            role_id: {
                required: 'Please select role',
            },
            mobile: {
                required: "Mobile number is required.",
                minlength: "Mobile number must be exactly 10 digits.",
                maxlength: "Mobile number must be exactly 10 digits.",
                remote: "This mobile number is already registered.",
            },
            email: {
                required: "Email address is required.",
                email: 'Please enter valid email id',
                remote: "This email address is already registered.",
            },
            password: {
                minlength: "Password must be at least 8 characters long.",
                pattern: "Password must contain uppercase, lowercase, number, and special character.",
            },
            password_confirmation: {
                required: "Please re-enter your password.",
                equalTo: "Passwords do not match. Please try again.",
            }
        }
    });

    $("#addSupplier").validate({
        errorElement: 'span',
        rules: {
            company_name: {
                required: true,
            },
            address: {
                required: true,
            },
            state_id: {
                required: true,
            },
            mobile_number: {
                required: true,
            },
            email_id: {
                required: true,
                customemail: true
            },
            gstn: {
                required: true,
                regexGst: true
            },
            iec_code: {
                required: true,
            },
            pan_number: {
                required: true,
            },
            gstn_image: {
                required: true,
            },
            iec_code_image: {
                required: true,
            },
            pancard_image: {
                required: true,
            },
        },
        errorPlacement: function (error, element) {

            if (element.attr("name") == 'role_id') {
                error.insertAfter('#role');
            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            company_name: {
                required: "Please enter company name",
            },
            address: {
                required: "Please enter address",
            },
            state_id: {
                required: "Please select state",
            },
            mobile_number: {
                required: "Please enter contact number",
            },
            email_id: {
                required: "Please enter email id",
            },
            gstn: {
                required: "Please enter GSTN",
            },
            iec_code: {
                required: "Please enter IEC code",
            },
            pan_number: {
                required: "Please enter PAN nameber",
            },
            gstn_image: {
                required: "Please upload GSTN certificate",
            },
            iec_code_image: {
                required: "Please upload IEC code certificate",
            },
            pancard_image: {
                required: "Please upload pancard",
            },
        }
    });

    $("#editSupplier").validate({
        errorElement: 'span',
        rules: {
            company_name: {
                required: true,
            },
            address: {
                required: true,
            },
            state_id: {
                required: true,
            },
            mobile_number: {
                required: true,
            },
            email_id: {
                required: true,
                customemail: true
            },
            gstn: {
                required: true,
                regexGst: true
            },
            iec_code: {
                required: true,
            },
            pan_number: {
                required: true,
            },
        },
        errorPlacement: function (error, element) {

            if (element.attr("name") == 'role_id') {
                error.insertAfter('#role');
            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            company_name: {
                required: "Please enter company name",
            },
            address: {
                required: "Please enter address",
            },
            state_id: {
                required: "Please select state",
            },
            mobile_number: {
                required: "Please enter contact number",
            },
            email_id: {
                required: "Please enter email id",
            },
            gstn: {
                required: "Please enter GSTN",
            },
            iec_code: {
                required: "Please enter IEC code",
            },
            pan_number: {
                required: "Please enter PAN nameber",
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
                    data: { 'id': $("#id").val() },
                    url: "/admin/role/check-role-exists",
                    method: "post"
                },
            },
            'modules[]': {
                required: true,
            },
        },
        errorPlacement: function (error, element) {

            if (element.attr("name") == 'modules[]') {
                error.insertAfter('#module');
            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            name: {
                required: "Please enter role name",
                remote: "This role is already exists in our database"
            },
            'modules[]': {
                required: "Please select atleast one module to proceed",
            },
        }
    });

    $("#addClientCompany").validate({
        errorElement: 'span',
        rules: {
            company_name: {
                required: true,
            },
            address: {
                required: true,
            },
            state_id: {
                required: true,
            },
            director_name: {
                required: true,
            },
            mobile_number: {
                required: true,
            },
            email_id: {
                required: true,
                customemail: true
            },
            gstn: {
                required: true,
                regexGst: true,
            },
            cin: {
                required: false,
                regexCin: true
            },
            pan_number: {
                required: true,
            },
            turnover: {
                required: true,
            },
            password: {
                required: function () {
                    return $("#password").length > 0;
                },
                minlength: 8,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
            },
            password_confirmation: {
                required: function () {
                    return $("#password").length > 0;
                },
                equalTo: "#password"
            }
        },
        errorPlacement: function (error, element) {

            if (element.hasClass('select2-hidden-accessible')) {
                // Find the Select2 container dynamically
                const select2Container = element.next('.select2');
                if (select2Container.length) {
                    error.insertAfter(select2Container);
                } else {
                    error.insertAfter(element); // fallback
                }
            } else if (element.attr("name") === "password" || element.attr("name") === "password_confirmation") {
                // For password fields inside input-group
                error.appendTo(element.closest(".form-group"));

            } else {
                // Default
                error.insertAfter(element);
            }
        },
        messages: {
            company_name: {
                required: "Please enter company name",
            },
            address: {
                required: "Please enter address",
            },
            state_id: {
                required: "Please enter state id",
            },
            director_name: {
                required: "Please select director name",
            },
            mobile_number: {
                required: "Please enter contact number",
            },
            email_id: {
                required: "Please enter email",
            },
            gstn: {
                required: "Please enter GSTN",
            },
            cin: {
                required: "Plese enter CIN",
            },
            pan_number: {
                required: "Please enter PAN number",
            },
            turnover: {
                required: "Please Select Company Turnover",
            },
            password: {
                required: "Please enter password",
                minlength: "Password must be at least 8 characters",
                pattern: "Password must contain at least 1 uppercase, 1 lowercase, 1 digit, and 1 special character"
            },
            password_confirmation: {
                required: "Please confirm password",
                equalTo: "Confirm password must match password"
            }
        }
    });

    $("#editClientCompany").validate({
        errorElement: 'span',
        rules: {
            company_name: {
                required: true,
            },
            address: {
                required: true,
            },
            state_id: {
                required: true,
            },
            director_name: {
                required: true,
            },
            mobile_number: {
                required: true,
            },
            email_id: {
                required: true,
                customemail: true
            },
            gstn: {
                required: true,
            },
            cin: {
                required: false,
                regexCin: true
            },
            pan_number: {
                required: true,
            },
            turnover: {
                required: true,
            },
        },
        errorPlacement: function (error, element) {

            if (element.attr("name") == 'role_id') {
                error.insertAfter('#role');
            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            company_name: {
                required: "Please enter company name",
            },
            address: {
                required: "Please enter address",
            },
            state_id: {
                required: "Please enter state id",
            },
            director_name: {
                required: "Please select director name",
            },
            mobile_number: {
                required: "Please enter contact number",
            },
            email_id: {
                required: "Please enter email",
            },
            gstn: {
                required: "Please enter GSTN",
            },
            cin: {
                required: "Plese enter CIN",
            },
            pan_number: {
                required: "Please enter PAN number",
            },
            turnover: {
                required: "Please Select Company Turnover",
            },
        }
    });

    $("#product").validate({
        errorElement: 'span',
        ignore: [],
        rules: {
            product_type: {
                required: true,
                remote: {
                    data: { 'id': $("#id").val() },
                    url: "/admin/product/check-product-type",
                    method: "post"
                },
            },
            gst: {
                required: true,
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == 'variation[' + element.attr('data-id') + '][unit][]') {
                error.insertAfter('#unitError' + element.attr('data-id'));
            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            product_type: {
                required: "Please enter product type",
                remote: "This product type is already exists in our records"
            },
            gst: {
                required: "Please enter GST",
            },
        }
    });

    $('#poItems').validate({
        errorElement: 'span',
        ignore: []
    });


    $("#project").validate({
        errorElement: 'span',
        rules: {
            client_id: {
                required: true,
            },
            name: {
                required: true,
            },
        },
        messages: {
            client_id: {
                required: "Please select client",
            },
            name: {
                required: "Please enter project name",
            },
        }
    });

    $("#boqForm").validate({
        errorElement: 'span',
        ignore: [],
        rules: {
            client_id: {
                required: true,
            },
            name: {
                required: true,
            },
            project_id: {
                required: true,

            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == 'project_id') {
                error.insertAfter('#project');
            } else if (element.attr("name") == 'client_id') {
                error.insertAfter('#client');
            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            client_id: {
                required: "Please select client"
            },
            name: {
                required: "Please enter name",
            },
            project_id: {
                required: "Please select project"
            }
        }
    });

    // $("#creditStatement").validate({
    //     errorElement: 'span',
    //     ignore:[],
    //     rules: {
    //         'item[][statement]': {
    //             required: true,
    //         },
    //     },
    //     messages: {
    //         'item[][statement]': {
    //             required: 'Please upload statement',
    //         },
    //     }
    // });


});
