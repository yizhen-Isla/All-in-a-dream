<?php
require_once("../PHP/connMysql.php");
session_start();

//檢查是否經過登入，若有登入則重新導向
if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"]!="")){
	//若帳號等級為 member 則導向會員中心
	if($_SESSION["loginLevel"] == "member"){
		header("Location: member_information.php");
	//否則則導向管理中心
	}else{
		header("Location: member_admin.php");	
	}
}
?>


<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS樣式載入 -->
    <link rel="stylesheet" href="../CSS/forget_pwd.css">
    <!-- 思源黑體 -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
   
    <div class="header_bg">
        <div class="header">
            <h1 class="left">
                <a href="../index.html">
                    <img src="../image/夢裡都有icon_gb.png" alt="" 夢裡都有icon class="img_logo">
                </a>
            </h1>
            <a href="../index.html" class="right"><i class="fa-solid fa-caret-right"></i> 返回至 夢裡都有 首頁</a>
        </div>
    </div>
    <div class="topstyle"></div>
    <div class="layout-center">
        <div class="login">
            <form method="post" action="../PHP/SendEmail_code.php">
                <h1 id="title">忘記密碼？</h1>
                <p class="illustrate">請輸入您申請帳號的電子郵件，系統將會自動產生一個十位數的密碼當作您最新的密碼，寄至您註冊的信箱中，請您以那組密碼進行登入後<br>，再修改成你想要設定的密碼。</p>
                <div class="account_container">
                    <label for="input_send_email" class="label_send_email">電子郵件：</label>
                    <input type="email" name="m_email" id="input_send_email">
                </div>
                <div class="submit_group">
                    <input type="submit" id="btn_send_pwd" name="btn_send_pwd" value="重置密碼並寄密碼信">
                </div>
                <hr>
                <div class="btn_group">
                    <input type="button" class="btn" id="btn_login" value="登入介面">
                    <input type="button" class="btn" id="btn_register" value="註冊介面">
                </div>
            </form>
        </div>
    </div>
    <!-- 匯入jquery -->
    <script src="../JS/jquery.min.js"></script>
    <!-- 載入Sweetalert插件 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 跳轉其他頁面按鈕
        $(document).ready(function() {
            // 按註冊按鈕跳至註冊網站
            $('#btn_login').click(function() {
                event.preventDefault(); // 阻止按鈕的預設行為 (如表單提交)
                window.location.href = 'login.php';
            });
            $('#btn_register').click(function() {
                event.preventDefault(); // 阻止按鈕的預設行為 (如表單提交)
                window.location.href = 'register.php';
            });
        });

        // 補寄密碼信 寄出成功
        <?php if(isset($_GET["mailStats"]) && ($_GET["mailStats"]=="1")){?>
            Swal.fire({
            title: "忘記密碼通知信已寄出!",   //alert 標題
            text: '系統已發送新密碼至您申請的信箱中，請使用新密碼登入並修改密碼。',       //alert 內容
            icon: "success"          //alert icon
            });
            // window.location.href='index.php';
        <?php }?>
        <?php if(isset($_GET["mailStats"]) && ($_GET["mailStats"]=="0")){?>
            Swal.fire({
            title: "錯誤!",   //alert 標題
            text: '忘記密碼通知信-寄信失敗',       //alert 內容
            icon: "error"          //alert icon
            });
        <?php }?>
    </script>
</body>
</html>