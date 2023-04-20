<?php
try {
  /**
   * ヘルパー関数の読み込み
   */
  require_once 'functions.php';

  /**
   * データベース接続
   */
  $pdo = db_connect();

  // SQL文をセット
  $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
  
  // 値をセット
  $stmt->bindValue(':id', $_POST['id']);

  // SQL実行
  $stmt->execute();

} catch (PDOException $e) {
  // エラー発生
  echo $e->getMessage();

} finally {
  // DB接続を閉じる
  $pdo = null;

  /**
   * ユーザー一覧へ
   */
  $url = 'users.php';
  header('Location: ' . $url, true, 307);
  exit;
}