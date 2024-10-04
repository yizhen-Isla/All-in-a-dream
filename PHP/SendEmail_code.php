<?php
require_once("connMysql.php");


// [[寄信]]
session_start(); //啟動新會話session
// 引用 PHPMailer 的命名空間
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// PHPMailer 所需的文件位置
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/SMTP.php';


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

//函式：自動產生密碼
function Make_New_Pwd()
{
    $pwd_length = 10;
    $content = "0123456789!@#$%^&*()_+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $new_pwd = "";
    // strlen 計算字串長度
    // .= 將選取的字符加到字串末端的運算符
    // substr 截取字串中的某一部分。
    while (strlen($new_pwd) < $pwd_length) {
        $new_pwd .= substr($content, rand(0, strlen($content)), 1);
    }
    return ($new_pwd);
}


//檢查是否為會員
if (isset($_POST["m_email"])) {
    // 使用者輸入的Email
    $user_input_account = GetSQLValueString($_POST["m_email"], 'string');
    //找尋該會員資料
    $query_RecFindUser = "SELECT * FROM memberdata WHERE m_email='{$user_input_account}'";
    $RecFindUser = $db_link -> query($query_RecFindUser);
    if ($RecFindUser->num_rows == 0) {
        header("Location: ../HTML/forget_pwd.php?errMsg=1&usermail={$user_input_account}");
    } else {
        //取出帳號密碼的值
        $row_RecFindUser = $RecFindUser->fetch_assoc();

        $usermail = $row_RecFindUser["m_email"];
        $username = $row_RecFindUser["m_name"];
        //產生新密碼並更新
        $newpasswd = Make_New_Pwd();
        $Encrypted_pwd = password_hash($newpasswd, PASSWORD_DEFAULT);
        $query_update = "UPDATE memberdata SET m_passwd='{$Encrypted_pwd}' WHERE m_email='{$usermail}'";
        $db_link->query($query_update);
        //補寄密碼信
        send_Newpwd($username, $usermail, $newpasswd);
        
    }
}




function send_Newpwd($username, $usermail, $newpasswd){
    
    $name = $username;
    $email = $usermail;
    $subject = "夢裡都有-會員忘記密碼郵件通知";
    $message = "您最新的密碼為： " . $newpasswd;


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                         //Send using SMTP
        $mail->SMTPAuth   = true;                                //Enable SMTP authentication

        $mail->Host       = 'smtp.gmail.com';                    //Set the SMTP server to send through
        $mail->Username   = 'yi.mailserver@gmail.com';           //SMTP username
        $mail->Password   = 'fsevkadgoupwkrdx';                  //SMTP password

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      //Enable implicit TLS encryption
        $mail->Port       = 587;                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('yi.mailserver@gmail.com', 'All_in_a_dream');         //（寄件者地址與名字）
        $mail->addAddress($_POST["m_email"], $name);     //Add a recipient（收件者地址與名字）

         // 添加內嵌圖片
        $mail->AddEmbeddedImage('../image/夢裡都有icon_gb.png','icon','icon.png');

        //Content
        $mail->CharSet = 'UTF-8'; //確保 UTF-8 編碼
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    =
            '
          <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse; margin: 0 auto;">
                <tr>
                    <td align="center" valign="middle" style= "padding: 20px;">
                        <!-- 主要內容表格 -->
                        <table width="90%" height="80%" border="0" cellspacing="0" cellpadding="0" style="border: 3px solid #524847; border-radius: 15px; background-color: #ffffff;">
                            <tr height="30%">
                                <!-- 圖片和標題 -->
                                <td align="center" valign="top" style="padding-top: 15px;">
                                    <img src="cid:icon" alt="夢裡都有icon" style="width: 160px; height: 50px; margin-bottom: 15px;">
                                    <h1 style="color: #4b745a; font-size: 30px; margin: 0; padding: 0;">會員忘記密碼郵件通知</h1>
                                    <hr style="border: 1px solid #524847d8; width: 90%; margin: 15px 0;">
                                </td>
                            </tr>
                            <tr height="70%">
                                <!-- 內文 -->
                                <td align="center" valign="top" style="padding: 10px 0;">
                                    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="center" valign="top" >
                                                <p style=" font-size: 18px; line-height: 2; color: #524847;">
                                                ' . $name .' 先生/小姐，您好：<br>'.
                                                '您的帳號：'. $email . '<br><br>'
                                                . $message . '<br><br>
                                                請您使用這組新密碼進行登入後，再到會員中心修改密碼。
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- 底部備註 -->
                        <p style="margin-top: 15px; color: #858484; font-size: 12px;">
                            您收到這封電子郵件是因為您於夢裡都有購物網站，點選了忘記密碼，並重置密碼。
                        </p>
                    </td>
                </tr>
            </table>
            ';


        if ($mail->send()) //如果郵件寄出
        {
            // header("Location: ../HTML/login.php"); 
            header("Location: ../HTML/forget_pwd.php?mailStats=1"); 
            exit(0);
        } else {
            header("Location: ../HTML/forget_pwd.php?mailStats=0"); 
            exit(0);
        }
    } catch (Exception $e) { //例外處理
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
};
