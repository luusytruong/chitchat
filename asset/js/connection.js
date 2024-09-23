const conn = new WebSocket('ws://localhost:8080'); //thay ipv4:port ở đây

conn.onopen = function () {
    console.log('Connected to the server'); // Debug message
    const SSID = sessionId;
    conn.send(JSON.stringify({type: 'init', session_id: SSID}));
};

conn.onerror = function (error) {
    console.error('WebSocket Error: ' + error); // Debug message
};

export default conn;

function getSessionId() {
    // Tên cookie thường là PHPSESSID
    const name = 'PHPSESSID=';
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookieArray = decodedCookie.split(';');

    for (let i = 0; i < cookieArray.length; i++) {
        const cookie = cookieArray[i].trim();
        // Kiểm tra xem cookie có tên 'PHPSESSID' không
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length); // Trả về giá trị của session ID
        }
    }
    return null; // Nếu không tìm thấy
}

// Sử dụng hàm
const sessionId = getSessionId();
if (sessionId) {
    console.log('Session ID:', sessionId);
} else {
    console.log('Session ID not found in cookies.');
}
console.log(document.cookie.length);
let cook = document.cookie;
cook.replace('PHPSESSID=', '');
cook.slice(10);
console.log(cook.replace('PHPSESSID=', ''));