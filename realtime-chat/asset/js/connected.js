// const conn = new WebSocket('ws://localhost:8080');
const conn = new WebSocket('https://b227-42-118-101-199.ngrok-free.app');
const messages = document.getElementById('messages');
const input = document.getElementById('input');

conn.onopen = function () {
    console.log('Connected to the server'); // Debug message
};


conn.onmessage = function (e) {
    console.log('Message received: ' + e.data); // Debug message
    const msg = document.createElement('div');
    msg.textContent = e.data;
    messages.appendChild(msg);
    messages.scrollTop = messages.scrollHeight; // Auto scroll to the bottom
};

conn.onerror = function (error) {
    console.error('WebSocket Error: ' + error); // Debug message
};

export default conn;