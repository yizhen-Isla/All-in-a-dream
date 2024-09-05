let img_index = 0;

function creatAuto() {
    return setInterval(function () {
        img_index++;
        refresh()
        document.getElementById('radio' + img_index).checked = true;
    }, 5000)
}
let autoTimer = creatAuto()

function refresh() {
    if (img_index > 3) {
        img_index = 0;
    } else if (img_index < 0) {
        img_index = 3;
    }


    let slideshow = document.querySelector(".slideshow");
    let width = getComputedStyle(slideshow).width;
    // width.slice(0, -2) 刪除了寬度字符串中的最後兩個字符（通常是 px），返回純數字部分的字符串。
    width = Number(width.slice(0, -2));

    let container_slideshow = document.querySelector(".container_slideshow");
    container_slideshow.style.left = img_index * width * -1 + "px";

    // 重新計算秒數
    clearInterval(autoTimer)
    autoTimer = creatAuto()
}
refresh()

let btn_left = document.getElementById("btn_left")
let btn_right = document.getElementById("btn_right")
let radio0 = document.getElementById("radio0")
let radio1 = document.getElementById("radio1")
let radio2 = document.getElementById("radio2")
let radio3 = document.getElementById("radio3")


btn_left.addEventListener('click', function () {
    img_index--;
    refresh()
    document.getElementById('radio' + img_index).checked = true;
});
btn_right.addEventListener('click', function () {
    img_index++;
    refresh()
    document.getElementById('radio' + img_index).checked = true;
});
radio0.addEventListener('click', function () {
    img_index = 0;
    refresh()
});
radio1.addEventListener('click', function () {
    img_index = 1;
    refresh()
});
radio2.addEventListener('click', function () {
    img_index = 2;
    refresh()
});
radio3.addEventListener('click', function () {
    img_index = 3;
    refresh()
});