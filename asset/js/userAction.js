import conn from "./connection.js";

const body = document.body;
const containerHome = document.querySelector(".container-home");
const listUser = document.querySelector(".users-list");
const users = listUser.querySelectorAll(".user");
const buttonBack = document.getElementById("back");
const tabList = document.querySelector(".tablist");
const buttonTabs = tabList.querySelectorAll(".wrapper");
const search = document.getElementById("search");
const closeSearch = document.getElementById("close-search");
const main = document.querySelector('.main');
const boxMsgs = main.querySelectorAll('.wrapper');
const readyStart = document.getElementById('ready-start');

search.addEventListener("click", (e) => {
    closeSearch.style.display = "flex";
    e.stopPropagation();
});

closeSearch.addEventListener("click", (e) => {
    search.value = '';
    closeSearch.style.display = "none";
    e.stopPropagation();
});

document.addEventListener("click", () => {
    search.value = '';
    closeSearch.style.display = "none";
});

buttonTabs.forEach((buttonTab) => {
    const parentButtonTab = buttonTab.parentElement;

    buttonTab.addEventListener("click", () => {
        if (parentButtonTab.classList.add("active")) {
            return;
        }

        const actives = tabList.querySelectorAll(".active");
        actives.forEach((active) => {
            active.classList.remove("active");
        });

        parentButtonTab.classList.add("active");
    });
});

const dot = `<div class="dot"></div>`;

export function scrollRight() {
    body.scrollLeft += containerHome.offsetWidth;
}

export function scrollLeft() {
    body.scrollLeft -= containerHome.offsetWidth;
}


buttonBack.addEventListener("click", () => {
    scrollLeft();
});

// window.addEventListener("resize", scrollLeft);
// window.addEventListener("resize", resizeWindow);

let isIpad = false;

export function resizeWindow() {
    isIpad = window.innerWidth <= 768;
    // console.log(isIpad);
}

resizeWindow();

conn.onmessage = function (e) {
    const data = JSON.parse(e.data);

    if (data.type == 'init') {
        const resourceId = data.resourceId;
        console.log(resourceId);
    }
}

users.forEach((user, index) => {
    user.innerHTML += dot;

    function statusUser() {
        
    }

    user.addEventListener("click", function () {
        const titleFullname = boxMsgs[index].querySelector('.user-name');
        const tabFullname = user.querySelector('.user-name');

        titleFullname.textContent = tabFullname.textContent;

        readyStart.className = 'deactive';

        if (!isIpad) {
            // console.log("ngoai le");
            
            if (user.classList.contains("active")) {
                return;
            }
        }
        main.querySelectorAll('.active').forEach((currentActive) =>{
            currentActive.classList.remove('active');
        })
        const userActives = listUser.querySelectorAll(".active");
        userActives.forEach((userActive) => {            
            userActive.classList.remove("active");
        });
        boxMsgs[index].classList.add('active');
        user.classList.add("active");
        scrollRight();
        console.log(index);
    });
});

boxMsgs.forEach((boxMsg, index) => {

});