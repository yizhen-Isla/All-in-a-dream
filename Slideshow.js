
// [[[[[[[[[[[[[ jQery寫法 ]]]]]]]]]]]]]

// 設定圖片index (從0開始)
let img_index = 0;

//--------改輪播背景色需用到的-----------
// 宣告 輪播圖片組物件
const slideshow_images = $(".slideshow_img");
// 宣告 背景物件
const BGC = $("#background_container");
// 創建 Color Thief 實例(用於取圖片顏色)
const colorThief = new ColorThief();


function creatAuto() {
    return setInterval(function () {
        img_index++;
        refresh();
        $('#radio' + img_index).prop('checked', true);
    }, 5000);
}
let autoTimer = creatAuto();

function refresh() {
    if (img_index > 3) {
        img_index = 0;
    } else if (img_index < 0) {
        img_index = 3;
    }

    let width = $('.slideshow').css('width').slice(0, -2); // 移除 'px'，並轉換為數字
    width = Number(width);

    $(".container_slideshow").css('left', img_index * width * -1 + "px");

    //---------------------------------------------------
    // 抓圖片主要顏色
    let currentImage = slideshow_images[img_index];
    
    loadImage(currentImage, function(){
        let dominantColor = colorThief.getColor(currentImage);
        let rgbColor = `rgb(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]})`;
        BGC.css("backgroundColor", rgbColor);
    });
    //---------------------------------------------------

    // 重新計算秒數
    clearInterval(autoTimer);
    autoTimer = creatAuto();
}

//---------------------------------------------------
// 確保圖片加載後，才抓顏色
function loadImage(slideshow_images, callback) {
    if (slideshow_images.complete) {
        callback();
    } else {
        $(slideshow_images).on('load', callback);
    }
}
//---------------------------------------------------

// 初始執行
refresh();

// 左右按鈕和 radio 事件
$('#btn_left').on('click', function () {
    img_index--;
    refresh();
    $('#radio' + img_index).prop('checked', true);
});
$('#btn_right').on('click', function () {
    img_index++;
    refresh();
    $('#radio' + img_index).prop('checked', true);
});

$('#radio0').on('click', function () {
    img_index = 0;
    refresh();
});
$('#radio1').on('click', function () {
    img_index = 1;
    refresh();
});
$('#radio2').on('click', function () {
    img_index = 2;
    refresh();
});
$('#radio3').on('click', function () {
    img_index = 3;
    refresh();
});


// [[[[[[[[[[[[[ JS寫法 ]]]]]]]]]]]]]

// // 設定圖片index (從0開始)
// let img_index = 0;

// //--------改輪播背景色需用到的-----------
// // 宣告 輪播圖片組物件
// const slideshow_images = $(".slideshow_img");
// // 宣告 背景物件
// const BGC = $("#background_container");
// // 創建 Color Thief 實例(用於取圖片顏色)
// const colorThief = new ColorThief();


// function creatAuto() {
//     return setInterval(function () {
//         img_index++;
//         refresh()
//         document.getElementById('radio' + img_index).checked = true;
//     }, 5000)
// }
// let autoTimer = creatAuto()

// function refresh() {
//     if (img_index > 3) {
//         img_index = 0;
//     } else if (img_index < 0) {
//         img_index = 3;
//     }


//     let slideshow = document.querySelector(".slideshow");
//     let width = getComputedStyle(slideshow).width;
//     // width.slice(0, -2) 刪除了寬度字符串中的最後兩個字符（通常是 px），返回純數字部分的字符串。
//     width = Number(width.slice(0, -2));

//     let container_slideshow = document.querySelector(".container_slideshow");
//     container_slideshow.style.left = img_index * width * -1 + "px";

//     //---------------------------------------------------
//     // 抓圖片主要顏色
//     let currentImage = slideshow_images[img_index]
//     let dominantColor = colorThief.getColor(currentImage);

//     loadImage(currentImage, function(){
//         let dominantColor = colorThief.getColor(currentImage);
//         let rgbColor = `rgb(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]})`;
//         // BGC.style.backgroundColor = rgbColor;
//         BGC.css("backgroundColor",rgbColor);
//     });
//     //---------------------------------------------------


//     // 重新計算秒數
//     clearInterval(autoTimer)
//     autoTimer = creatAuto()
// }


// //---------------------------------------------------
// // 確保圖片加載後，才抓顏色
// function loadImage(slideshow_images, callback){
//     if (slideshow_images.complete){
//         callback();
//     }else{
//         slideshow_images.addEventListener("load", callback);
//     }
// }
// //---------------------------------------------------


// //初始執行
// refresh();

// let btn_left = document.getElementById("btn_left")
// let btn_right = document.getElementById("btn_right")
// let radio0 = document.getElementById("radio0")
// let radio1 = document.getElementById("radio1")
// let radio2 = document.getElementById("radio2")
// let radio3 = document.getElementById("radio3")


// btn_left.addEventListener('click', function () {
//     img_index--;
//     refresh()
//     document.getElementById('radio' + img_index).checked = true;
// });
// btn_right.addEventListener('click', function () {
//     img_index++;
//     refresh()
//     document.getElementById('radio' + img_index).checked = true;
// });
// radio0.addEventListener('click', function () {
//     img_index = 0;
//     refresh()
// });
// radio1.addEventListener('click', function () {
//     img_index = 1;
//     refresh()
// });
// radio2.addEventListener('click', function () {
//     img_index = 2;
//     refresh()
// });
// radio3.addEventListener('click', function () {
//     img_index = 3;
//     refresh()
// });