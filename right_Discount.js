
let selectedRadio_id = document.querySelector('input[name="panel-radio"]:checked').id;
let radios = document.querySelectorAll('input[name="panel-radio"]')
let contents = document.querySelectorAll('.content');


function showContent() {
    contents.forEach(content => content.style.display = 'none'); //先把所有content隱藏起來
    index = selectedRadio_id.slice(-1); //取選擇的radio的index
    let contentToShow = document.querySelector(`.content.content${index}`);
    contentToShow.style.display = 'block'; //將選擇的content開啟
}

// 初始化顯示內容
showContent();

// 如果radios有變化就執行
radios.forEach(radio => {
    radio.addEventListener('change', function () {
        selectedRadio_id = radio.id
        showContent();
    });
});

    


