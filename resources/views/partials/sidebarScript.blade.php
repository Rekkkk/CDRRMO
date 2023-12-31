<script>
    $(document).ready(() => {
        let sidebar = document.querySelector('.sidebar');

        if (localStorage.getItem('session-expired') == '1') {
            localStorage.removeItem("active-link");
            localStorage.setItem('session-expired', '0');
        }

        localStorage.getItem('active-link') ?
            $('.menu-link[href="' + localStorage.getItem('active-link') + '"]').
        addClass('active-link'): $('.menu-link').first().addClass('active-link');

        setTimeout(() => {
            localStorage.setItem('session-expired', '1');
        }, 7200000);

        $(window).resize(() => {
            if (!$('#btn-sidebar-mobile').is(':visible')) sidebar.classList.remove('active');
        });

        document.addEventListener('click', ({
            target
        }) => {
            let element = target;

            element.id == 'btn-sidebar-mobile' ? sidebar.classList.toggle('active') :
                element.id == 'btn-sidebar-close' ? sidebar.classList.remove('active') :
                element.parentElement.className == 'menu-link' ? localStorage.setItem('active-link', $(
                    element.parentElement).attr('href')) :
                element.closest('#logoutBtn') || element.parentElement.id == 'loginLink' ? (localStorage
                    .removeItem('active-link'), localStorage.removeItem('theme')) : null;
        });
    });
</script>
