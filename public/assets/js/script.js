let currentPassword = $('#currentPassword'),
    password = $('#password'),
    confirmPassword = $('#confirmPassword'),
    resetPasswordBtn = $('#resetPasswordBtn'),
    passwordShowIcon = $('#showPassword'),
    confirmPasswordShowIcon = $('#showConfirmPassword'),
    changePasswordForm = $('#changePasswordForm'),
    changePasswordModal = $('#changePasswordModal'),
    eyeIcon = $('.toggle-password'),
    current_password = "";

$(document).ready(function () {
    let changePasswordValidation = changePasswordForm.validate({
        rules: {
            password: {
                required: true
            },
            confirmPassword: {
                required: true
            }
        },
        messages: {
            password: {
                required: 'Password field is required.'
            },
            confirmPassword: {
                required: 'Confirm password field is required.'
            }
        },
        errorElement: 'span',
        submitHandler: changePasswordHandler
    });

    $(document).on('input', '#current_password', function () {
        current_password = $('#current_password').val();

        clearTimeout($(this).data('checkingDelay'));

        $(this).data('checkingDelay', setTimeout(function () {
            let checkPasswordRoute = $('#checkPasswordRoute').data('route');

            if (current_password == "") {
                changePasswordValidation.resetForm();
                resetChangePasswordForm();
                return;
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: checkPasswordRoute,
                data: {
                    current_password: current_password
                },
                success: function (response) {
                    if (response.status == "warning") {
                        current_password = "";
                        currentPassword.text("* Password doesn't matched.").removeClass('text-green-600').addClass('text-red-600');
                        eyeIcon.removeClass('bi-eye').addClass('bi-eye-slash');
                        password.add(confirmPassword).val("").prop('type', 'password').add(resetPasswordBtn.removeClass('hover:scale-105 hover:bg-yellow-600')).prop('disabled', true);
                    } else {
                        currentPassword.text('* Password matched.').removeClass('text-red-600').addClass('text-green-600');
                        password.add(confirmPassword).add(resetPasswordBtn).prop('disabled', false)
                        resetPasswordBtn.addClass('hover:scale-105 hover:bg-yellow-600');
                    }
                }
            });
        }, 500));
    });

    changePasswordModal.on('hidden.bs.modal', function () {
        resetChangePasswordForm();
        changePasswordValidation.resetForm();
    });

    $(document).on('click', '.toggle-password', function () {
        const currentPasswordInput = $('#current_password');

        if (current_password == "") {
            currentPasswordInput.css('border-color', 'red');
            setTimeout(function () {
                currentPasswordInput.removeAttr('style');
            }, 1000);
        } else {
            currentPasswordInput.removeAttr('style');
            const inputElement = $($(this).data('target'));
            inputElement.prop('type', inputElement.prop('type') == 'password' ? 'text' : 'password');
            $(this).toggleClass('bi-eye-slash bi-eye');
        }
    });
});

function confirmModal(text) {
    return Swal.fire({
        title: 'Confirmation',
        text: text,
        icon: 'info',
        iconColor: '#1d4ed8',
        showDenyButton: true,
        confirmButtonText: 'Yes',
        confirmButtonColor: '#15803d',
        denyButtonText: 'No',
        denyButtonColor: '#B91C1C',
        allowOutsideClick: false,
    });
}

function showWarningMessage(message) {
    return toastr.warning(message, 'Warning');
}

function showSuccessMessage(message) {
    return toastr.success(message, 'Success');
}

function showErrorMessage() {
    return toastr.error('An error occurred while processing your request.', 'Error');
}

function datePicker(id) {
    return flatpickr(id, {
        enableTime: true,
        allowInput: true,
        static: false,
        timeFormat: "h:i K",
        dateFormat: "D, M j, Y h:i K",
        minuteIncrement: 1,
        secondIncrement: 1,
        position: "below center"
    });
}

function resetChangePasswordForm() {
    current_password = "";
    currentPassword.text("");
    changePasswordForm[0].reset();
    eyeIcon.removeClass('bi-eye').addClass('bi-eye-slash');
    password.add(confirmPassword).prop('type', 'password').add(resetPasswordBtn.toggleClass('hover:scale-105 hover:bg-yellow-600')).prop('disabled', true);
}

function changePasswordHandler(form) {
    let changePasswordRoute = $('#changePasswordRoute').data('route');

    confirmModal('Do you want to change your password?').then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "PUT",
                url: changePasswordRoute,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.status == "warning") {
                        showWarningMessage(response.message);
                    } else {
                        showSuccessMessage('Password successfully changed.');
                        form[0].reset();
                        currentPassword.text("");
                        changePasswordModal.modal('hide');
                    }
                },
                error: function () {
                    showErrorMessage();
                }
            });
        }
    });
}

function getRowData(row, table) {
    let currentRow = $(row).closest('tr');

    if (table.responsive && table.responsive.hasHidden()) {
        currentRow = currentRow.prev('tr');
    }

    return table.row(currentRow).data();
}