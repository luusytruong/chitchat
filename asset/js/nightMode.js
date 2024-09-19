const nightModeLabel = document.getElementById('night-mode');
const checkbox = document.getElementById('night-checkbox');

nightModeLabel.addEventListener('click', ()=>{
    checkbox.checked = !checkbox.checked;

    if(checkbox.checked){
        console.log('night mode on');
    } else {
        console.log('night mode off');
    }
})