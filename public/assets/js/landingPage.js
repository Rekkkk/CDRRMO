let btn = document.querySelector('#btn-sidebar');
let sidebar = document.querySelector('.sidebar');

window.onload = (event) => {
   
};

btn.onclick = function(){
    sidebar.classList.toggle("active");
}