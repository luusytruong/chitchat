import { getCookie } from "./cookie.js";
import { startFetchNo } from "./fetch.js";


// async function getMessages() {
//     const session_id = getCookie();
//     const data = {
//         session_id: session_id
//     }
//     const result = await startFetchNo('controller/model/getMessages.php', data)

//     let msgHtml;

//     console.log(result.data);
//     console.log(result.session);
//     const currentUser = result.session

//     result.data.forEach(messageData => {

//         //handling sender
//         if (messageData.receiver_id === currentUser) {
//             const resultConverSation = document.querySelector(`.${messageData.sender_id}`)

//             if (resultConverSation) {
//                 msgHtml = `<div class="msg received"><div class="msg-content">${messageData.message}</div></div>`
//                 resultConverSation.innerHTML += msgHtml
//             } else {
//                 console.log('khong ton tai ', messageData.receiver_id);
//             }
//         } else if (messageData.sender_id === currentUser){
//             const resultConverSation = document.querySelector(`.${messageData.receiver_id}`)

//             if (resultConverSation) {
//                 msgHtml = `<div class="msg sent"><div class="msg-content">${messageData.message}</div></div>`
//                 resultConverSation.innerHTML += msgHtml
//             } else {
//                 console.log('khong ton tai ', messageData.receiver_id);
//             }
//         }

//     });

// }

async function getMessages() {
    const session_id = getCookie();
    const data = {
        session_id: session_id
    };
    const result = await startFetchNo('controller/model/getMessages.php', data);

    // console.log(result.data);
    // console.log(result.session);

    const currentUser = result.session;

    // Object để tạm lưu các chuỗi HTML cho từng cuộc trò chuyện
    const conversations = {};

    result.data.forEach(messageData => {
        let msgHtml = '';

        // Kiểm tra tin nhắn là gửi đi hay nhận vào
        // người dùng hiện tại là người nhận
        if (messageData.receiver_id === currentUser) {
            msgHtml = `
            <div class="msg received">
                <div class="msg-content">
                    ${messageData.message}
                </div>
            </div>
            `;
            if (!conversations[messageData.sender_id]) {
                conversations[messageData.sender_id] = '';
            }
            conversations[messageData.sender_id] += msgHtml;

            //ví dụ object này.
            //nếu người nhận là người dùng hiện tại thì sẽ thêm
            //tin nhắn vào object với key là người gửi tin cho mình

            // {
            //     "current_user": "td4735e3a265e16eee03f59718b9b5d03019c07d8b6c51f90da3a666eec13ab35",
            //     "sender_id": "t6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b", //đây là key chính của tin nhắn
            //     "receiver_id": "td4735e3a265e16eee03f59718b9b5d03019c07d8b6c51f90da3a666eec13ab35",
            //     "message": "xin chào Quỳnh 🤣🤣🤣"
            // }

            // người dùng hiện tại là người gửi
        } else if (messageData.sender_id === currentUser) {
            msgHtml = `
            <div class="msg sent">
                <div class="msg-content">
                    ${messageData.message}
                </div>
            </div>
            `;
            if (!conversations[messageData.receiver_id]) {
                conversations[messageData.receiver_id] = '';
            }
            conversations[messageData.receiver_id] += msgHtml;

            //ví dụ object này.
            //nếu người gửi là người dùng hiện tại thì sẽ thêm
            //tin nhắn vào object với key là người nhận tin nhắn của mình

            // {
            //     "current_user": "t6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b",
            //     "sender_id": "t6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b",
            //     "receiver_id": "td4735e3a265e16eee03f59718b9b5d03019c07d8b6c51f90da3a666eec13ab35", //đây là key chính của tin nhắn
            //     "message": "xin chào nhe 🥲🥲"
            // }
        }
    });

    //=> luôn luôn gộp được tin nhắn từ 2 người với nhau vào
    //1 object có key đối lập giữa các phiên người dùng với nhau,

    //debug
    // console.log("Nội dung Object:", conversations);

    // Sau khi xử lý tất cả tin nhắn, nối từng chuỗi HTML vào DOM một lần cho mỗi cuộc trò chuyện
    Object.keys(conversations).forEach(conversationId => {
        const resultConverSation = document.querySelector(`.${conversationId}`);
        if (resultConverSation) {
            resultConverSation.innerHTML += conversations[conversationId];
        } else {
            console.log('không tồn tại ', conversationId);
        }
    });
}

export { getMessages }
