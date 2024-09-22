import "./toast.js";
import { beginToast } from "./toast.js";

export function startFetch(path, data){
    const params = new URLSearchParams(data);
    fetch(path, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: params.toString()
    })
    .then(response => response.json())
    .then(data => {
        // console.log(data);
        if (data.status === 'success'){
            beginToast('success', data.title, data.content);
        } else if (data.status === 'error') {
            beginToast('error', data.title, data.content);
        } else {
            beginToast('error', 'Đã xảy ra lỗi', 'vui lòng thử lại sau');
        }
    })
    .catch(error => {
        console.error('error: ', error);
        beginToast('error', 'Đã xảy ra lỗi', 'vui lòng thử lại sau');
    });
};
