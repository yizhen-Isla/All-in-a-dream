<?php
require_once("../PHP/connMysql.php");
session_start();
//檢查是否經過登入
if (!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")) {
    header("Location: login.php"); //沒登入，轉登入畫面
}
//執行登出動作
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
    unset($_SESSION["loginMember"]);
    unset($_SESSION["loginLevel"]);
    header("Location: ../index.html"); //登出，轉首頁
}


// [[跟註冊寫法很像，檢查欄位值，少部分改為更新的程式]]
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

if (isset($_POST["action"]) && ($_POST["action"] == "update")) {
    // [更新]
    if (isset($_POST["update_info"])) {
        $query_update = "UPDATE memberdata SET m_name=?, m_sex=?, m_birthday=?, m_phone=?, m_address=? WHERE m_id=?";
        $stmt = $db_link->prepare($query_update); // 創建預處理語句   
        //綁定參數
        $m_name = GetSQLValueString($_POST["m_name"], 'string');
        $choose_sex = GetSQLValueString($_POST["choose_sex"], 'string');
        $m_birthday = GetSQLValueString($_POST["m_birthday"], 'string');
        $m_phone= GetSQLValueString($_POST["m_phone"], 'string');
        $m_address= GetSQLValueString($_POST["m_address"], 'string');
        $m_id = GetSQLValueString($_POST["m_id"], 'int');
        $stmt->bind_param("sssssi",$m_name,$choose_sex,$m_birthday,$m_phone,$m_address,$m_id);
        $stmt->execute();  // 執行預處理
        $stmt->close();  // 關閉預處理
    } elseif (isset($_POST["update_pwd"])) {
        echo '<pre>';
            print_r($_POST["m_passwd"]);
            print_r($_POST["m_passwdcheck"]);
            echo '</pre>';
        if (($_POST["m_passwd"] != "") && ($_POST["m_passwd"] == $_POST["m_passwdcheck"])) {
            echo '<pre>';
            print_r("進去了");
            echo '</pre>';
            $query_update_pwd = "UPDATE memberdata SET m_passwd=?  WHERE m_id=?";
            $stmt = $db_link->prepare($query_update_pwd); // 創建預處理語句 
            $stmt->bind_param(
                "si",
                password_hash($_POST["m_passwd"], PASSWORD_DEFAULT), // 密碼加密
                GetSQLValueString($_POST["m_id"], 'int')
            );
            $stmt->execute();  // 執行預處理
            $stmt->close();  // 關閉預處理 
            unset($_SESSION["loginMember"]);
            unset($_SESSION["loginLevel"]);
            header("Location: login.php");
        }
    }
}

//登入會員資料
$query_RecMember = "SELECT * FROM memberdata WHERE m_email='{$_SESSION["loginMember"]}'";
$RecMember = $db_link->query($query_RecMember);	
$row_RecMember = $RecMember->fetch_assoc(); //fetch_assoc() 從資料庫查詢結果中取得一行資料

