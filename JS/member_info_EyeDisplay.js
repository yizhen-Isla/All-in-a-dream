
// 眼睛開 fa-eye
// 眼睛關 fa-eye-slash

// 密碼輸入 眼睛控制
$("#newpwd_eye_control").click(function(){
    $(this).toggleClass("fa-eye").toggleClass("fa-eye-slash")
    if($(this).hasClass("fa-eye")){
        $("#newpwd").attr("type","text")
        
    }else if($(this).hasClass("fa-eye-slash")){
        $("#newpwd").attr("type","password")
    };
});
// 密碼確認 眼睛控制
$("#pwdcheck_eye_control").click(function(){
    $(this).toggleClass("fa-eye").toggleClass("fa-eye-slash")
    if($(this).hasClass("fa-eye")){
        $("#pwdcheck").attr("type","text")
        
    }else if($(this).hasClass("fa-eye-slash")){
        $("#pwdcheck").attr("type","password")
    };
});


