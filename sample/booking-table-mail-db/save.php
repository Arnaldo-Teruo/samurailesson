<?php
/**
 * セッションスタート
 */
session_start();

/**
 * セッションにフォームデータがあれば代入して無ければ空配列を代入
 */
$post = isset($_SESSION['form']) ? $_SESSION['form'] : [];

/**
 * セッション内の各フォームデータを変数として初期化
 */
$year      = !empty($post['selectYear']) ? $post['selectYear'] : "";
$month     = !empty($post['selectMonth']) ? $post['selectMonth'] : "";
$day       = !empty($post['selectDay']) ? $post['selectDay'] : "";
$thisDay   = $year . "年" . $month . "月" . $day . "日";
$title     = !empty($post['plan']) ? $post['plan'] : "";
$startTime = !empty($post['startTime']) ? $post['startTime'] : "";
$endTime   = !empty($post['endTime']) ? $post['endTime'] : "";
$name      = !empty($post['name']) ? $post['name'] : "";
$email     = !empty($post['email']) ? $post['email'] : "";
$memo      = !empty($post['memo']) ? $post['memo'] : "";
$memoBr    = nl2br($memo);
$desc      = $title . PHP_EOL . $name . PHP_EOL . $email;
if ( !empty($memo) ) {
  $desc .= PHP_EOL . $memo;
}
require_once 'functions.php';

/**
 * Googleカレンダーに登録する
 */
$event = insert_google_calendar_event($title, $desc, $year, $month, $day, $startTime, $endTime);

/**
 * Googleカレンダーへの登録に失敗したらエラーページへ飛ばす
 */
if (!$event) {
  $url = 'error-reservation.php';
  header('Location: ' . $url, true, 307);
  exit;
}

/**
 * メール送信ライブラリ「PHP Mailer」の読み込み
 */
