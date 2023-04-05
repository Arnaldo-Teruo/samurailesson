<?php
/**
 * セッションスタート
 */
session_start();


/**
 * フォーム入力ページからのセッションデータが無い場合はフォーム入力ページにリダイレクト
 * リクエスト方法が POST でない場合はフォーム入力ページにリダイレクト（このページの「送信する」ボタンを押したかどうか）
 */
if( !isset($_SESSION['form']) || !$_SERVER['REQUEST_METHOD'] === 'POST' ){
  header('Location: index.php');
  exit;
}


/**
 * セッション内のフォームデータを $post に代入
 */
$post = $_SESSION['form'];


/**
 * メール送信ライブラリの「PHP Mailer」の読み込み
 */
require('vendor/autoload.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


/**
 * 送信元アドレス設定
 */
$fromAddress = "samurailesson@mail.com";


/**
 * 送信元名設定
 */
$fromName = "テスト送信者";


/**
 * SMTPサーバーのホスト（URL）
 */
$mailHost = 'sandbox.smtp.mailtrap.io';

/**
 * SMTPサーバーのユーザー名
 */
$mailUsername = '91f2c4c79f32fc';


/**
 * SMTPサーバーのパスワード
 */
$mailPassword = 'de0448e1778d35';


/**
 * SMTPの認証機能設定（ true or false ）
 */
$mailSmtpAuth = true;


/**
 * 暗号化プロトコル指定（tls or ssl）無効の場合はfalseにする
 */
$mailSmtpSecure = 'tls';

/**
 * TCPポートを指定（465や587、SMTPサーバーによりけり）
 */
$mailPort = 2525;


/**
 * フォーム送信内容
 */
$input = <<<EOT
お名前： {$post['yourName']}
メールアドレス： {$post['email']}
内容：
{$post['memo']}
EOT;


/**
 * 「PHP Mailer」でのメール送信処理
 */


/**
 * メール送信エラー配列初期設定
 */
$sendErrors = [];


/**
 * メース送信時の言語設定
 */
mb_language('uni');
mb_internal_encoding('UTF-8');


/**
 * ユーザー用メール送信インスタンス作成
 */
$mail = new PHPMailer(true);


/**
 * 文字コード設定
 */
$mail->CharSet = 'utf-8';


/**
 * ユーザー用メール本文設定
 */
$body = <<<EOT
お問い合わせありがとうございます。
以下のように承りました。

---

{$input}
EOT;


/**
 * try-catch文でメール送信処理する（try でエラーが起こると catch に処理が飛ぶ）
 */
try {
  $mail->isSMTP(); // SMTPの使用宣言
  $mail->Host       = $mailHost; // SMTPサーバーを指定
  $mail->SMTPAuth   = $mailSmtpAuth; // SMTPの認証機能を指定
  $mail->Username   = $mailUsername; // SMTPサーバーのユーザ名
  $mail->Password   = $mailPassword; // SMTPサーバーのパスワード
  $mail->SMTPSecure = $mailSmtpSecure; // 暗号化プロトコルを指定
  $mail->Port       = $mailPort; // TCPポートを指定
  $mail->setFrom($fromAddress, $fromName); // 送信者
  $mail->addAddress($post['email'], $post['yourName']);   // 宛先
  // $mail->addReplyTo('replay@example.com', 'お問い合わせ'); // 返信先
  // $mail->addCC('cc@example.com', '受信者名'); // CC宛先
  // $mail->addBCC('bcc@sample.com');
  // $mail->Sender = 'return@example.com'; // Return-path
  $mail->Subject = "お問い合わせありがとうございます";
  $mail->Body    = $body;
  $mail->send();
  unset($_SESSION['form']);
  header("Location: thanks.html");
} catch (Exception $e) {
  $_SESSION['error'] = $mail->ErrorInfo;
  $sendErrors['user'] = $mail->ErrorInfo;
  unset($_SESSION['form']);
}


/**
 * 管理者用メール送信インスタンス作成
 */
$mail = new PHPMailer(true);


/**
 * 文字コード設定
 */
$mail->CharSet = 'utf-8';


/**
 * 管理者用メール本文設定
 */
$body = <<<EOT
お問い合わせ連絡です。
以下が送信内容です。

---

{$input}
EOT;


/**
 * try-catch文でメール送信処理する（try でエラーが起こると catch に処理が飛ぶ）
 */
try {
  $mail->isSMTP(); // SMTPの使用宣言
  $mail->Host       = $mailHost; // SMTPサーバーを指定
  $mail->SMTPAuth   = $mailSmtpAuth; // SMTPの認証機能を指定
  $mail->Username   = $mailUsername; // SMTPサーバーのユーザ名
  $mail->Password   = $mailPassword; // SMTPサーバーのパスワード
  $mail->SMTPSecure = $mailSmtpSecure; // 暗号化プロトコルを指定
  $mail->Port       = $mailPort; // TCPポートを指定
  $mail->setFrom($fromAddress, $fromName); // 送信者
  $mail->addAddress("kyan@ryukyuhub.co.jp", "テスト管理者");   // 宛先
  // $mail->addReplyTo('replay@example.com', 'お問い合わせ'); // 返信先
  // $mail->addCC('cc@example.com', '受信者名'); // CC宛先
  // $mail->addBCC('bcc@sample.com');
  // $mail->Sender = 'return@example.com'; // Return-path
  $mail->Subject = "お問い合わせ報告";
  $mail->Body    = $body;
  $mail->send();
} catch (Exception $e) {
  $sendErrors['admin'] = $mail->ErrorInfo;
}


/**
 * ユーザーへのメール送信エラーがあった場合はエラーページへ飛ばす
 */
if ( isset($sendErrors["user"]) ) {
  header("Location: error.php");
  exit;
}


/**
 * ユーザーへのメール送信エラーが無かった場合はサンクスページへ飛ばす
 */
header("Location: thanks.html");
exit;