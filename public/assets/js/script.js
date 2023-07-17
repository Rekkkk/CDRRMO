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
