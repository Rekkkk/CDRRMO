const sidebar = document.querySelector('.sidebar'),
    authPassword = document.getElementById("authPassword"),
    password = document.getElementById("password"),
    cPassword = document.getElementById("confirmPassword");

document.addEventListener('click', function (object) {
    const element = object.target;

    if (element.id == 'btn-sidebar-mobile') {
        sidebar.classList.toggle('active');
    } else if (element.id == 'btn-sidebar-close') {
        sidebar.classList.remove('active');
    } else if (element.id == 'showPassword' || element.id == 'showConfirmPassword' || element.id == 'showAuthPassword') {
        const target = element.id == 'showPassword' ? password : element.id == 'showConfirmPassword' ? cPassword : authPassword;
        target.type = target.type == 'password' ? 'text' : 'password';
        element.classList.toggle("bi-eye");
    } else if (element.parentElement.className == 'menuLink') {
        localStorage.setItem('activeLink', $(element.parentElement).attr('href'));
    } else if (element.closest('#logoutBtn') || element.parentElement.id == 'loginLink') {
        localStorage.removeItem("activeLink");
    }
});

$(document).ready(function () {
    localStorage.getItem('activeLink') ?
        $('.menuLink[href="' + localStorage.getItem('activeLink') + '"]').
            addClass('activeLink') :
        $('.menuLink').first().addClass('activeLink');

    $(document).on('click', '.changePasswordBtn', function () {
        $('#operation').val('change');
        $('#changePasswordModal').modal('show');
    });

    $('#current_password').on('input', function () {
        var current_password = $('#current_password').val();

        if (current_password === '')
            return $('#currentPassword').html('');

        clearTimeout($(this).data('checkingDelay'));

        $(this).data('checkingDelay', setTimeout(function () {
            let checkPasswordRoute = $('#checkPasswordRoute').data('route');
            $.ajax({
                type: 'POST',
                url: checkPasswordRoute,
                data: {
                    current_password: current_password
                },
                success: function (response) {
                    if (response.status == "warning") {
                        $('#currentPassword').html(
                            '* Current Password is Incorrect.')
                            .removeClass('text-green-600').addClass(
                                'text-red-600');
                        $('#password ,#confirmPassword, #changePasswordBtn')
                            .prop('disabled',
                                true);
                    } else {
                        $('#currentPassword').html(
                            '* Current Password is Correct.')
                            .removeClass('text-red-600').addClass(
                                'text-green-600');
                        $('#password, #confirmPassword, #changePasswordBtn')
                            .prop('disabled',
                                false);
                    }
                }
            });
        }, 500));
    });

    let changePasswordValidation = $("#changePasswordForm").validate({
        rules: {
            current_password: {
                required: true
            },
            password: {
                required: true
            },
            confirmPassword: {
                required: true
            }
        },
        messages: {
            current_password: {
                required: 'Current password is required.'
            },
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

    $('#changePasswordModal').on('hidden.bs.modal', function () {
        changePasswordValidation.resetForm();
        $('#currentPassword').html("");
        $('#changePasswordForm')[0].reset();
    });
});

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
                        toastr.warning(response.message, 'Warning');
                    } else {
                        toastr.success('Password successfully changed.', 'Success');
                        $('#changePasswordForm')[0].reset();
                        $('#currentPassword').html("");
                        $('#changePasswordModal').modal('hide');
                    }
                },
                error: function () {
                    toastr.error('An error occurred while processing your request.', 'Error');
                }
            });
        }
    });
}

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

function messageModal(title, text, icon, iconColor) {
    return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        iconColor: iconColor,
        showConfirmButton: false,
        timer: 2000,
        allowOutsideClick: false,
    });
}
