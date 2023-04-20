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

  /**
   * バリデートとエラー処理
   */
  list($post, $errors) = validate($_POST);

  // SQL文をセット
  $sql = 'UPDATE users SET name = :name, email = :email, count = :count, error = :error, memo = :memo, updated_at = :updated_at WHERE id = :id';
  $stmt = $pdo->prepare($sql);

  // 値をセット
  $stmt->bindValue(':name', $post['name']);
  $stmt->bindValue(':email', $post['email']);
  $stmt->bindValue(':count', $post['count']);
  $stmt->bindValue(':error', $post['error']);
  $stmt->bindValue(':memo', $post['memo']);
  $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
  $stmt->bindValue(':id', $post['id']);

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