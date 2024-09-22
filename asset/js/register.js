import { startFetch } from "./fetch.js";

const form = document.getElementById('form');
const fullname = document.getElementById('fullname');
const email = document.getElementById('email');
const password = document.getElementById('password');
const repeatPassword = document.getElementById('repeat-password');
const buttonReg = document.querySelector('button');

// buttonReg.addEventListener('click', (e) => {
//     e.preventDefault();

//     if (repeatPassword.value !== '' && password.value !== '' && email.value !== '' && fullname.value !== '') {
//         if (password.value !== repeatPassword.value) {
//             toastStart('red', '!', 'i3');
//             // console.log('sai mật khẩu');
//         } else if (password.value === repeatPassword.value) {
//             if (password.value.length < 6) {
//                 toastStart('red', '!', 'i5')
//                 // console.log('mật khẩu yếu');
//             } else {
//                 toastStart(' ', 'v', 'i4');
//                 console.log('tất cả đều đúng');

//                 const data = {
//                     fullname: fullname.value,
//                     email: email.value,
//                     password: password.value
//                 };
//                 console.log(data);
//                 startFetch('controller/register.php', data);

//                 // form.submit();
//             }
//         }
//     } else {
//         toastStart('red', '!', 'i1');
//         // console.log('thiếu thông tin');
//     }
// })

let isCountingDown = false;

buttonReg.addEventListener('click', (e) => {
    e.preventDefault();
    
    if (isCountingDown) {
        return;
    }

    isCountingDown = true;
    
    const data = {
        fullname: fullname.value,
        email: email.value,
        password: password.value,
        repeat_password: repeatPassword.value
    }
    
    startFetch('controller/register.php', data);
    
    setTimeout(()=>{
        isCountingDown = false;
    }, 3000);
})

// const test = document.getElementById('test');

// test.addEventListener('click', (e)=>{
//     e.preventDefault();
//     if (email.value.includes('@gmail.com')) {
//         console.log('có @gmail.com', email.value);
//     } else {
//         console.log('0 có @gmail.com', email.value);
//         const mail = email.value.concat('@gmail.com');
//         console.log('da them', mail);
//     }
// })

// password.addEventListener('keydown', (e)=>{
//     if (e.key === ' ') {
//         // console.log('space');
//         e.preventDefault();
//     }
// })
// repeatPassword.addEventListener('keydown', (e)=>{
//     if (e.key === ' ') {
//         // console.log('space');
//         e.preventDefault();
//     }
// })