unset($_SESSION["memberLevel"]);
// 測試用
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS樣式載入 -->
    <link rel="stylesheet" href="../CSS/member_information.css">
    <!-- 思源黑體 -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">
    <!-- icon ->  fontawesome -->
    <script src="https://kit.fontawesome.com/a9eb98558e.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- 導覽列 -->
    <div class="initial_header">
        <div class="myNav">
            <div class="leftMenu">
                <a class="leftMenu_a" href="../index.html">
                    <i class="fa-solid fa-house"></i>
                    回首頁
                </a>
            </div>
            <ul class="rightMenu">
                <li class="rightMenu_li"><a href="login.php">登入</a></li>
                <li class="rightMenu_li"><a href="register.php">註冊</a></li>
                <li class="rightMenu_li"><a href="#">會員中心</a></li>
                <li class="rightMenu_li"><a href="#">購物車</a></li>
            </ul>
        </div>
    </div>
    <div class="member_layout">
        <form action="" method="POST" id="update_form" class="member_container">
            <div class="Sign_out">
                <a href="?logout=true" class="Sign_out_btn">
                    登出會員
                </a>
            </div>
            <div class="left_information">
                <label for="" class="member_information">會員資訊</label>
                <div class="input_layout">
                <div class="input_group">
                        <label class="information_title">電子郵件：</label>
                        <p class="account_text"><?php echo $row_RecMember["m_email"];?></p>
                    </div>
                    <div class="input_group">
                        <label for="name" class="information_title">姓名：</label>
                        <input type="text" class="information_text" id="input_name" name="m_name" value="<?php echo $row_RecMember["m_name"];?>">
                    </div>
                    <div class="input_group">
                        <label class="information_title">性別：</label>
                        <div class="sex_container">
                            <div class="female_container">
                                <input type="radio" name="radio_btn_sex" class="sex_radio" id="input_female" name="m_sex" value="Female" <?php if($row_RecMember["m_sex"] == "Female") echo "checked";?>>
                                <label for="female" class="sex_text">女性</label>
                            </div>
                            <div class="male_container">
                                <input type="radio" name="radio_btn_sex" class="sex_radio" id="input_male" name="m_sex" value="Male" <?php if($row_RecMember["m_sex"] == "Male") echo "checked";?>>
                                <label for="male" class="sex_text">男性</label>
                            </div>
                        </div>
                    </div>
                    <div class="input_group">
                        <label for="birthday" class="information_title">生日：</label>
                        <input type="text" class="information_text" id="input_birthday" name="m_birthday" value="<?php echo $row_RecMember["m_birthday"];?>">
                    </div>
                    <div class="input_group">
                        <label for="phone" class="information_title">電話：</label>
                        <input type="text" class="information_text" id="input_phone" name="m_phone" value="<?php echo $row_RecMember["m_phone"];?>">
                    </div>
                    <div class="input_group">
                        <label for="address" class="information_title">地址：</label>
                        <input type="text" class="information_text" id="input_address" name="m_address" value="<?php echo $row_RecMember["m_address"];?>">
                    </div>
                </div>
                <div class="btn_group">
                    <input type="button" id="btn_change_info" class="btn" value="更新資料">
                </div>
            </div>
            <div class="right_information">
                <label for="" class="change_pwd_title">修改登入密碼</label>
                <div class="pwd_group">
                    <label for="newpwd" class="pwd_title">新密碼：</label>
                    <input type="password" class="pwd_text" id="input_newpwd" name="m_passwd">
                    <!-- 眼睛開 fa-eye -->
                    <!-- 眼睛關 fa-eye-slash -->
                    <i id="newpwd_eye_control" class="fa-regular fa-eye-slash"></i>
                </div>
                <div class="pwd_group">
                    <label for="pwdcheck" class="pwd_title">密碼確認：</label>
                    <input type="password" class="pwd_text" id="input_pwdcheck" name="m_passwdcheck">
                    <i id="pwdcheck_eye_control" class="fa-regular fa-eye-slash"></i>
                </div>
                <div class="btn_group_pwd">
                    <input type="button" id="btn_change_pwd" class="btn" value="變更密碼">
                </div>
            </div>
            <input name="action" type="hidden" id="action" value="update">
            <input name="m_id" type="hidden" id="m_id" value="<?php echo $row_RecMember["m_id"];?>">
            <input name="choose_sex" type="hidden"  id="choose_sex" value="">
        </form>
    </div>

    </div>
    </div>

    <!-- 匯入jquery -->
    <script src="../JS/jquery.min.js"></script>
    <!-- member_info眼睛開關-->
    <script src="../JS/member_info_EyeDisplay.js"></script>
    <!-- 表單更新欄位檢查 -->
    <script src="../JS/member_info_Format_Check.js"></script>
</body>

</html>
<?php
$db_link->close(); // 關閉資料庫連線
?>