<?php
$adminMail = "kyan@ryukyuhub.co.jp";
$adminFromName = "予約システム-マッサージ-プロトタイプ";
$adminName = get_bloginfo('name');
$adminSubject = "予約システム-マッサージ-プロトタイプ予約";
$adminMailCc = array();
$adminMailBcc = array();
$customerSubject = "ご予約ありがとうございます";

$my_nonce = wp_verify_nonce( $_POST['reservationField'], 'reservationAction' );
$year = !empty($_POST['selectYear']) ? $_POST['selectYear'] : "";
$month = !empty($_POST['selectMonth']) ? $_POST['selectMonth'] : "";
$day = !empty($_POST['selectDay']) ? $_POST['selectDay'] : "";
$thisDay = $year . "年" . $month . "月" . $day . "日";
$title = !empty($_POST['plan']) ? $_POST['plan'] : "";
$name = !empty($_POST['yourName']) ? $_POST['yourName'] : "";
$customerMail = !empty($_POST['yourMail']) ? $_POST['yourMail'] : "";
$startTime = !empty($_POST['startTime']) ? $_POST['startTime'] : "";
$endTime = !empty($_POST['endTime']) ? $_POST['endTime'] : "";
$memo = !empty($_POST['memo']) ? $_POST['memo'] : "";
$memoBr = nl2br($memo);
$desc = $title;
if (!empty($memo)) {
  $desc .= "\n" . $memo;
}
$events = get_google_calendar_this_event($year, $month, $day);
$url = home_url() . '/booking-error/?date=' . $thisDay;
judge_close_redirect($events, $url);
$event = insert_google_calendar_event($name, $desc, $year, $month, $day, $startTime, $endTime);


$adminMessage = <<<eof
予約システム-マッサージ-プロトタイプからご依頼です。<br /><br />
予約内容は以下になります。<br /><br />
<table>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">お名前</th>
    <td style="padding: 5px; vertical-align: top;">${name}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">メール</th>
    <td style="padding: 5px; vertical-align: top;">${customerMail}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">日時</th>
    <td style="padding: 5px; vertical-align: top;">${thisDay}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">メニュー</th>
    <td style="padding: 5px; vertical-align: top;">${title}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">開始</th>
    <td style="padding: 5px; vertical-align: top;">${startTime}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">終了</th>
    <td style="padding: 5px; vertical-align: top;">${endTime}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">備考</th>
    <td style="padding: 5px; vertical-align: top;">${memoBr}</td>
  </tr>
</table>
eof;

$customerMessage = <<<eof
${name} 様<br /><br />予約システム-マッサージ-プロトタイプへのご予約ありがとうございます。<br /><br />
当メールはシステムによる自動送信になります。<br />
こちらから最終確認連絡をいたしますので、しばらくおまちください。<br />
送信されたご予約内容は以下になります。<br /><br />
<table>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">お名前</th>
    <td style="padding: 5px; vertical-align: top;">${name}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">メール</th>
    <td style="padding: 5px; vertical-align: top;">${customerMail}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">日時</th>
    <td style="padding: 5px; vertical-align: top;">${thisDay}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">メニュー</th>
    <td style="padding: 5px; vertical-align: top;">${title}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">開始</th>
    <td style="padding: 5px; vertical-align: top;">${startTime}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">終了</th>
    <td style="padding: 5px; vertical-align: top;">${endTime}</td>
  </tr>
  <tr>
    <th style="padding: 5px; text-align: left; vertical-align: top;">備考</th>
    <td style="padding: 5px; vertical-align: top;">${memoBr}</td>
  </tr>
</table>
eof;

$returnAdmin = true;
$adminReplyTo = $adminFromName . " <" . $adminMail . ">";
if (!empty($customerMail)) {
  $adminReplyTo = $name . " <" . $customerMail . ">";
}
$adminHeaders = array (
  'From: ' . $adminFromName . ' <' . $adminMail . '>',
  // 'Cc: Yamada Jiro <jiro@example.com>',
  // 'Bcc: saburo@example.com',
  'Reply-To: ' . $adminReplyTo,
  'Content-Type: text/html; charset=UTF-8'
);
$returnAdmin = wp_mail($adminMail, $adminSubject, $adminMessage, $adminHeaders, $attachments = array() );

$returnCustomer = true;
if (!empty($customerMail)) {
  $customerHeaders = array (
    'From: ' . $adminFromName . ' <' . $adminMail . '>',
    // 'Cc: Yamada Jiro <jiro@example.com>',
    // 'Bcc: saburo@example.com',
    // 'Reply-To: ' . $customerName .' <' . $CustomerMail . '>',
    'Content-Type: text/html; charset=UTF-8'
  );
  $returnCustomer = wp_mail($customerMail, $customerSubject, $customerMessage, $customerHeaders, $attachments = array() );
}

if ( $my_nonce && $event && $returnAdmin && $returnCustomer) {
  $url = home_url() . '/thanks/';
  header('Location: ' . $url, true, 307);
  exit;  
}else{
  $url = home_url() . '/reservation-error/';
  header('Location: ' . $url, true, 307);
  exit;  
}
?>