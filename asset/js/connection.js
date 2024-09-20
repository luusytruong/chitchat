const conn = new WebSocket('ws://localhost:8080'); //thay ipv4:port ở đây

conn.onopen = function () {
    console.log('Connected to the server'); // Debug message
};

conn.onerror = function (error) {
    console.error('WebSocket Error: ' + error); // Debug message
};

export default conn;