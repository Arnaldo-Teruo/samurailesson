<?php
/**
 * listデータをカテゴリごとに変換してjsonエンコードして返す
 */
function getListDataConverted(){
  $listData    = getListDataSqlite();
  $arr["col1"] = [];
  $arr["col2"] = [];
  $arr["col3"] = [];
  foreach ($listData as $k => $v) {
    if ($v["col"] === "col1") {
      $arr["col1"][] = $v;
    }
    if ($v["col"] === "col2") {
      $arr["col2"][] = $v;
    }
    if ($v["col"] === "col3") {
      $arr["col3"][] = $v;
    }
  }
  return json_encode($arr);
}


/**
 * listデータ取得 json
 */
function getListDataJson(){
  $json = file_get_contents("list.json");
  $arr  = json_decode($json, true);
  $ids  = array_column($arr, 'sort'); // sort順に並び替えている
  array_multisort($ids, SORT_ASC, $arr); // sort順に並び替えている
  return $arr;
}


/**
 * listデータ取得 sqlite
 */
function getListDataSqlite(){
  try {
    $pdo = new PDO('sqlite:list.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $sql = 'SELECT * FROM list';
  	$data = $pdo->query($sql);
    $arr = [];
    if( !empty($data) ) {
      foreach( $data as $v ) {
        $arr[] = $v;
      }
    }
    $ids  = array_column($arr, 'sort'); // sort順に並び替えている
    array_multisort($ids, SORT_ASC, $arr); // sort順に並び替えている
      return $arr;
  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
  }
  $dbh = null;
}

