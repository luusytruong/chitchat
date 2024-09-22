import conn from "./connection.js";
import { autoHeightInput } from "./autoHeightInput.js";

// let username = localStorage.getItem('username');

// if (username) {
//     console.log('Existing username!')
// } else {
//     username = prompt("what's your name?");
//     if (username) {
//         localStorage.setItem('username', username);
//         console.log("Enter username done!");
//     } else {
//         username = "user";
//     }
// }

const input = document.getElementById('input');
const msgList = document.getElementById('msg-list');

function isConnected() {
    return conn.readyState === WebSocket.OPEN;
}

// document.addEventListener('DOMContentLoaded', () => {
//     if (msgList) {
//         msgList.innerHTML = '';
//         console.log('clean');
//     } else {
//         msgList.createElement()
//         console.log('unclean');
//     }
// })

input.addEventListener('keypress', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault(); //ngăn xuống dòng

        if (isConnected()) {
            if (input.value !== '') {

                const msg = input.value.trim();

                conn.send(msg);

                const msgSent = document.createElement('div');
                const msgContent = document.createElement('div');

                msgSent.className = 'msg sent';
                msgContent.className = 'msg-content';
                msgContent.textContent = msg;
                msgSent.appendChild(msgContent);
                msgList.appendChild(msgSent);

                console.log('Sending message: ' + msg); // Debug message
                input.value = '';
                autoHeightInput();
            } else {
                console.log('Nothing!');
            }
        } else {
            console.log('Not connect to Server!');
        }
    } else if (e.key === 'Enter' && e.shiftKey) {
        console.log('shift + enter');

    }
});

conn.onmessage = function (e) {
    const msgSent = document.createElement('div');
    const msgContent = document.createElement('div');

    msgSent.className = 'msg received';
    msgContent.className = 'msg-content';
    msgContent.textContent = e.data;
    msgSent.appendChild(msgContent);
    msgList.appendChild(msgSent);

    console.log('Message received: ' + e.data); // Debug message
};