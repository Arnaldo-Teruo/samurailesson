<?php
$listPostJson    = !empty($_POST['list']) ? $_POST['list'] : "";
$listPostArr     = json_decode(stripslashes($listPostJson));
$targetID        = !empty($_POST['targetID']) ? $_POST['targetID'] : "";
$updateCol       = !empty($_POST['updateCol']) ? $_POST['updateCol'] : "";
$listNewArr      = [];
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
$json = json_encode($listNewArr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
$res  = file_put_contents("list.json", $json);
if ($res) {
  echo "true";
} else {
  echo "false";
}