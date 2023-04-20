<?php
/**
 * セッションスタート
 */
session_start();
$_SESSION = array();

/**
 * ヘルパー関数の読み込み
 */
require_once 'functions.php';

/**
 * バリデートとエラー処理
 */
list($post, $errors) = validate($_POST);

/**
 * 次に入力データを送るためにセッションに入れ込む
 */
$_SESSION['form'] = $post;
$_SESSION['errors'] = $errors;

/**
 * エラーがなければ登録処理へ
 */
if( count($errors) === 0 ){
  header("Location: save.php");
  exit();
}else{
  header("Location: index.php");
  exit();
}