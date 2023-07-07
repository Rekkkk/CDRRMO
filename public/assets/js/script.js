let mobile_side_button = document.querySelector('#btn-sidebar-mobile'),
    mobile_side_close = document.querySelector('#btn-sidebar-close'),
    sidebar = document.querySelector('.sidebar'),
    showPassword = document.getElementById("show-password"),
    showConfirmPassword = document.getElementById("show-confirm"),
    password = document.getElementById("password"),
    cPassword = document.getElementById("confirm_password");

mobile_side_button.onclick = function () {
    sidebar.classList.toggle("active");
}

mobile_side_close.onclick = function () {
    sidebar.classList.remove("active");
}

showPassword.onclick = togglePasswordVisibility;
showConfirmPassword.onclick = togglePasswordVisibility;

function togglePasswordVisibility() {
    if (this === showPassword)
        toggleVisibility(password);
    else if (this === showConfirmPassword)
        toggleVisibility(cPassword);

    this.classList.toggle("bi-eye");
}

function toggleVisibility(inputField) {
    if (inputField.type === "password")
        inputField.type = "text";
    else
        inputField.type = "password";
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
