<?php
/**
 * 定義
 */
$closeKey = "close"; //応募締め切りキーワード
$span = 60; // 60日分のスケジュールにする
$divideMin = 30; // 30分区切り
$iniStart = 10; // 受付10時スタート
$iniEnd = 18; // 受付18時エンド
$iniDivide = ($iniEnd - $iniStart) * 60 / $divideMin; // タイムテーブルの時間刻み


/**
 * CSS&JS 読み込み
 */
function theme_enqueue_styles() {
  wp_enqueue_style( 'style-bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
  wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css');
  wp_enqueue_style( 'font-serif', 'https://fonts.googleapis.com/css?family=Noto+Serif+JP&display=swap');
  wp_enqueue_style( 'jquery-confirm', get_stylesheet_directory_uri() . '/jquery.confirm/jquery.confirm.css');
  wp_enqueue_style( 'my-style', get_stylesheet_directory_uri() . '/css/style.css');
	if ( is_admin_bar_showing() ) {
	  wp_enqueue_style( 'style-adminBar', get_stylesheet_directory_uri() . '/css/admin-bar.css', "", '');
	}
  // wp_deregister_script('jquery');
  // wp_enqueue_script( 'jquery',  'https://code.jquery.com/jquery-3.3.1.min.js', "", "", false );
  wp_enqueue_script( 'bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array( 'jquery' ), '', true );
  // wp_enqueue_script( 'jquery-confirm', get_stylesheet_directory_uri() . '/jquery.confirm/jquery.confirm.js', array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


/**
 * アイキャッチ画像を有効化
 */
add_theme_support('post-thumbnails');


/*
 * ログイン画面のスタイル変更
 */
function my_login_stylesheet() {
  wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/css/login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );


/*
 * ログイン画面のロゴのリンク先変更
 */
function my_login_logo_url() {
  return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );


/**
 * タイトル設定
 */
add_theme_support( 'title-tag' );
function wp_document_title_parts ( $title ) {
  if ( is_home() || is_front_page() ) {
    unset( $title['tagline'] );
  }
  return $title;
}
add_filter( 'document_title_parts', 'wp_document_title_parts', 10, 1 );

function wp_document_title_separator( $separator ) {
  $separator = '|';
  return $separator;
}
add_filter( 'document_title_separator', 'wp_document_title_separator' );


/**
 * OGPタグ
 */
function my_meta_ogp() {
  if( is_front_page() || is_home() || is_singular() ){
    global $post;
    $ogp_title = '';
    $ogp_descr = '';
    $ogp_url = '';
    $ogp_img = '';
    $insert = '';
    if( is_singular() ) {
       setup_postdata($post);
       $ogp_title = $post->post_title;
       // $ogp_descr = mb_substr(get_the_excerpt(), 0, 100);
       $ogp_descr = get_bloginfo('description');
       $ogp_url = get_permalink();
       wp_reset_postdata();
    } elseif ( is_front_page() || is_home() ) {
       $ogp_title = get_bloginfo('name');
       $ogp_descr = get_bloginfo('description');
       $ogp_url = home_url();
    }
    $ogp_type = ( is_front_page() || is_home() ) ? 'website' : 'article';
    if ( is_singular() && has_post_thumbnail() ) {
       $ps_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
       $ogp_img = $ps_thumb[0];
    } else {
     $ogp_img = get_template_directory_uri() . '/img/ogimage.png';
    }
    $insert .= '<meta property="og:title" content="'.esc_attr($ogp_title).'" />' . "\n";
    $insert .= '<meta property="og:description" content="'.esc_attr($ogp_descr).'" />' . "\n";
    $insert .= '<meta property="og:type" content="'.$ogp_type.'" />' . "\n";
    $insert .= '<meta property="og:url" content="'.esc_url($ogp_url).'" />' . "\n";
    $insert .= '<meta property="og:image" content="'.esc_url($ogp_img).'" />' . "\n";
    $insert .= '<meta property="og:site_name" content="'.esc_attr(get_bloginfo('name')).'" />' . "\n";
    // $insert .= '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    // $insert .= '<meta name="twitter:site" content="ツイッターのアカウント名" />' . "\n";
    $insert .= '<meta property="og:locale" content="ja_JP" />' . "\n";
    //facebookのapp_id（設定する場合）
    // $insert .= '<meta property="fb:app_id" content="ここにappIDを入力">' . "\n";
    //app_idを設定しない場合ここまで消す
    echo $insert;
  }
}
add_action('wp_head','my_meta_ogp');


/**
 * メニュー取得
 */
function get_items_json(){
  $items = array();
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'asc',
    'post_status' => 'publish'
  );
  $the_query = new WP_Query( $args );
  if($the_query->have_posts()):
    while($the_query->have_posts()):
      $the_query->the_post();
      $title = get_the_title();
      $category = get_the_category()[0];
      $categoryName = $category->name;
      $categorySlug = $category->slug;
      $desc = get_the_content();
      $img = get_the_post_thumbnail_url($post->ID);
      $attr = SCF::get('attr', $post->ID);
      $attrArr = array();
      foreach ($attr as $k => $v) {
        $attrName = $v['attr-name'];
        $attrPrice = $v['attr-price'];
        $attrDesc = nl2br($v['attr-desc']);
        $attrArr[$attrName] = array(
          'price' => $attrPrice,
          'desc' => $attrDesc,
          'number' => 0
        );
      }
      $items[] = array(
        'name' => $title,
        'categoryName' => $categoryName,
        'categorySlug' => $categorySlug,
        'desc' => $desc,
        'sumSmall' => 0,
        'img' => $img,
        'attr' => $attrArr
      );
    endwhile;
  endif;
  wp_reset_postdata();
  $itemsJson = json_encode($items);
  return $itemsJson;
}


/**
 * カレンダー生成
 */
function output_single_calendar($year, $month){
	global $closeKey;
	require 'gcal-api.php';
	$month2digits = convert2dig($month);
	$timeMin = convert_google_calendar_time_first($year, $month);
	$timeMax = convert_google_calendar_time_last($year, $month);
	$optParams = array(
    // 'maxResults' => 10,
		'timeZone' => 'Asia/Tokyo',
    'orderBy' => 'startTime',
    'singleEvents' => true,
    'timeMin' => $timeMin,
    'timeMax' => $timeMax
	);
	$results = $service->events->listEvents($calendarId, $optParams);
	$events = $results->getItems();
	if (isset($events)):
		date_default_timezone_set('Asia/Tokyo');
    $startDate = array();
    $startTime = array();
    $startKey = array();
    $endDate = array();
    $endTime = array();
    $dateymd = array();
    $close = array();
		foreach ($events as $event):
		  $title = empty($event->getSummary()) ? "タイトル取得できませんでした" : $event->getSummary();
	    if ($title === $closeKey) {
	    	$close[] = get_date($event->start->date);
	    }
	    $start = $event->start->dateTime; // 2020-03-10T10:00:00+09:00
	    $end = $event->end->dateTime; // 2020-03-10T11:00:00+09:00
	    if (isset($start)) {
		    $startDate[] = $start;
		    // $startDate[] = date('Y/m/d H:i:s',strtotime($start));
		    $startTime[] = convert_hour_minute($start); // 00:00
		    $startKey[] = create_daytime_key($start); // date20200314
	    }
	    if (isset($end)) {
		    $endDate[] = $end;
		    // $endDate[] = date('Y/m/d H:i:s', strtotime($end));
		    $endTime[] = convert_hour_minute($end);
	    }
			$desc = $event->getDescription();
			// $link = $event->htmlLink;
		endforeach;
	endif;
	//翌月、翌々月が年をまたぐ場合
	if( $month > 12 ) { $year = $year + 1; $month = $month - 12; }
	//月末日の取得
	// $l_day = date('t', strtotime($year.sprintf('%02d',$month).'01'));
	$l_day = get_last_month_day($year, $month);
	//月初日の曜日の取得
	$first_week = date('w',strtotime($year.sprintf('%02d',$month).'01') - 1); //-1を入れると月曜始まりになる
	// 日本の祝日を取得
	$holiday = japan_holiday_ics();
	$calendar = <<<EOM
<div class="titleCalendar"><div class="year">{$year}年</div><div class="month">{$month}月</div></div>
<div class="table-responsive"><table class="table table-bordered table-reservation-single">
	<thead>
		<tr>
			<th>月</th>
			<th>火</th>
			<th>水</th>
			<th>木</th>
			<th>金</th>
			<th class="sat">土</th>
			<th class="sun">日</th>
		</tr>
	</thead>
EOM;
	for( $i=1; $i<=$l_day+$first_week; $i++ ) {
		$day = $i-$first_week;
		if( $i%7 == 1 ) { $calendar .= '<tr>'."\n"; }
		if( $day <= 0 ) {
			$calendar .= '<td>&nbsp;</td>'."\n";
		} else {
			$key = 'date'.$year.sprintf('%02d',$month).sprintf('%02d',$day);
			$selectedDay = $year . '-' . $month2digits . '-' . sprintf('%02d',$day);
			if( mktime(0,0,0,$month,$day,$year) < mktime(0,0,0,date('n'),date('j'),date('Y')) ) {
				$class = ' class="past"';
				$desc = '';
			}else{
				$class = ' class="normal"';
				$value = 0;
				$openClose = '<button type="sumbmit" class="btn btn-ok"><i class="fas fa-dot-circle text-red"></i></button>';
				$desc = '<form action="' . home_url() . '/booking2/" method="post"><div class="reserveBtn">';
				$flagClose = false;
				foreach ($close as $k => $v) {
					if ($v == $day) {
						$flagClose = true;
					}
				}
				if ($flagClose) {
					$openClose = '<div class="btn btn-close"><i class="fas fa-times"></i></div>';
				}else{
					$desc .= '<input type="hidden" name="selectYear" value="' . $year . '">';
					$desc .= '<input type="hidden" name="selectMonth" value="' . $month . '">';
					$desc .= '<input type="hidden" name="selectDay" value="' . $day . '">';
					foreach ($startKey as $k => $v) {
						if ($key === $v) {
							$desc .= '<div class="text-nowrap">✕ ' . $startTime[$k] . '～' . $endTime[$k] . '</div>';
						}
					}
				}
				$desc .= $openClose;
				$desc .= '</form>';
				if( !isset($value) ) {
					$class = ' class=""';
					$desc = '<span class="undecided">休</span>';
				}
				if( date('w',mktime(0,0,0,$month,$day,$year)) == 0 ) {
					$class =' class="sun"';
				}
				if( date('w',mktime(0,0,0,$month,$day,$year)) == 6 ) {
					$class =' class="sat"';
				}
				$holidayKey = "";
				$dayName = false;
				foreach ($holiday as $k => $v) {
					$holidayKey = 'date' . $v['date'];
					if ($key === $holidayKey) {
						$class =' class="holiday"';
						$dayName = ' 祝日';
					}
				}
				if( mktime(0,0,0,$month,$day,$year) == mktime(0,0,0,date('n'),date('j'),date('Y')) ) {
					$class =' class="today"';
					$dayName = ' 今日';
				}
			}
			$calendar .= '<td'.$class.'>';
			$calendar .= '<div class="dayHead"><span class="day">'.$day.'</span>';
			if (isset($dayName)) {
				$calendar .= '<span class="dayTitle">' . $dayName . '</span>';
			}
			$calendar .= '</div><div class="dayBody">' . $desc . '</div>';
			$calendar .= '</td>'."\n";
		}
	}
	if( $i%7 > 1 ) {
		for( $td=0; $td<=7-($i%7); $td++) {
			$calendar .= '<td>&nbsp;</td>'."\n";
		}
	}
	$calendar .= '</tr>'."\n";
	/* calendar body end   */
	$calendar .= '</table></div>'."\n";
	return $calendar;
}


/**
 * 日本の祝日を取得
 */
function japan_holiday_ics() {
    // カレンダーID
    $calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');
    $url = 'https://calendar.google.com/calendar/ical/'.$calendar_id.'/public/full.ics';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    if (!empty($result)) {
        $items = $sort = array();
        $start = false;
        $count = 0;
        foreach(explode("\n", $result) as $row => $line) {
            // 1行目が「BEGIN:VCALENDAR」でなければ終了
            if (0 === $row && false === stristr($line, 'BEGIN:VCALENDAR')) {
                break;
            }
            // 改行などを削除
            $line = trim($line);
            // 「BEGIN:VEVENT」なら日付データの開始
            if (false !== stristr($line, 'BEGIN:VEVENT')) {
                $start = true;
            } elseif ($start) {
                // 「END:VEVENT」なら日付データの終了
                if (false !== stristr($line, 'END:VEVENT')) {
                    $start = false;
                    // 次のデータ用にカウントを追加
                    ++$count;
                } else {
                    // 配列がなければ作成
                    if (empty($items[$count])) {
                        $items[$count] = array('date' => null, 'title' => null);
                    }
                    // 「DTSTART;～」（対象日）の処理
                    if(0 === strpos($line, 'DTSTART;VALUE')) {
                        $date = explode(':', $line);
                        $date = end($date);
                        $items[$count]['date'] = $date;
                        // ソート用の配列にセット
                        $sort[$count] = $date;
                    }
                    // 「SUMMARY:～」（名称）の処理
                    elseif(0 === strpos($line, 'SUMMARY:')) {
                        list($title) = explode('/', substr($line, 8));
                        $items[$count]['title'] = trim($title);
                    }
                }
            }
        }
        // 日付でソート
        $items = array_combine($sort, $items);
        ksort($items);
        return $items;
    }
}


/**
 * 日時を指定してのGoogleカレンダーイベント取得
 */
function get_google_calendar_this_event($year, $month, $day){
  require 'gcal-api.php';
  $timeMin = convert_google_calendar_day_first($year, $month, $day);
  $timeMax = convert_google_calendar_day_last($year, $month, $day);
  $optParams = array(
    // 'maxResults' => 10,
    'timeZone' => 'Asia/Tokyo',
    'orderBy' => 'startTime',
    'singleEvents' => true,
    'timeMin' => $timeMin,
    'timeMax' => $timeMax
  );
  $results = $service->events->listEvents($calendarId, $optParams);
  $events = $results->getItems();
  return $events;
}


/**
 * 募集締め切り判定後にリダイレクト処理まで
 */
function judge_close_redirect($events, $url){
  global $closeKey;
  $close = false;
  foreach ($events as $k => $v) {
    if ($v->summary === $closeKey) {
      $close = true;
    }
  }
  if ( $close ){
    wp_redirect($url, 307);
    exit;  
  }
  return false;
}


/**
 * Googleカレンダーにイベント登録する
 */
function insert_google_calendar_event($name, $desc, $year, $month, $day, $startTime, $endTime){
  require 'gcal-api.php';
  $month = convert2dig($month);
  $day = convert2dig($day);
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
 * 2桁に変換する
 */
function convert2dig($v){
	return str_pad($v, 2, 0, STR_PAD_LEFT);
}


/**
 * 月末日取得
 */
function get_last_month_day($year, $month){
	return date('t', mktime(0, 0, 0, $month, 1, $year));
}


/**
 * Googleカレンダー用タイムフォーマット変換 月初
 */
function convert_google_calendar_time_first($year, $month){
	$month = convert2dig($month);
	return $year . "-" . $month . "-01T00:00:00+09:00";
}


/**
 * Googleカレンダー用タイムフォーマット変換 月末
 */
function convert_google_calendar_time_last($year, $month){
	$lastDay = get_last_month_day($year, $month);
	$lastDay = convert2dig($lastDay);
	$month = convert2dig($month);
	return $year . "-" . $month . "-" . $lastDay . "T23:59:59+09:00"; // 2020-03-14T10:00:00+09:00
}


/**
 * Googleカレンダー用タイムフォーマット変換 日の始まり
 */
function convert_google_calendar_day_first($year, $month, $day){
	$month = convert2dig($month);
	$day = convert2dig($day);
	return $year . "-" . $month . "-" . $day . "T00:00:00+09:00";
}


/**
 * Googleカレンダー用タイムフォーマット変換 日の終わり
 */
function convert_google_calendar_day_last($year, $month, $day){
	$month = convert2dig($month);
	$day = convert2dig($day);
	return $year . "-" . $month . "-" . $day . "T23:59:59+09:00";
}


/**
 * 時と分に変換
 */
function convert_hour_minute($v){
	date_default_timezone_set('Asia/Tokyo');
	return date('H:i',strtotime($v));
}


/**
 * 日を抽出 0パディングなし
 */
function get_date($v){
	date_default_timezone_set('Asia/Tokyo');
	return date('j',strtotime($v));
}


/**
 * 日付キー生成
 */
function create_daytime_key($v){
  date_default_timezone_set('Asia/Tokyo');
	return 'date' . date('Ymd',strtotime($v));
}


/**
 * Unixタイムから年を取得
 */
function get_unix_year($unix){
  date_default_timezone_set('Asia/Tokyo');
  return date('Y', $unix);
}


/**
 * Unixタイムから月を取得
 */
function get_unix_month($unix){
  date_default_timezone_set('Asia/Tokyo');
  return date('n', $unix);
}


/**
 * Unixタイムから日を取得
 */
function get_unix_day($unix){
  date_default_timezone_set('Asia/Tokyo');
  return date('j', $unix);
}


/**
 * Unixタイムから時間を取得
 */
function get_unix_hour($unix){
  date_default_timezone_set('Asia/Tokyo');
  return date('H', $unix);
}

/**
 * Unixタイムから分を取得
 */
function get_unix_minute($unix){
  date_default_timezone_set('Asia/Tokyo');
  return date('i', $unix);
}


/**
 * 曜日を漢字にする
 */
function get_week_kanji($w){
  $week = array( "日", "月", "火", "水", "木", "金", "土" );
  return $week[$w];
}
?>