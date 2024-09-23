import "./toast.js";
import { beginToast } from "./toast.js";

export let isLogin = false;

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
        if (data.login === 'true') {
            isLogin = true;
        }
        if (data.status === 'success'){
            beginToast('success', data.title, data.content);
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 4000);
            }
            if (data.session_id) {
                console.log(data.session_id);
            }
        } else if (data.status === 'error') {
            beginToast('error', data.title, data.content);
        } else {
            beginToast('error', 'Đã xảy ra lỗi không rõ', 'vui lòng thử lại sau');
        }
    })
    .catch(error => {
        console.error('error: ', error);
        beginToast('error', 'Đã xảy ra lỗi phía máy chủ', 'vui lòng thử lại sau ít phút');
    });
};

export async function startFetchAsync(path, data) {
    const params = new URLSearchParams(data);
    try {
        const response = await fetch (path, {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: params.toString()
        });
        const result = await response.json();
        if (result.login === 'true') {
            isLogin = true;
        }
        return result;
    } catch (error) {
        console.log('error: ', error);
        beginToast('error', 'Đã xảy ra lỗi phía máy chủ', 'vui lòng thử lại sau ít phút');
        return null;
    }
} 
