// -------------------------
// GST Validation Function
// -------------------------
async function checkGst(gst) {
    const $gstInput = $('#gstn');
    const $loader = $('#gst-loader');

    // Client-side GSTIN validation (15 chars format)
    const gstinRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z0-9]{1}Z[A-Z0-9]{1}$/;
    if (!gstinRegex.test(gst)) {
        toastr.error('Invalid GSTIN format. Please enter a valid 15-character GSTIN.');
        return;
    }

    // Disable input and show loader
    $gstInput.prop('readonly', true);
    $loader.show();

    try {
        const response = await $.ajax({
            url: window.checkGstURL,
            method: 'GET',
            data: { gstin: gst },
            timeout: 0,
            dataType: 'json'
        });

        if (!response.status) {
            toastr.error(response.message || 'GST validation failed.');
            return;
        }

        const data = response.data || {};

        // Auto-fill form fields safely
        $("#panNumber").val(data.pan_number || '');
        if (data.cin) {
            $("#cin").val(data.cin);
        }
        $("#companyName").val(data.company_name || '');
        let mobile = data.mobile_number || '';
        if (mobile.length === 10) {
            mobile = mobile.substring(0, 2) + "XXXXX" + mobile.substring(7);
        }
        $("#showMobileNumber").val(mobile);
        $("#mobileNumber").val(data.mobile_number || '');
        $("#email").val(data.email || '');
        $("#msme_register").val(data.msme_register);
        $("textarea[name='address']").val(data.address || '');

        // Directors dropdown population
        const directorsList = Array.isArray(data.director_name) ? data.director_name : [];
        populateDirectorDropdown(directorsList);

        // Store directors list in hidden input for Laravel old()
        $("input[type='hidden'][name='directorsList']").val(JSON.stringify(directorsList));

        // Set state dropdown
        setSelectedState(data.state_id);
        $('#company-details').show();
        $("select[name='state_id']").select2();
        $("select[name='turnover']").select2();
        toastr.success(response.message || 'GST validated successfully.');
    } catch (error) {
        toastr.error(error.responseJSON?.message || 'Something went wrong during GST validation.');
    } finally {
        $gstInput.prop('readonly', false);
        $loader.hide();
    }
}

// -------------------------
// GST Input Auto Validation
// -------------------------
$(document).on('input', '#gstn', function () {
    $('#company-details').hide();
    const gst = $(this).val().trim().toUpperCase();
    $(this).val(gst);

    if (gst.length === 15) {
        checkGst(gst);
    } else if (gst.length < 15) {
        resetAuthorizedAndContact();
    }
});

function resetAuthorizedAndContact() {
    // Reset Authorized Person
    const $authWrapper = $(".authorizedPerson");
    $authWrapper.find(".authorized").not(":first").remove(); // remove extra rows
    $authWrapper.find(".authorized:first input").each(function () {
        $(this).val("").prop("readonly", false);
    });

    // Reset Contact Person
    const $contactWrapper = $(".contactPerson");
    $contactWrapper.find(".contactperson").not(":first").remove(); // remove extra rows
    $contactWrapper.find(".contactperson:first input").each(function () {
        $(this).val("");
    });
}

/**
 * Populate Director Dropdown
 * @param {Array|string} list - Array of directors or single string
 * @param {string} selected - Value to preselect
 */
function populateDirectorDropdown(list, selected = '') {
    const $directorSelect = $("select[name='director_name']");
    $directorSelect.empty().append('<option value="">Select Director</option>');

    if (Array.isArray(list)) {
        list.forEach(director => {
            const name = director.trim();
            if (name) $directorSelect.append(new Option(name, name));
        });
    } else if (typeof list === 'string' && list.trim()) {
        $directorSelect.append(new Option(list.trim(), list.trim()));
    }

    if (selected) {
        $directorSelect.val(selected).trigger('change');
    }
}

/**
 * Handle "Same as Director" checkbox toggle
 * Prefills first authorized person with director details if checked
 */
function toggleSameAsDirector() {
    const selectedDirector = $('#directorName').val();
    const $authName = $("input[name='authorized[0][name]']");
    const $authEmail = $("input[name='authorized[0][email]']");
    const $authMobile = $("input[name='authorized[0][mobile]']");

    if ($('#sameAsDirector').is(':checked')) {
        if (!selectedDirector) {
            toastr.warning("Please select a Director Name first.");
            $('#sameAsDirector').prop('checked', false);
            return;
        }

        $authName.val(selectedDirector).prop('readonly', true);
        $authEmail.val($('#email').val()).prop('readonly', true);
        $authMobile.val($('#mobileNumber').val()).prop('readonly', true);

    } else {
        $authName.val('').prop('readonly', false);
        $authEmail.val('').prop('readonly', false);
        $authMobile.val('').prop('readonly', false);
    }
}

