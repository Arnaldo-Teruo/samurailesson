<?php
$targetID = !empty($_POST['targetID']) ? $_POST['targetID'] : "";
try {
  $pdo = new PDO("sqlite:list.db");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $sql = "DELETE FROM list WHERE id=" . $targetID;
  $res = $pdo->query($sql);
  echo "true";
} catch(PDOException $e) {
  echo $e->getMessage();
  die();
}
$pdo = null;