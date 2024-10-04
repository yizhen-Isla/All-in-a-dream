// 更新個人資料
$("#btn_change_info").on("click",function(){
    if(check_info()){
        let sex = $("input[name='radio_btn_sex']:checked").val();
        $("#choose_sex").val(sex)
        if(confirm('確定更新個人資料嗎？')){
            // 驗證成功後提交表單
        $("#update_form").append('<input type="hidden" name="update_info" value="true">'); // 添加 hidden 字段
        $("#update_form").submit(); 
        };
    };
    
});

// 更新密碼
$("#btn_change_pwd").on("click",function(){
    if(check_pwd($("#input_newpwd").val(), $("#input_pwdcheck").val())){
        if(confirm('確定更新密碼嗎？')){
            // 驗證成功後提交表單
            $("#update_form").append('<input type="hidden" name="update_pwd" value="true">'); // 添加 hidden 字段
        $("#update_form").submit(); 
        };
    };
});

// ----------------------------------------------


// 確認個人資料 function
function check_info(){
    //姓名
    if ($("#input_name").val() == "") {
        alert("請輸入姓名!");
        return false;
    }
    //性別
    let sex = $("input[name='radio_btn_sex']:checked").val();
    if (sex == "" || sex == undefined) {
        alert("請選擇性別!");
        return false;
    }
    
    //生日
    var birthday = $('#input_birthday').val();
    if (birthday == "") {
        alert("請輸入生日!");
        return false;
    }
    if (!verify_birthday(birthday)) {
        alert("生日格式錯誤或日期無效，請使用YYYY-MM-DD格式!");
        return false;
    }
    //電話
    var phone = $('#input_phone').val();
    if ($("#input_phone").val() == "") {
        alert("請輸入電話號碼!");
        return false;
    }else if(!verify_phone(phone)) {
        alert("電話號碼需填寫10個數字!");
        return false;
    }
    //地址
    if ($("#input_address").val() == "") {
        alert("請輸入地址!");
        return false;
    }
    return true;
}

// 確認密碼 function
function check_pwd(pw1, pw2) {
    console.log(pw1);
    console.log(pw2);

    if (pw1 == '') {
        alert("密碼不可以空白!");
        return false;
    } 

    if (/[\s\"]/.test(pw1)) {
        alert("密碼不可以含有空白或雙引號!");
        return false;
    } 

    if (pw1.length < 8 || pw1.length > 16) {
        alert("密碼長度只能 8 到 16 個字母!");
        return false;
    }

    let hasUppercase = /[A-Z]/.test(pw1);
    let hasLowercase = /[a-z]/.test(pw1);
    let hasSpecialChar = /[0-9]/.test(pw1);

    if (!hasUppercase) {
        alert("密碼必須包含至少一個大寫字母");
        return false;
    } 
    if (!hasLowercase) {
        alert("密碼必須包含至少一個小寫字母");
        return false;
    } 
    if (!hasSpecialChar) {
        alert("密碼必須包含至少一個數字");
        return false;
    } 

    if (pw2 == '') {
        alert("確認密碼欄位不可空白!");
        return false;
    } else if (pw1 != pw2) {
        alert("密碼與確認密碼不匹配，請重新輸入!");
        return false;
    } 

    return true;
}

// ----------------------------------------------


function verify_birthday(birthday){
    // 正則表達式驗證格式 YYYY-MM-DD
    var pattern = /^\d{4}-\d{2}-\d{2}$/;
    if (pattern.test(birthday)) {
        // 將生日拆解為 年、月、日
        var parts = birthday.split("-");
        var year = parseInt(parts[0], 10); //10代表十進制
        var month = parseInt(parts[1], 10);
        var day = parseInt(parts[2], 10);

        // 使用 JavaScript 的 Date 對象檢查日期有效性
        var date = new Date(year, month - 1, day);  // month 在 Date 中，0 代表 1 月，11 代表 12 月。
        if (date.getFullYear() === year && date.getMonth() === month - 1 && date.getDate() === day) {
            return true; // 日期有效
        } else {
            return false; // 日期格式正確，但日期無效
        }
    } else {
        return false;  // 格式錯誤
    }

}

function verify_phone(phone){
    var pattern = /^\d{10}$/;
    if (pattern.test(phone)) {
        return true;
    }else{
        return false;
    }
}


    





