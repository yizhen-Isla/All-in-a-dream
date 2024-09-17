<?php
    // 資料庫引入
    require_once("connMysql.php");
    // 啟用 session
    session_start();

    // $_SESSION["loginMember"] 用來記錄是否登入帳號
    // $_SESSION["memberLevel"] 紀錄登入者的等級(member、admin)

    // 檢查登入狀態
    if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"] != "")){
        // 帳號為member身份
        if($_SESSION["memberLevel"] == "member"){
            header("Location: ../index.html");
        }else{ // 非member - admin身份
            header("Location: member_admin.php");
        }
    }

    // 執行會員登入
    // 檢查使用者是否透過 POST 方法提交了 "email" 和 "passwd" 兩個表單欄位
    if(isset($_POST["useremail"]) && isset($_POST["userpwd"])){

        // SQL 查詢，用來從資料庫的 member 表中選取 m_username, m_passwd 和 m_level 這三個欄位。
        // 其中 m_username=? 是條件，表示查詢時會過濾出與 m_username 相匹配的那一筆記錄（用戶名）。
        $query_RecLogin = "SELECT m_email, m_passwd, m_level FROM member WHERE m_email=?";

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
        $stmt -> bind_param("s", $_POST["useremail"]);

        // 執行查詢：
        $stmt -> execute();
        
        $stmt -> bind_result($email, $passwd, $level);
        $stmt -> fetch(); // 取出資料
        $stmt -> close();

        // 將資料庫中的密碼與輸入的密碼做對比
        if(password_verify($_POST["userpwd"], $passwd)){
            // 計算登入次數及更新登入時間
            $query_RecLoginUpdate = "UPDATE member SET m_login = m_login + 1, m_logintime = NOW() WHERE m_email=?";
            $stmt = $db_link -> prepare($query_RecLoginUpdate);
            $stmt -> bind_param("s", $email);
            $stmt -> execute();
            $stmt -> close();
            // 設定登入者的名稱及等級
            $_SESSION["loginMember"]= $email;
            $_SESSION["loginLevel"] = $level;
            // 使用Cookie 記錄登入資料
            if(isset($_POST["rememberme"]) && ($_POST["rememberme"] == "true")){
                setcookie("remUser", $_POST["useremail"], time() + 365 *24 *60); // 一年
                setcookie("remPass", $_POST["userpwd"], time() + 365 *24 *60);
            }else{
                if(isset($_COOKIE["remUser"])){ //檢查原本cookie是否存在，存在就去除兩個cookie值
                    setcookie("remUser", $_POST["useremail"], time() - 100);
                    setcookie("remPass", $_POST["userpwd"], time() - 100);
                }
            }
            //為member就導向會員中心
            if($_SESSION["memberLevel"] == "member"){
                header("Location: ../index.php");
            }else{
                header("Location: member_admin.php");
            }
        }else{ //登入失敗就重新載入原頁
            header("Location: login.php?errMsg=1");
        }
    }

?>