require('vendor/autoload.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/**
 * 送信元アドレス設定
 */
$fromAddress = "samurailesson@rhb.candypop.jp";

/**
 * 送信元名設定
 */
$fromName = $appTitle;

/**
 * SMTPサーバーのホスト（URL）
 */
$mailHost = 'smtp.lolipop.jp';

/**
 * SMTPサーバーのユーザー名
 */
$mailUsername = 'samurailesson@rhb.candypop.jp';

/**
 * SMTPサーバーのパスワード
 */
$mailPassword = 'WSJh4p7U-TXPpr2';

/**
 * SMTPの認証機能設定（ true or false ）
 */
$mailSmtpAuth = true;

/**
 * 暗号化プロトコル指定（tls or ssl）無効の場合はfalseにする
 */
$mailSmtpSecure = 'ssl';

/**
 * TCPポートを指定（465や587、SMTPサーバーによりけり）
 */
$mailPort = 465;

/**
 * フォーム送信内容
 */
$input = <<<EOT
メニュー： {$title}
日時： {$thisDay} {$startTime}～{$endTime}
お名前： {$name}
メールアドレス： {$email}
備考：
{$memo}
EOT;


/**
 * 「PHP Mailer」でのメール送信処理
 */


/**
 * メール送信エラー配列初期設定
 */
$sendErrors = [];


/**
 * メール送信時の言語設定
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
ご予約ありがとうございます！
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
  $mail->addAddress($email, $name);   // 宛先
  // $mail->addReplyTo('replay@example.com', 'お問い合わせ'); // 返信先
  // $mail->addCC('cc@example.com', '受信者名'); // CC宛先
  // $mail->addBCC('bcc@sample.com');
  // $mail->Sender = 'return@example.com'; // Return-path
  $mail->Subject = "ご予約ありがとうございます";
  $mail->Body    = $body;
  $mail->send();
} catch (Exception $e) {
  $_SESSION['error'] = $mail->ErrorInfo;
  $sendErrors['user'] = $mail->ErrorInfo;
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
ご予約入りました。
以下が予約内容です。

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
  $mail->addAddress("kyan@ryukyuhub.co.jp", $appTitle);   // 宛先
  // $mail->addReplyTo('replay@example.com', 'お問い合わせ'); // 返信先
  // $mail->addCC('cc@example.com', '受信者名'); // CC宛先
  // $mail->addBCC('bcc@sample.com');
  // $mail->Sender = 'return@example.com'; // Return-path
  $mail->Subject = "ご予約報告";
  $mail->Body    = $body;
  $mail->send();
} catch (Exception $e) {
  $_SESSION['error'] = $mail->ErrorInfo;
  $sendErrors['admin'] = $mail->ErrorInfo;
}

/**
 * エラーを変数にセット
 */
$error_db = '';
if (count($sendErrors) > 0) {
  foreach ($sendErrors as $k => $v) {
    $error_db .= $v;
    if ($k != array_key_last($sendErrors)) {
      $error_db .= PHP_EOL;
    }
  }
}

/**
 * データベースへ顧客情報登録
 */
try {
  // データベース接続
  $pdo = db_connect();

  // お名前とメールアドレスが同じユーザーが既に登録されていたらリピーターとみなし利用回数（count）を＋１する
  $stmt = $pdo->prepare('SELECT * FROM users WHERE name = :name AND email = :email');
  $stmt->bindValue(':name', $name);
  $stmt->bindValue(':email', $email);
  $stmt->execute();
  $items = $stmt->fetchAll(PDO::FETCH_ASSOC); // セレクト結果を配列として取得
  if ($items) { // 配列が存在している場合、つまり、既に登録がある場合
    // エラー処理
    if ($error_db) { // 今回エラーがあった場合
      if ($items[0]['error']) { // 前回のエラーがあった場合は合わせて登録する
        $error_db = $items[0]['error'] . PHP_EOL . PHP_EOL . date('Y-m-d H:i:s') . PHP_EOL . $error_db;
      }else{ // 今回はエラーがあって、前回はエラーがない場合は日付と共に登録する
        $error_db = date('Y-m-d H:i:s') . PHP_EOL . $error_db;
      }
    }else{ // 今回エラーが無い場合
      $error_db = $items[0]['error']; // 前回のエラーをセットする
    }
    // 備考処理
    if ($memo) { // 今回備考があった場合
      if ($items[0]['memo']) { // 前回の備考があった場合は合わせて登録する
        $memo = $items[0]['memo'] . PHP_EOL . PHP_EOL . date('Y-m-d H:i:s') . PHP_EOL . $memo;
      }else{ // 今回は備考があって、前回は備考がない場合は日付と共に登録する
        $memo = date('Y-m-d H:i:s') . PHP_EOL . $memo;
      }
    }else{ // 今回備考が無い場合
      $memo = $items[0]['memo']; // 前回の備考をセットする
    }
    $stmt = $pdo->prepare('UPDATE users SET count = :count, error = :error, memo = :memo, updated_at = :updated_at WHERE id = :id');
    $stmt->bindValue(':count', ++$items[0]['count']);
    $stmt->bindValue(':error', $error_db);
    $stmt->bindValue(':memo', $memo);
    $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
    $stmt->bindValue(':id', $items[0]['id']);
    $stmt->execute();
  }else{ // リピーターでない場合は新規登録
    $stmt = $pdo->prepare('INSERT INTO users (name, email, error, memo) VALUES(:name, :email, :error, :memo)');
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':error', $error_db);
    $stmt->bindValue(':memo', $memo);
    $stmt->execute();
  }
} catch (PDOException $e) {
  // エラー発生
  echo $e->getMessage();
} finally {
  // DB接続を閉じる
  $pdo = null;
}

/**
 * ユーザーへのメール送信エラーがあった場合はエラーページへ飛ばす
 */
if ( isset($sendErrors['user']) ) {
  header("Location: error-reservation.php");
  exit;
}

/**
 * サンクスページへ
 */
$url = 'thanks.php';
header('Location: ' . $url, true, 307);
exit;
?>