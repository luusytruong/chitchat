const toast = document.getElementById('toast');
const toastIcon = toast.querySelector('.toast-icon');
const toastTitle = toast.querySelector('.toast-title');
const toastContent = toast.querySelector('.toast-content');

function toastCreate(icon, info) {
    if (icon === 'v') {
        toastIcon.innerHTML = '<i class="fa-solid fa-circle-check"></i>';
    } else if (icon === '!') {
        toastIcon.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i>';
    }
    switch (info) {
        case 'i1':
            toastTitle.textContent = 'Thiếu thông tin';
            toastContent.textContent = 'vui lòng nhập đủ thông tin';
            break;
        case 'i2':
            toastTitle.textContent = 'Email không hợp lệ';
            toastContent.textContent = 'hãy nhập lại email';
            break;
        case 'i3':
            toastTitle.textContent = 'Mật khẩu không khớp';
            toastContent.textContent = 'vui lòng kiểm tra lại';
            break;
        case 'i4':
            toastTitle.textContent = 'Đăng ký thành công';
            toastContent.textContent = 'chuyển hướng sau 5s';
            break;
        case 'i5':
            toastTitle.textContent = 'Mật khẩu quá ngắn';
            toastContent.textContent = 'vui lòng sử dụng mật khẩu mạnh hơn';
            break;
        case 'i6':
            toastTitle.textContent = 'Sai email hoặc mật khẩu';
            toastContent.textContent = 'vui lòng thử nhập lại';
            break;
        default:
            toastTitle.textContent = '6';
            toastContent.textContent = 'vui lòng nhập đủ thông tin';
            break;
    }
}

let isCountingDown = false;

export function toastStart(color, icon, info) {
    if (isCountingDown) {
        // console.log('dang hoi');
        return;
    }

    isCountingDown = true;

    if (color === 'red') {
        toast.classList.add('error');
    } else {
        toast.classList.add('successful');
    }
    setTimeout(() => {
        isCountingDown = false;
        toast.classList.remove('successful');
        toast.classList.remove('error');
    }, 3000);
    toastCreate(icon, info);
}

export function beginToast(status, title, content, time) {
    if (status === 'success') {
        toast.classList.add('successful');
        toastIcon.innerHTML = '<i class="fa-solid fa-circle-check"></i>';
        toastTitle.textContent = title;
        toastContent.textContent = content;
    } else if (status === 'error') {
        toast.classList.add('error');
        toastIcon.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i>';
        toastTitle.textContent = title;
        toastContent.textContent = content;
    }
    setTimeout(() => {
        toast.classList.remove('successful');
        toast.classList.remove('error');
    }, 3000);
}

// export default toast;