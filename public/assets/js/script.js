const sidebar = document.querySelector('.sidebar'),
    authPassword = document.getElementById("authPassword"),
    password = document.getElementById("password"),
    cPassword = document.getElementById("confirmPassword");

document.addEventListener('click', function (object) {
    if (object.target.id == 'btn-sidebar-mobile') {
        sidebar.classList.toggle('active');
    } else if (object.target.id == 'btn-sidebar-close') {
        sidebar.classList.remove('active');
    } else if (object.target.id == 'showPassword' || object.target.id == 'showConfirmPassword' || object.target.id == 'showAuthPassword') {
        const target = object.target.id == 'showPassword' ? password : object.target.id == 'showConfirmPassword' ? cPassword : authPassword;
        target.type = target.type == 'password' ? 'text' : 'password';
        object.target.classList.toggle("bi-eye");
    }
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
