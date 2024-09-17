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



// 確認密碼 function
function check_passwd(pw1, pw2) {
    if (pw1 == '') {
        $(".warn_text_pwd").text("密碼不可以空白!");
        $(".warn_pwd").removeClass("x");
        $(".success_pwd").addClass("x");
        return false;
    } else {
        $(".warn_pwd").addClass("x");
        $(".success_pwd").removeClass("x");
    }


    if (/[\s\"]/.test(pw1)) {
        $(".warn_text_pwd").text("密碼不可以含有空白或雙引號!");
        $(".warn_pwd").removeClass("x");
        $(".success_pwd").addClass("x");
        return false;
    } else {
        $(".warn_pwd").addClass("x");
        $(".success_pwd").removeClass("x");
    }


    if (pw1.length < 8 || pw1.length > 16) {
        $(".warn_text_pwd").text("密碼長度只能 8 到 16 個字母!");
        $(".warn_pwd").removeClass("x");
        $(".success_pwd").addClass("x");
        return false;
    } else {
        $(".warn_pwd").addClass("x");
        $(".success_pwd").removeClass("x");
    }


    let hasUppercase = /[A-Z]/.test(pw1);
    let hasLowercase = /[a-z]/.test(pw1);
    let hasSpecialChar = /[0-9]/.test(pw1);

    if (!hasUppercase) {
        $(".warn_text_pwd").text("密碼必須包含至少一個大寫字母");
        $(".warn_pwd").removeClass("x");
        $(".success_pwd").addClass("x");
        return false;
    } else {
        $(".warn_pwd").addClass("x");
        $(".success_pwd").removeClass("x");
    }
    if (!hasLowercase) {
        $(".warn_text_pwd").text("密碼必須包含至少一個小寫字母");
        $(".warn_pwd").removeClass("x");
        $(".success_pwd").addClass("x");
        return false;
    } else {
        $(".warn_pwd").addClass("x");
        $(".success_pwd").removeClass("x");
    }
    if (!hasSpecialChar) {
        $(".warn_text_pwd").text("密碼必須包含至少一個數字");
        $(".warn_pwd").removeClass("x");
        $(".success_pwd").addClass("x");
        return false;
    } else {
        $(".warn_pwd").addClass("x");
        $(".success_pwd").removeClass("x");
    }

    if (pw2 == '') {
        $(".warn_text_checkpwd").text("確認密碼欄位不可空白!");
        $(".warn_checkpwd").removeClass("x");
        $(".success_checkpwd").addClass("x");
        return false;
    } else if (pw1 != pw2) {
        $(".warn_text_checkpwd").text("密碼與確認密碼不匹配，請重新輸入!");
        $(".warn_checkpwd").removeClass("x");
        $(".success_checkpwd").addClass("x");
        return false;
    } else {
        $(".warn_checkpwd").addClass("x");
        $(".success_checkpwd").removeClass("x");
    }

    return true;
}

