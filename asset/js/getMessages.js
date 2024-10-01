import { getCookie } from "./cookie.js";
import { startFetchNo } from "./fetch.js";


async function getMessages() {
    const session_id = getCookie();
    const data = {
        session_id: session_id
    }
    const result = await startFetchNo('controller/model/getMessages.php', data)
    
    console.log(result);

    let msgHtml;

    result.forEach(data => {
        const resultConverSation = document.querySelector(`.${data.receiver_id}`)
        if (resultConverSation) {
            msgHtml = `<div class="msg sent"><div class="msg-content">${data.message}</div></div>`
            resultConverSation.innerHTML += msgHtml
        } else {
            console.log('khong ton tai ', data.receiver_id);
        }

    });
    
}

getMessages()