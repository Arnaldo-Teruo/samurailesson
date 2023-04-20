<?php
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
    $bool = $exit->fetch(PDO::FETCH_NUM);
    if ($bool) {
      $sql = "UPDATE list SET
        col='" . $v['col'] . "',
        date='" . $v['date'] . "',
        id=" . $v['id'] . ",
        sort=" . $k . ",
        title='" . $v['title'] . "'
        WHERE id=" . $v['id'];
    }else{
      // $sql = "INSERT INTO list (col, date, sort, title) VALUES ('col1', '2021-03-14', 1,'ピーナッツ2')";
      // $sql = "INSERT INTO list (col, sort, title) VALUES ('col1', 1,'ピーマン')";
      $sql = "INSERT INTO list (col, date, sort, title) VALUES ('" . $v['col'] . "','" . $v['date'] . "'," . $v['sort'] . ",'" . $v['title'] . "')";
    }
    $res = $pdo->query($sql);
  }
} catch(PDOException $e) {
  echo $e->getMessage();
  die();
}
$pdo = null;
echo "true";