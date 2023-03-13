const forms = ["Typhoon", "Road Accident", "Earthquake", "Flooding"];

window.onload = (event) => {
   
};

document.getElementById('disaster').addEventListener('change', (event) => {
    const selectForm = event.target.value;
    
    forms.forEach((formId) => {
        const form = document.getElementById(formId);
       
        if(selectForm == formId){
            form.style.opacity = 1;
            form.style.display = "contents";
        }else{
            form.style.opacity = 0;
            form.style.display = "none";
        }
    });
});
