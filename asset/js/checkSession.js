import { startFetchAsync, isLogin, startFetch } from "./fetch.js";

export async function checkSessionAsync() {
    await startFetchAsync('controller/checkSession.php', '');
    
    if ( !isLogin) {
        window.location.href = 'login.html';
        console.log('0 login');
    } else {
        console.log();
        document.querySelector('.container-home').style.opacity = '1';
    }
}

export function checkSession() {
    startFetch('controller/checkSession.php', '');
    
    if ( !isLogin) {
        console.log('0 login');
    } else {
        console.log('da login');
    }
}

// document.querySelector('.container-home').style.display = 'none';

window.onload = checkSessionAsync;