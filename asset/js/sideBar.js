const navigation = document.querySelector('.navigation')
const sideBar = document.querySelector('.sidebar')
const shadow = document.querySelector('.shadow')
const showSideBar = document.getElementById('show-sidebar')
const hideSideBar = document.getElementById('hide-sidebar')

processSideBar()

export function processSideBar() {
    if (window.innerWidth <= 768){
        sideBar.style.width = 'unset'
        sideBar.style.right = '10px'
        // console.log('if');
    } else {
        sideBar.style.width = navigation.offsetWidth + 'px'
        // console.log('else');
    }
}

// window.addEventListener('resize', processSideBar)

showSideBar.addEventListener('click', ()=>{
    sideBar.classList.remove('deactive');
    sideBar.classList.add('active');
    
    shadow.style.display = 'flex';
    shadow.classList.remove('deactive');
    shadow.classList.add('active');
})

hideSideBar.addEventListener('click', ()=>{
    sideBar.classList.remove('active');
    sideBar.classList.add('deactive');
    
    shadow.classList.remove('active');
    shadow.classList.add('deactive');
    setTimeout(() => {
        shadow.style.display = 'none';
    }, 500);
})

shadow.addEventListener('click', ()=>{
    sideBar.classList.remove('active');
    sideBar.classList.add('deactive');
    
    shadow.classList.remove('active');
    shadow.classList.add('deactive');
    setTimeout(() => {
        shadow.style.display = 'none';
    }, 500);
})
