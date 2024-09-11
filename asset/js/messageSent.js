import conn from "./connection.js";

const input = document.getElementById('input');
let username = localStorage.getItem('username');

if (username) {
    console.log('Existing username!')
} else {
    username = prompt("what's your name?");
    if (username) {
        localStorage.setItem('username', username);
        console.log("Enter username done!");
    } else {
        username = "user";
    }
}

function isConnected() {
    return conn.readyState === WebSocket.OPEN;
}

input.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        if (isConnected()) {
            const message = `${username}: ${input.value}`;
            console.log('Sending message: ' + message); // Debug message
            conn.send(message);
            input.value = '';
        } else {
            console.log('Not connect to Server!');
        }
    }
});