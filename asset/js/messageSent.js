import conn from "./connection.js";
import { autoHeightInput } from "./autoHeightInput.js";
import { beginToast } from "./toast.js";
import { currentConversation, receiverId } from "./getUsers.js";

const input = document.getElementById('input');

function isConnected() {
    return conn.readyState === WebSocket.OPEN;
}

input.addEventListener('keypress', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault(); //ngăn xuống dòng

        if (isConnected()) {
            if (input.value !== '') {

                const message = input.value.trim();

                const data = {
                    type: 'message',
                    receiver_id: receiverId,
                    group_id: null,
                    msg: message
                }

                const jsonData = JSON.stringify(data)

                conn.send(jsonData);


                const msgSent = document.createElement('div');
                const msgContent = document.createElement('div');

                msgSent.className = 'msg sent';
                msgContent.className = 'msg-content';
                msgContent.textContent = message;
                msgSent.appendChild(msgContent);
                currentConversation.appendChild(msgSent);

                console.log('Sending message: ' + message); // Debug message
                input.value = '';
                autoHeightInput();
            } else {
                console.log('Nothing!');
            }
        } else {
            console.log('Not connect to Server!');
            beginToast('error', 'Mất kết nối', 'Vui lòng thử lại sau');
        }
    } else if (e.key === 'Enter' && e.shiftKey) {
        console.log('shift + enter');

    }
});

conn.onmessage = function (e) {
    const data = JSON.parse(e.data);
    if (data.type === 'status') {

        console.log(data);

        const userId = data.user_id;
        const account = document.getElementById(`${userId}`);

        console.log(userId);
        console.log(account);

        if (account) {
            const status = account.querySelector('.user-info');
            if (data.is_online === true) {
                status.classList.add('on')
                console.log('true');
            } else {
                status.classList.remove('on')
                console.log('false');
            }
        } else {
            console.log('no account');
        }

        return;
    } else {
        console.log('0 ok');
    }



    const msgSent = document.createElement('div');
    const msgContent = document.createElement('div');

    msgSent.className = 'msg received';
    msgContent.className = 'msg-content';
    msgContent.textContent = e.data;
    msgSent.appendChild(msgContent);
    currentConversation.appendChild(msgSent);

    console.log('Message received: ' + e.data); // Debug message
};

export { input };