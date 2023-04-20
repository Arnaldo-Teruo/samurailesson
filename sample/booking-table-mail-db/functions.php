<?php
/**
 * 定義
 */
$appTitle  = 'Booking Table';
$closeKey  = 'close'; // 予約閉じワード
$span      = 60; // 60日分のスケジュールにする
$divideMin = 30; // 30分区切り
$iniStart  = 10; // 10時スタート
$iniEnd    = 21; // 21時エンド
$iniDivide = ($iniEnd - $iniStart) * 60 / $divideMin; // タイムテーブルの時間刻み
$DB_HOST   = 'localhost';
$DB_NAME   = 'booking-table-mail-db';


/**
 * Googleカレンダーにイベント登録する
 * @param string $name, $desc, $startTime, $endTime
 * @param int $year, $month, $day
 * @return obj 読み込まれている gcal-api.php の Google_Service_Calendarオブジェクト
 */
function insert_google_calendar_event($name, $desc, $year, $month, $day, $startTime, $endTime){
  require 'gcal-api.php';
  $month   = convert2dig($month);
  $day     = convert2dig($day);
  $thisDay = $year . "-" . $month . "-" . $day;
  $event = new Google_Service_Calendar_Event(array(
    'summary' => $name,
    'description' => $desc,
    'start' => array(
      'dateTime' => $thisDay . "T" . $startTime . ":00+09:00",// 2020-03-14T10:00:00+09:00
      'timeZone' => 'Asia/Tokyo',
    ),
    'end' => array(
      'dateTime' => $thisDay . "T" . $endTime . ":00+09:00", // 2020-03-14T11:00:00+09:00
      'timeZone' => 'Asia/Tokyo',
    ),
  ));
  return $service->events->insert($calendarId, $event);
}


/**
 * データベースに接続する
 */
function db_connect(){
  global $DB_HOST, $DB_NAME;
  // 日本時間にセットする
  date_default_timezone_set('Asia/Tokyo');
	return new PDO(
		"mysql: host={$DB_HOST}; dbname={$DB_NAME};", // ホスト名、データベース名
		'root', // ユーザー名
		'', // パスワード
		[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC] // レコード列名をキーとして取得させる
	);
}


/**
 * ポストデータのバリデート処理
 */
function validate(){
  // エラー内容を初期化
  $errors = [];

  // $_POSTをサニタイズして$postに代入（セキュリティ対策）
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

  // バリデーション処理をしてエラーを追加していく
  $name = $post['name'];
  if( $post['name'] === "" ){ // 必須項目なので空チェック
    $errors['name'] = "blank";
  }
  $email = $post['email'];
  if ( !filter_var($post['email'], FILTER_VALIDATE_EMAIL) ){ // email形式かどうかのチェック
    $errors['email'] = "email";
  }
  if( $post['email'] === "" ){ // 必須項目なので空チェック
    $errors['email'] = "blank";
  }
  return [$post, $errors];
}


/**
 * 2桁に変換する
 * @param int $v 1桁の数字
 * @return string 2桁に変換された数字だが、str_pad によって文字列となる
 */
function convert2dig($v){
	return str_pad($v, 2, 0, STR_PAD_LEFT);
}


/**
 * 曜日を漢字にする
 * @param int $v 週番号
 * @return string 週番号から変換された漢字の曜日
 */
function get_week_kanji($w){
  $week = array( "日", "月", "火", "水", "木", "金", "土" );
  return $week[$w];
}
?>