//windowResize.js
import { autoHeightInput } from "./autoHeightInput.js";
import { processSideBar } from "./sideBar.js";
import { resizeWindow } from "./userAction.js";
import { scrollLeft } from "./userAction.js";

window.addEventListener('resize', () => {
    autoHeightInput();
    processSideBar();
    resizeWindow();
    scrollLeft();
})