/* -------------------------
   Bind Events
------------------------- */
$(document).on('change', '#directorName', function () {
    const selectedDirector = $('#directorName').val()?.trim();

    if ($('#sameAsDirector').is(':checked') && selectedDirector) {
        toggleSameAsDirector();
    } else {
        $("input[name='authorized[0][name]']").prop('readonly', false);;
        $("input[name='authorized[0][email]']").prop('readonly', false);
        $("input[name='authorized[0][mobile]']").prop('readonly', false);
    }
});

$('#sameAsDirector').on('change', toggleSameAsDirector);

function setSelectedState(stateId) {
    const $stateSelect = $("select[name='state_id']");
    const $hiddenState = $("input[type='hidden'][name='state_id']");

    if (String(stateId) !== $stateSelect.val()) {
        $hiddenState.val(stateId);
        $stateSelect.val(stateId).trigger("change");
    }
}

/* ------------------------------------------------------------------
   Authorized Person Management
-------------------------------------------------------------------*/

/**
 * Add new authorized person row
 */
function addAuthorizedPerson() {
    const index = $(".authorized").length;

    const newRow = `
        <div class="row mb-3 authorized">
            <div class="col-md-4">
                <label>Name <span class="mandatory">*</span></label>
                <input type="text" name="authorized[${index}][name]" class="form-control authName" placeholder="Enter Name" required>
            </div>
            <div class="col-md-4">
                <label>Email <span class="mandatory">*</span></label>
                <input type="email" name="authorized[${index}][email]" class="form-control" placeholder="Enter Email" required>
            </div>
            <div class="col-md-3">
                <label>Mobile Number <span class="mandatory">*</span></label>
                <input type="text" name="authorized[${index}][mobile]" class="form-control numeric" maxlength="10" minlength="10" placeholder="Enter Mobile Number" required>
            </div>
            <div class="col-md-1 mt-4">
                <a href="javascript:void(0);" class="btn btn-danger mt-1 removeAuthorizedPerson">
                    <i class="fa fa-minus"></i>
                </a>
            </div>
        </div>`;

    $(".authorizedPerson").append(newRow);
}

/**
 * Remove authorized person row
 * @param {HTMLElement} el
 */
function removeAuthorizedPerson(el) {
    $(el).closest(".authorized").remove();
}

/* ------------------------------------------------------------------
   Contact Person Management
-------------------------------------------------------------------*/

/**
 * Add new contact person row
 */
function addContactPerson() {
    const index = $(".contactperson").length;

    const newRow = `
        <div class="row mb-3 contactperson">
            <div class="col-md-4">
                <label>Name <span class="mandatory">*</span></label>
                <input type="text" name="contact[${index}][name]" class="form-control" placeholder="Enter Name" required>
            </div>
            <div class="col-md-4">
                <label>Email <span class="mandatory">*</span></label>
                <input type="email" name="contact[${index}][email]" class="form-control" placeholder="Enter Email" required>
            </div>
            <div class="col-md-3">
                <label>Mobile Number <span class="mandatory">*</span></label>
                <input type="text" name="contact[${index}][mobile]" class="form-control numeric" maxlength="10" minlength="10" placeholder="Enter Mobile Number" required>
            </div>
            <div class="col-md-1 mt-4">
                <a href="javascript:void(0);" class="btn btn-danger mt-1 removeContactPerson">
                    <i class="fa fa-minus"></i>
                </a>
            </div>
        </div>`;

    $(".contactPerson").append(newRow);
}

/**
 * Remove contact person row
 * @param {HTMLElement} el
 */
function removeContactPerson(el) {
    $(el).closest(".contactperson").remove();
}

/* ------------------------------------------------------------------
   Event Bindings
-------------------------------------------------------------------*/
$(document).on("click", ".addAuthorizedPerson", addAuthorizedPerson);
$(document).on("click", ".removeAuthorizedPerson", function () {
    removeAuthorizedPerson(this);
});

$(document).on("click", ".addContactPerson", addContactPerson);
$(document).on("click", ".removeContactPerson", function () {
    removeContactPerson(this);
});
