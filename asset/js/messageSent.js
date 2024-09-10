import conn from "./connected.js";

let username = localStorage.getItem('username');
if (username) {
    console.log('Existing username!')

//} if (username === null){

} else {
    username = prompt("what's your name?");
    if (username) {
        localStorage.setItem('username', username);
        console.log("Enter username done!");
    } else {
        username = "user";
    }
}

input.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        const message = `${username}: ${input.value}`;
        console.log('Sending message: ' + message); // Debug message
        conn.send(message);
        input.value = '';
    }
});