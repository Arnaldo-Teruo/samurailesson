<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <title>PHP課題 関数を作る</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>
<body>
<?php
/**
 * カゴの中
 */
$cart = [
  ['name' => 'お酒', 'price' => 300, 'quantity' => 4, 'type' => '通常'],
  ['name' => 'りんご', 'price' => 100, 'quantity' => 2, 'type' => '軽減'],
  ['name' => 'ビトン', 'price' => 10000, 'quantity' => 1, 'type' => '免税'],
];

/**
 * 消費税率（%）
 */
$taxList = [
  '通常' => 10,
  '軽減' => 8,
  '免税' => 0,
];

/**
 * 合計金額の初期化
 */
$total = 0;

/**
 * 消費税率を返す
 *
 * @param string $type 消費税の種類（通常, 軽減, 免税）
 * @return int 消費税の種類から計算用の消費税率を返す
 */
function get_tax($type){
  global $taxList;
  $calc = $taxList[$type] / 100 + 1;
  return $calc;
}

/**
 * 小計計算して返す
 *
 * @param int $price 商品価格
 * @param int $quantitiy 商品数
 * @param int $tax 消費税率
 * @return int 価格✕商品数✕消費税率を小計金額として返す
 */
function calc_subtotal($price, $quantity, $tax){
  return $price * $quantity * $tax;
}

foreach ($cart as $item) { // カートの中をループ処理する
  $tax      = get_tax( $item["type"] ); // 消費税率を取得
  $subTotal = calc_subtotal( $item["price"], $item["quantity"], $tax ); // 小計を計算取得
  $total += $subTotal; // 小計金額を合計金額に足す
}
?>
<div class="container">
  <h1 class="alert alert-primary my-2">PHP課題 関数を作る</h1>
  <h2 class="my-4"><i class="fas fa-caret-right"></i>下記の買い物設定から合計金額（税込）を計算し出力せよ</h2>
  <table class="table">
    <thead>
      <tr>
        <td>商品</td>
        <td>価格（税抜）</td>
        <td>個数</td>
        <td>消費税種類</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($cart as $item) { ?>
        <tr>
          <th><?php echo $item["name"]; ?></th>
          <td><?php echo number_format($item["price"]); ?>円</td>
          <td><?php echo $item["quantity"]; ?></td>
          <td><?php echo $item["type"]; ?>（<?php echo $taxList[$item["type"]]; ?>％）</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <h3 class="my-4">合計金額（税込）は<span class="text-danger"><?php echo number_format($total); ?>円</span>です</h3>
  <footer class="alert alert-info">
    <div class="text-center">&copy; candy.</div>
  </footer>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>