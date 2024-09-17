<?php
// 接受外部資料，先進行輸入過濾、輸出轉義
function GetSQLValueString($theValue, $theType)
{
    switch ($theType) {
        case "string":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_ADD_SLASHES) : ""; // FILTER_SANITIZE_ADD_SLASHES 在特殊字元之前添加反斜線
            break;
        case "int":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) : ""; // FILTER_SANITIZE_NUMBER_INT 移除所有非數字字元，除了正負號和數字
            break;
        case "email":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_EMAIL) : ""; //FILTER_VALIDATE_EMAIL 驗證一個字串是否是有效的電子郵件地址
            break;
    }
    return $theValue;
}

if (isset($_POST["action"]) && ($_POST["action"] == "join")) {

    // [引入資料庫]
    require_once("../PHP/connMysql.php");

    // [找尋帳號是否已經註冊]
    // $query_RecFindUser = SQL 尋找語法
    $query_RecFindUser = "SELECT m_email FROM memberdata WHERE m_email='{$_POST["m_email"]}'";
    // 進行查詢，變數 $RecFindUser 會儲存查詢結果。
    $RecFindUser = $db_link->query($query_RecFindUser);


    if ($RecFindUser->num_rows > 0) {
        // >0 表示該電子郵件已經存在於資料庫中，重導該網頁 (錯誤訊息errMsg=1)
        header("Location: register.php?errMsg=1&username={$_POST["m_email"]}");
    } else {
        // [如果電子郵件不存在，則新增使用者資料]
        // $query_insert = SQL語法，插入一筆新的使用者資料
        $query_insert = "INSERT INTO memberdata (m_name, m_passwd, m_sex, m_birthday, m_email, m_phone, m_address, m_jointime) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $db_link->prepare($query_insert); // 創建預處理語句
        //綁定參數，都為string
        $stmt->bind_param(
            "sssssss",
            GetSQLValueString($_POST["m_name"], 'string'),
            GetSQLValueString($_POST["m_email"], 'email'),
            password_hash($_POST["m_passwd"], PASSWORD_DEFAULT),  // 密碼加密
            GetSQLValueString($_POST["m_sex"], 'string'),
            GetSQLValueString($_POST["m_birthday"], 'string'),
            GetSQLValueString($_POST["m_phone"], 'string'),
            GetSQLValueString($_POST["m_address"], 'string')
        );
        $stmt->execute();  // 執行預處理
        $stmt->close();  // 關閉預處理
        $db_link->close(); // 關閉資料庫連線
        header("Location: register.php?loginStats=1"); //成功註冊訊息loginStats=1
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/register.css">
    <!-- icon ->  fontawesome -->
    <script src="https://kit.fontawesome.com/a9eb98558e.js" crossorigin="anonymous"></script>
</head>


<body>
    <?php if (isset($_GET["loginStats"]) && ($_GET["loginStats"] == "1")) { ?>
        <script language="javascript">
            alert('會員新增成功\n請用申請的帳號密碼登入。');
            // 註冊成功導向頁面
            window.location.href = 'login.php';
        </script>
    <?php } ?>

    <div class="header_bg">
        <div class="header">
            <h1 class="left">
                <a href="../index.html">
                    <img src="../image/夢裡都有icon_gb.png" alt="" class="img_logo">
                </a>
            </h1>
            <a href="../index.html" class="right"><i class="fa-solid fa-caret-right"></i> 返回至 夢裡都有 首頁</a>
        </div>
    </div>
    <div class="topstyle"></div>
    <div class="layout-center">
        <div class="register">
            <form method="POST" action="" id="formJoin" onSubmit="return checkForm();">
                <h1 id="title">會員註冊</h1>
                <div class="Have_an_account">
                    <div class="Have_an_account_column">
                        <p>已經擁有 夢裡都有購物帳號嗎？</p>
                        <a href="login.php" class="tologin">立即登入</a>
                    </div>
                    <div class="errDiv">
                        <?php if (isset($_GET["errMsg"]) && ($_GET["errMsg"] == "1")) { ?>
                            <?php echo $_GET["username"]; ?> 已被註冊過！
                        <?php } ?>
                    </div>
                </div>
                <div class="information">
                    <div class="input_group">
                        <label for="input_Name" class="input_label">姓名：</label>
                        <input type="text" class="input_text" id="input_Name" name="m_name">
                        <div class="blank_area">
                            <div class="success success_name x"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                    </div>
                    <div class="Blank_line">
                        <div class="warn warn_name x">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <label for="input_Name">請輸入姓名！</label>
                        </div>
                    </div>
                    <div class="input_group">
                        <label for="year" class="input_label">生日：</label>
                        <div class="birthday_layout">
                            <select name="year" id="year">
                                <option value="" hidden>西元年</option>
                            </select>
                            <select name="month" id="month">
                                <option value="" hidden>月份</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <select name="day" id="day">
                                <option value="" hidden>日期</option>
                            </select>
                        </div>
                        <div class="blank_area">
                            <div class="success success_birthday x"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                    </div>
                    <div class="Blank_line">
                        <div class="warn warn_birthday x">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <label>請選擇生日的完整的年、月、日！</label>
                        </div>
                    </div>
                    <div class="input_group">
                        <label for="input_Email" class="input_label">Email：</label>
                        <input type="email" class="input_text" id="input_Email" name="m_email">
                        <div class="blank_area">
                            <div class="success success_Email x"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                    </div>
                    <div class="Blank_line">
                        <div class="warn warn_Email x">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <label for="input_Email" class="warn_text_Email">"請輸入您的 Email！"</label>
                        </div>
                    </div>
                    <div class="input_group">
                        <label for="input_Pwd" class="input_label">設定密碼：</label>
                        <input type="text" class="input_text" id="input_Pwd" name="m_passwd">
                        <div class="blank_area">
                            <div class="success success_pwd x"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                    </div>
                    <div class="Blank_line">
                        <div class="warn warn_pwd x">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <label for="input_Pwd" class="warn_text_pwd">請輸入密碼！</label>
                        </div>
                    </div>
                    <div class="input_group">
                        <label for="input_checkPwd" class="input_label">密碼確認：</label>
                        <input type="text" class="input_text" id="input_checkPwd">
                        <div class="blank_area">
                            <div class="success success_checkpwd x"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                    </div>
                    <div class="Blank_line">
                        <div class="warn warn_checkpwd x">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <label for="input_checkPwd" class="warn_text_checkpwd">請再輸入一次密碼！</label>
                        </div>
                    </div>
                </div>
                <!-- 隱藏的輸入欄位，用於儲存組合後的生日 -->
                <input type="hidden" name="m_birthday" id="m_birthday">
                <div class="btn_group">
                    <!-- action 的值來區分當前表單提交的目的是什麼，進而執行不同的邏輯。
                    如果 action 是 "join"，伺服器處理註冊會員的邏輯。
                    如果 action 是 "edit"，伺服器處理修改資料的邏輯。 -->
                    <input name="action" type="hidden" id="action" value="join">
                    <input type="submit" class="btn" id="btn_register" value="立即註冊">
                </div>
            </form>
        </div>
    </div>
    <!-- 匯入jquery -->
    <script src="../JS/jquery.min.js"></script>
    <!-- 生日下拉選單 -->
    <script src="../JS/register_Birthday.js"></script>
    <!-- 輸入表單欄位檢查 -->
    <script src="../JS/register_Format_check.js"></script>
</body>

</html>