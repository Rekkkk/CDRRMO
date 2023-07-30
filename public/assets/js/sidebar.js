const sidebar = document.querySelector('.sidebar');

document.addEventListener('click', ({ target }) => {
    const element = target;

    element.id == 'btn-sidebar-mobile' ? sidebar.classList.toggle('active')
        : element.id == 'btn-sidebar-close' ? sidebar.classList.remove('active')
            : element.parentElement.className == 'menuLink' ? localStorage.setItem('activeLink', $(element.parentElement).attr('href'))
                : element.closest('#logoutBtn') || element.parentElement.id == 'loginLink' ? localStorage.removeItem('activeLink') : null;
});

$(document).ready(function () {
    if (localStorage.getItem('sessionExpired') == '1') {
        localStorage.removeItem("activeLink");
        localStorage.setItem('sessionExpired', '0');
    }

    localStorage.getItem('activeLink') ?
        $('.menuLink[href="' + localStorage.getItem('activeLink') + '"]').
            addClass('activeLink') :
        $('.menuLink').first().addClass('activeLink');

    setTimeout(function () {
        localStorage.setItem('sessionExpired', '1');
    }, 7200000);

    $(window).resize(function () {
        if (!$('#btn-sidebar-mobile').is(':visible')) {
            sidebar.classList.remove('active');
        }
    });

});
