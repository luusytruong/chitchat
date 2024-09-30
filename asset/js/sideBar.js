let navigation;
let sideBar;
let shadow;
let showSideBar;
let hideSideBar;

window.addEventListener('load', function () {
})

    navigation = document.querySelector('.navigation')
    sideBar = document.querySelector('.sidebar')
    shadow = document.querySelector('.shadow')
    showSideBar = document.getElementById('show-sidebar')
    hideSideBar = document.getElementById('hide-sidebar')

    processSideBar();
    
    // window.addEventListener('resize', processSideBar)
    
    showSideBar.addEventListener('click', () => {
        sideBar.classList.remove('deactive');
        sideBar.classList.add('active');
    
        shadow.style.display = 'flex';
        shadow.classList.remove('deactive');
        shadow.classList.add('active');
    })
    
    hideSideBar.addEventListener('click', () => {
        sideBar.classList.remove('active');
        sideBar.classList.add('deactive');
    
        shadow.classList.remove('active');
        shadow.classList.add('deactive');
        setTimeout(() => {
            shadow.style.display = 'none';
        }, 500);
    })
    
    shadow.addEventListener('click', () => {
        sideBar.classList.remove('active');
        sideBar.classList.add('deactive');
    
        shadow.classList.remove('active');
        shadow.classList.add('deactive');
        setTimeout(() => {
            shadow.style.display = 'none';
        }, 500);
    })

export function processSideBar() {
    if (window.innerWidth <= 768) {
        sideBar.style.width = 'unset'
        sideBar.style.right = '10px'
        console.log('if');
    } else {
        const width = navigation.offsetWidth + 'px';
        sideBar.style.width = width;
        console.log(width);
        console.log('else');
        if (width === 0) {
            console.log('ảo vcl')
        }
    }
}
