// 更新個人資料
$("#btn_change_info").on(click,function(){
    if(check_info()){
        // 驗證成功後提交表單
        $("#update_form").submit(); 
    };
});

// 更新密碼
$("#btn_change_pwd").on(click,function(){
    if(check_pwd()){
        // 驗證成功後提交表單
        $("#update_form").submit(); 
    };
});

// ----------------------------------------------


// 確認個人資料 function
function check_info(){

}

// 確認密碼 function
function check_pwd(pw1, pw2) {
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

function verify_name(){
    if ($("#input_Name").val() == "") {
        alert("請輸入姓名!");
        return false;
    }
}
function verify_sex(){
    if ($("#input_sex").val() == "") {
        alert("請選擇性別!");
        return false;
    }
}
function verify_birthday(){
    if ($("#input_birthday").val() == "") {
        alert("請輸入生日!");
        return false;
    }


    var birthday = $('#birthday').val();

    if (validateBirthday(birthday)) {
        alert("生日格式正確且有效!");
    } else {
        alert("生日格式錯誤或日期無效，請使用YYYY-MM-DD格式!");
    }
    // 驗證生日格式和有效性
    function validateBirthday(birthday) {
        // 正則表達式驗證格式 YYYY-MM-DD
        var pattern = /^\d{4}-\d{2}-\d{2}$/;

        if (pattern.test(birthday)) {
            // 將生日拆解為 年、月、日
            var parts = birthday.split("-");
            var year = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10);
            var day = parseInt(parts[2], 10);

            // 使用 JavaScript 的 Date 對象檢查日期有效性
            var date = new Date(year, month - 1, day);  // month 在 Date 中是 0-based
            if (date.getFullYear() === year && date.getMonth() === month - 1 && date.getDate() === day) {
                return true; // 日期有效
            } else {
                return false; // 日期格式正確，但日期無效
            }
        } else {
            return false;  // 格式錯誤
        }
    }
}
function verify_phone(){

}
function verify_address(){

}



function checkForm() {
    // 姓名欄位確認
    if ($("#input_Name").val() == "") {
        $(".warn_name").removeClass("x");
        $(".success_name").addClass("x");
        $("#input_Name").focus();
        return false;
    } else {
        $(".warn_name").addClass("x");
        $(".success_name").removeClass("x");
    }


    // 生日欄位確認-在Birthday.js
    // 表單提交前，先將生日組合成字串 (年/月/日)

    let year = $('#year').val();
    let month = $('#month').val();
    let day = $('#day').val();

    // 檢查是否所有選項都被選擇
    if (year === "" || month === "" || day === "") {
        $(".warn_birthday").removeClass("x");
        $(".success_birthday").addClass("x");
        return false; // 防止表單提交
    } else {
        $(".warn_birthday").addClass("x");
        $(".success_birthday").removeClass("x");
    }
    let birthday = year + '-' + month + '-' + day;
    $("#m_birthday").val(birthday);




    // Email欄位確認
    if ($("#input_Email").val() == "") {
        $(".warn_text_Email").text("請輸入您的 Email!");
        $(".warn_Email").removeClass("x");
        $(".success_Email").addClass("x");
        $("#input_Email").focus();
        return false;
    } else if (!checkmail($("#input_Email"))) {
        $("#input_Email").focus();
        return false;
    } else {
        $(".warn_Email").addClass("x");
        $(".success_Email").removeClass("x");
    }


    // 設定密碼欄位 與 密碼確認欄位 確認
    if (!check_passwd($("#input_Pwd").val(), $("#input_checkPwd").val())) {
        $("#input_Pwd").focus();
        return false;
    }


    return confirm('確定送出嗎？');

}



// 確認電郵 function
function checkmail(myEmail) {
    let filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (filter.test($(myEmail).val())) {
        return true;
    } else {
        $(".warn_text_Email").text("電子郵件格式不正確!");
        $(".warn_Email").removeClass("x");
        $(".success_Email").addClass("x");
        return false;
    }
}





