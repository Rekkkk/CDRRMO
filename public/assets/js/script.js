let mobile_side_button = document.querySelector('#btn-sidebar-mobile');
let mobile_side_close = document.querySelector('#btn-sidebar-close');
let sidebar = document.querySelector('.sidebar');

mobile_side_button.onclick = function () {
    sidebar.classList.toggle("active");
}

mobile_side_close.onclick = function () {
    sidebar.classList.remove("active");
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
