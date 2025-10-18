$(document).ready(function () {
    let currentStep = 1;
    const totalSteps = $(".step").length; // Auto detect

    function showStep(step) {
        $(".step").hide();
        $(`.step[data-step="${step}"]`).show();

        if ($("#prevStep").length) {
            $("#prevStep").toggle(step > 1);
        }
        if ($("#nextStep").length) {
            $("#nextStep").toggle(step < totalSteps);
        }
        if ($("#submitForm").length) {
            $("#submitForm").toggle(step === totalSteps);
        }
    }

    function validateStep(step) {
        let isValid = true;

        $(`.step[data-step="${step}"] :input[required]`).each(function () {
            if (!$(this).val().trim()) {
                $(this).addClass("is-invalid");
                isValid = false;
            } else {
                $(this).removeClass("is-invalid");
            }
        });

        return isValid;
    }

    if ($("#nextStep").length) {
        $("#nextStep").click(function () {
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });
    }

    if ($("#prevStep").length) {
        $("#prevStep").click(function () {
            currentStep--;
            showStep(currentStep);
        });
    }

    showStep(currentStep);
});
