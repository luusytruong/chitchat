import { startFetch } from "./fetch.js";

const containerLogin = document.querySelector('.container-login');
const buttonLog = containerLogin.querySelector('button');
const email = document.getElementById('email');
const password = document.getElementById('password');

let isCountingDown = false;

buttonLog.addEventListener('click', (e)=>{
    e.preventDefault();

    if (isCountingDown) {
        return;
    }
    isCountingDown = true;

    const data = {
        email: email.value,
        password: password.value
    }

    startFetch('controller/login.php', data);

    setTimeout(()=>{
        isCountingDown = false;
    }, 3000)

})

