import { getCookie } from "./cookie.js";
import { startFetchNo } from "./fetch.js";
import { input } from "./messageSent.js";
import { isIpad, scrollRight } from "./userAction.js";

async function importUser() {
    const ssid = getCookie();
    const data = {
        session_id: ssid
    }
    const result = await startFetchNo('controller/model/user.php', data);

    console.log(result);

    const usersList = document.getElementById('users-list');
    const bodyChat = document.querySelector('.body-chat');

    result.forEach(data => {
        usersList.innerHTML += data.user;
        bodyChat.innerHTML += data.conversation;
    });
    startUserAction();
}

importUser();

let currentConversation;
let receiverId

export function startUserAction() {
    let listUser = document.querySelector(".users-list");
    let users = listUser.querySelectorAll(".user");
    const main = document.querySelector('.main');
    const readyStart = document.getElementById('ready-start');
    const boxMsgs = main.querySelector('.wrapper');
    const dot = `<div class="dot"></div>`;

    users.forEach((user) => {
        user.innerHTML += dot;

        user.addEventListener("click", function () {

            if (!isIpad) {
                console.log('ngoài phạm vi ipad');
                if (user.classList.contains("active")) {
                    console.log('có active => return');
                    return;
                } else {
                    console.log('không có active => continue');
                }
            } else {
                console.log('trong phạm vi ipad');
            }
            receiverId = user.id
            currentConversation = boxMsgs.querySelector(`.${user.id}`);
            if (currentConversation) {
                console.log(currentConversation);
                const titleFullname = boxMsgs.querySelector('.user-name');
                const tabFullname = user.querySelector('.user-name');
                titleFullname.textContent = tabFullname.textContent;
                const status = user.querySelector('.user-info').className;
                boxMsgs.querySelector('.user-info').classList = status;
            } else {
                console.log('no message => return');
                return;
            }

            readyStart.className = 'deactive';
            boxMsgs.classList.add('active');

            boxMsgs.querySelectorAll('.active').forEach((conversationActive) => {
                conversationActive.classList.remove('active');
            })

            listUser.querySelectorAll(".active").forEach((userActive) => {
                userActive.classList.remove("active");
            });

            currentConversation.classList.add('active');
            user.classList.add("active");
            scrollRight();

            input.focus();
            console.log('id',receiverId);
        });


    });
    console.log('loaded');
}

export {currentConversation, receiverId};