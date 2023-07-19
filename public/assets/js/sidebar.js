const sidebar = document.querySelector('.sidebar'),
    authPassword = document.getElementById("authPassword");

document.addEventListener('click', function (object) {
    const element = object.target;

    if (element.id == 'btn-sidebar-mobile') {
        sidebar.classList.toggle('active');
    } else if (element.id == 'btn-sidebar-close') {
        sidebar.classList.remove('active');
    } else if (element.id == 'showAuthPassword') {
        authPassword.type = authPassword.type == 'password' ? 'text' : 'password';
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