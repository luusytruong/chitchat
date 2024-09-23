import { startFetch } from "./fetch.js";
// import './toast.js';

const changeAvatar = document.getElementById('change-avt');
const changeFullname = document.getElementById('change-fullname');
const changeEmail = document.getElementById('change-email');
const changePassword = document.getElementById('change-pw');
const deleteAccount = document.getElementById('delete-account');
const logOut = document.getElementById('log-out');

const wrapperScroll = document.querySelector('.wrapper-scroll');
const navLinks = wrapperScroll.querySelectorAll('.styles');

const actions = [
    () => {
        console.log('avt');
    },
    () => {
        console.log('name');
    },
    () => {
        console.log('mail');
    },
    () => {
        console.log('pw');
    },
    () => {
        console.log('night');
    },
    () => {
        console.log('delete');
    },
    () => {
        console.log('out');
        startFetch('controller/logout.php', '');
    }
]

navLinks.forEach((navLink, index) => {
    navLink.addEventListener('click', ()=>{
        if(actions[index]){
            actions[index]();
        }
    })
});
