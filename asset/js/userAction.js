const body = document.body;
const containerHome = document.querySelector(".container-home");
const listUser = document.querySelector(".users-list");
const users = listUser.querySelectorAll(".user");
const buttonBack = document.getElementById("back");
const tabList = document.querySelector(".tablist");
const buttonTabs = tabList.querySelectorAll(".wrapper");
const search = document.getElementById("search");
const closeSearch = document.querySelector(".fa-xmark");

search.addEventListener("click", (e) => {
    closeSearch.style.display = "flex";
    e.stopPropagation();
});

closeSearch.addEventListener("click", (e) => {
    closeSearch.style.display = "none";
    e.stopPropagation();
});

document.addEventListener("click", () => {
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

function scrollRight() {
    body.scrollLeft += containerHome.offsetWidth;
    behavior: "smooth";
}

function scrollLeft() {
    body.scrollLeft -= containerHome.offsetWidth;
    behavior: "smooth";
}


buttonBack.addEventListener("click", () => {
    scrollLeft();
});

window.addEventListener("resize", scrollLeft);
window.addEventListener("resize", resizeWindow);

let isIpad = false;

function resizeWindow() {
    isIpad = window.innerWidth <= 768;
    console.log(isIpad);
}

resizeWindow();

users.forEach((user, index) => {
    user.innerHTML += dot;

    user.addEventListener("click", function () {
        if (!isIpad) {
            // console.log("ngoai le");

            if (user.classList.contains("active")) {
                return;
            }
        }
        const userActives = listUser.querySelectorAll(".active");
        userActives.forEach((userActive) => {

            userActive.classList.remove("active");
        });
        user.classList.add("active");
        scrollRight();
        console.log(index);
    });
});
