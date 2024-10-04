<?php
// 資料庫引入
require_once("../PHP/connMysql.php");
// 啟用 session
session_start();
// $_SESSION["loginMember"] 用來記錄是否登入帳號
// $_SESSION["loginLevel"] 紀錄登入者的等級(member、admin)

// 檢查登入狀態
if (isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"]!= "")) {
    // 帳號為member身份
    if ($_SESSION["loginLevel"] == "member") {
        header("Location: member_information.php");
    } else { // 非member - admin身份
        header("Location: member_admin.php");
    }
}

// 執行會員登入
// 檢查使用者是否透過 POST 方法提交了 "email" 和 "passwd" 兩個表單欄位
if (isset($_POST["useremail"]) && isset($_POST["userpwd"])) {

    // SQL 查詢，用來從資料庫的 member 表中選取 m_username, m_passwd 和 m_level 這三個欄位。
    // 其中 m_username=? 是條件，表示查詢時會過濾出與 m_username 相匹配的那一筆記錄（用戶名）。
    $query_RecLogin = "SELECT m_email, m_passwd, m_level FROM memberdata WHERE m_email=?";

    // 準備 SQL 語句
    // 用來準備一個 SQL 語句，防止 SQL 注入攻擊（避免惡意用戶通過特製的輸入破壞或操控資料庫）。
    // $db_link 是資料庫的連接物件。
    // prepare 方法用來將查詢語句編譯並準備執行。
    $stmt = $db_link -> prepare($query_RecLogin);

    // 綁定參數
    // $stmt -> bind_param("s", $_POST["username"]);
    // 這行代碼用來將使用者提交的 username 參數（用戶名）安全地綁定到 SQL 查詢中的 ?。
    // "s" 代表參數的類型是字串（string）。
    // $_POST["username"] 是實際被綁定的用戶名。
    $stmt->bind_param("s", $_POST["useremail"]);

    // 執行查詢：
    $stmt->execute();

    $stmt->bind_result($email, $passwd, $level);
    $stmt->fetch(); // 取出資料
    $stmt->close();

    // 將資料庫中的密碼與輸入的密碼做對比
    // 密碼解密比對
    if (password_verify($_POST["userpwd"], $passwd)) { 
        // 計算登入次數及更新登入時間
        $query_RecLoginUpdate = "UPDATE memberdata SET m_login = m_login + 1, m_logintime = NOW() WHERE m_email=?";
        $stmt = $db_link -> prepare($query_RecLoginUpdate);
        $stmt -> bind_param("s", $email);
        $stmt -> execute();
        $stmt -> close();
        // 設定登入者的名稱及等級
        $_SESSION["loginMember"] = $email;
        $_SESSION["loginLevel"] = $level;
        // 使用Cookie 記錄登入資料
        if (isset($_POST["rememberme"]) && ($_POST["rememberme"] == "true")) {
            setcookie("remUser", $_POST["useremail"], time() + 365 * 24 * 60); // 一年
            setcookie("remPass", $_POST["userpwd"], time() + 365 * 24 * 60);
        } else {
            if (isset($_COOKIE["remUser"])) { //檢查原本cookie是否存在，存在就去除兩個cookie值
                setcookie("remUser", $_POST["useremail"], time() - 100);
                setcookie("remPass", $_POST["userpwd"], time() - 100);
            }
        }
        //為member就導向會員中心
        if ($_SESSION["loginLevel"] == "member") {
            header("Location: member_information.php");
        } else {
            header("Location: member_admin.php");
        }
    } else { //登入失敗就重新載入原頁
            header("Location: login.php?errMsg=1");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS樣式載入 -->
    <link rel="stylesheet" href="../CSS/login_style.css">
    <!-- 思源黑體 -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">
    <!-- icon ->  fontawesome -->
    <script src="https://kit.fontawesome.com/a9eb98558e.js" crossorigin="anonymous"></script>
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
            <form method="post" action="">
                <h1 id="title">會員登入</h1>
                <?php if (isset($_GET["errMsg"]) && ($_GET["errMsg"] == "1")) { ?>
                    <div class="warn">
                        <p id="test">帳號或密碼錯誤!</p>
                    </div>
                <?php } ?>
                <div class="input_group">
                    <input type="text" name="useremail" id="user_email" class="input_text" placeholder="帳號" value="<?php if (isset($_COOKIE["remUser"]) && ($_COOKIE["remUser"] != "")) echo $_COOKIE["remUser"]; ?>">
                    <label for="user_email" class="input_label">帳號</label>
                </div>
                <div class="input_group">
                    <input type="password" name="userpwd" id="user_password" class="input_text" placeholder="密碼" value="<?php if (isset($_COOKIE["remPass"]) && ($_COOKIE["remPass"] != "")) echo $_COOKIE["remPass"]; ?>">
                    <label for="user_password" class="input_label">密碼</label>
                </div>
                <div class="check_area">
                    <div class="remember">
                        <input type="checkbox" name="rememberme" id="checkbox_remember" class="remember_group" value="true" checked>
                        <label for="checkbox_remember" class="remember_group">記住帳號密碼</label>
                    </div>

                    <a href="forget_pwd.php" class="forget">忘記密碼</a>
                </div>
                <div class="btn_group">
                    <input type="button" class="btn" id="btn_register" value="註冊">
                    <input type="submit" class="btn" id="btn_login" value="登入">
                </div>
            </form>
        </div>
    </div>

    <!-- 匯入jquery -->
    <script src="../JS/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // 按註冊按鈕跳至註冊網站
            $('#btn_register').click(function() {
                event.preventDefault(); // 阻止按鈕的預設行為 (如表單提交)
                window.location.href = 'register.php';
            });
        });
    </script>
</body>

</html>
<?php
$db_link->close();
?>