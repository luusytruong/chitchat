//autoHeightInput.js
const input = document.getElementById('input');

input.addEventListener('input', autoHeightInput);

export function autoHeightInput() {
    input.style.height = 'auto';
    input.style.height = `${input.scrollHeight}px`
}