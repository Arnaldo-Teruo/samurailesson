<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <title>Lesson8</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .box {
      position: relative;
      border: 2px solid black;
      padding: 1rem;
      margin-top: 1.5rem;
    }
    .number {
      position: absolute;
      top: -1rem;
      left: -1rem;
      background-color: green;
      border-radius: 50%;
      padding: 0.3rem 0.7rem;
      color: red;
    }
  </style>
</head>
<body>
<div class="container">
  <h1>Lesson8</h1>
<?php $arr = ["太郎", "花子", "次郎"]; ?>

  <?php foreach ($arr as $k => $v) { ?>
    <div class="box">
      <span class="number"><?php echo $k; ?></span>
      <h2><?php echo $v; ?></h2>
    </div>
  <?php } ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>