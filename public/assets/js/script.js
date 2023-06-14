let btn = document.querySelector('#btn-sidebar');
let mobile_side_button = document.querySelector('#btn-sidebar-mobile');
let mobile_side_close = document.querySelector('#btn-sidebar-close');
let sidebar = document.querySelector('.sidebar');

btn.onclick = function(){
    sidebar.classList.toggle("active");
}

mobile_side_button.onclick = function (){
    sidebar.classList.toggle("active");
}

mobile_side_close.onclick = function (){
    sidebar.classList.remove("active");
}