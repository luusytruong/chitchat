const buttonShow = document.getElementById('button-show');
const moreOption = document.getElementById('more');

buttonShow.addEventListener('click', function(){
    // buttonShow.style.animation = 'rotate .3s forwards';
    const showOrHide = this.getAttribute('class') === 'fa-solid fa-plus' ? 'fa-solid fa-plus active' : 'fa-solid fa-plus';
    const showOrHideOption = moreOption.getAttribute('class') === '' ? 'active' : '';
    this.setAttribute('class', showOrHide);
    moreOption.setAttribute('class', showOrHideOption);
})


const textArea = document.getElementById('input-area');

textArea.addEventListener('click', function(){
    buttonShow.classList.remove('active');
    moreOption.classList.remove('active');
})
