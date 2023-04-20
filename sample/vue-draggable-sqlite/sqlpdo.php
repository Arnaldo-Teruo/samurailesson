<?php
$pdo = new PDO("sqlite:list.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_NUM);
// $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$id = 84;
$sql = "DELETE FROM list WHERE id=" . $id;
// $sql = "SELECT id FROM list WHERE id=" . $id;
$exit = $pdo->query($sql);
$res = $exit->fetch(PDO::FETCH_NUM);
if ( $res ) {
  echo "success";
}else{
  echo "error";
}
echo '<pre>';
print_r( $exit->fetch(PDO::FETCH_NUM) );
// print_r( $exit->fetch(PDO::FETCH_ASSOC) );
echo '</pre>';
exit;
foreach ($exit as $k => $v) {
  echo '<pre>';
  print_r($v);
  echo '</pre>';
}
exit;
function updateSqlite() {
  $listPostJson = !empty($_POST['list']) ? $_POST['list'] : "";
  $listPostArr  = json_decode(stripslashes($listPostJson));
  $targetID     = !empty($_POST['targetID']) ? $_POST['targetID'] : "";
  $updateCol    = !empty($_POST['updateCol']) ? $_POST['updateCol'] : "";
  $listNewArr   = [];
  foreach ($listPostArr->col1 as $k => $v) {
    $listNewArr[] = [
      "id"    => $v->id,
      "date"  => $v->date,
      "title" => $v->title,
      "col"   => $v->col,
      "sort"  => $k
    ];
  }
  foreach ($listPostArr->col2 as $k => $v) {
    $listNewArr[] = [
      "id"    => $v->id,
      "date"  => $v->date,
      "title" => $v->title,
      "col"   => $v->col,
      "sort"  => $k
    ];
  }
  foreach ($listPostArr->col3 as $k => $v) {
    $listNewArr[] = [
      "id"    => $v->id,
      "date"  => $v->date,
      "title" => $v->title,
      "col"   => $v->col,
      "sort"  => $k
    ];
  }
  foreach ($listNewArr as $k => $v) {
    if ( $v["id"] == $targetID ) {
      $listNewArr[$k]["col"] = $updateCol;
    }
  }
  try {
    $pdo = new PDO("sqlite:list.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    foreach ($listNewArr as $k => $v) {
      $sql = "SELECT id FROM list WHERE id=" . $v['id'];
      $exit = $pdo->query($sql);
      if ( $exit[0]["id"] > 0 ) {
        // $sql = "UPDATE list SET
        //   col='" . $v['col'] . "',
        //   date='" . $v['date'] . "',
        //   id=" . $v['id'] . ",
        //   sort=" . $k . ",
        //   title='" . $v['title'] . "'
        //   WHERE id=" . $v['id'];
      }else{
        $sql = "INSERT INTO list (col, date, sort, title) VALUES ('col1', '2021-03-14', 1,'ピーナッツ2')";
        // $stmt = $pdo->prepare("INSERT INTO list (col, date, sort, title) VALUES (?, ?, ?, ?)");
        // $stmt->bindValue('col1', '2021-03-14', 1, 'ピーマン');
        // $stmt->execute();
        // $sql = "INSERT INTO list (col, sort, title) VALUES ('col1', 1,'ピーマン')";
        // $sql = "INSERT INTO list (col, date, sort, title) VALUES ('" . $v['col'] . "','" . $v['date'] . "'," . $v['sort'] . ",'" . $v['title'] . "')";
      }
      $res = $pdo->query($sql);
    }
  } catch(PDOException $e) {
    echo $e->getMessage();
    die();
  }
  $pdo = null;
}







try {
    $pdo = new PDO('sqlite:list.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $sql = 'SELECT * FROM list';
  	$data = $pdo->query($sql);
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    // exit;
    // if( !empty($data) ) {
    //   foreach( $data as $v ) {
    //     echo '<pre>';
    //     print_r($v);
    //     echo '</pre>';
    //   }
    // }
    // exit;


    // 挿入（プリペアドステートメント）
    // $stmt = $pdo->prepare("INSERT INTO fruit(name, price) VALUES (?, ?)");
    // foreach ([['りんご', '200'], ['バナナ', '200']] as $params) {
    //     $stmt->execute($params);
    // }

    // 選択 (プリペアドステートメント)
    // $stmt = $pdo->prepare("SELECT * FROM fruit WHERE price = ?");
    // $stmt->execute(['200']);
    // $r1 = $stmt->fetchAll();

} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}
// 接続を閉じる
$dbh = null;