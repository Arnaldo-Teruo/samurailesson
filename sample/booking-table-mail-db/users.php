<?php
require_once 'functions.php';
try {
  // データベース接続
  $pdo = db_connect();

  // SQL文をセット
  $stmt = $pdo->prepare('SELECT * FROM users');

  // SQL実行
  $stmt->execute();
} catch (PDOException $e) {
  // エラー発生
  echo $e->getMessage();
} finally {
  // DBを閉じる
  $pdo = null;
}
require_once 'header.php';
?>

<section class="thanks bg-white">
  <div class="container-fluid text-center">
    <h2 class="mb-4">ユーザー一覧 DataTable</h2>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.1/dist/jquery.min.js"></script> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
      jQuery(function($){
        $('#datatable').DataTable();
      });
    </script>
    <table id="datatable" class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>お名前</th>
          <th>メールアドレス</th>
          <th>利用回数</th>
          <th>エラー</th>
          <th>備考</th>
          <th>作成日</th>
          <th>更新日</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($stmt as $k => $v) { ?>
          <tr>
            <td><?php echo $v['id']; ?></td>
            <td><?php echo $v['name']; ?></td>
            <td class="text-start"><?php echo $v['email']; ?></td>
            <td><?php echo $v['count']; ?></td>
            <td><?php echo nl2br($v['error']); ?></td>
            <td class="text-start"><?php echo nl2br($v['memo']); ?></td>
            <td><?php echo $v['created_at']; ?></td>
            <td><?php echo $v['updated_at']; ?></td>
            <td>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#edit_<?php echo $v['id']; ?>"
              >Edit
              </button>
              <!-- Modal -->
              <div class="modal fade" id="edit_<?php echo $v['id']; ?>" tabindex="-1" aria-labelledby="modalLabel_<?php echo $v['id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <form action="user_edit.php" method="post">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel_<?php echo $v['id']; ?>">編集</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <table class="table">
                          <tbody>
                            <tr>
                              <th>ID</th>
                              <td>
                                <input
                                  type="number"
                                  value="<?php echo $v['id']; ?>"
                                  class="form-control"
                                  disabled
                                >
                                <input
                                  type="hidden"
                                  name="id"
                                  value="<?php echo $v['id']; ?>"
                                >
                              </td>
                            </tr>
                            <tr>
                              <th>お名前</th>
                              <td>
                                <input
                                  type="text"
                                  name="name"
                                  class="form-control"
                                  value="<?php echo $v['name']; ?>"
                                >
                              </td>
                            </tr>
                            <tr>
                              <th>メールアドレス</th>
                              <td>
                                <input
                                  type="email"
                                  name="email"
                                  class="form-control"
                                  value="<?php echo $v['email']; ?>"
                                >
                              </td>
                            </tr>
                            <tr>
                              <th>利用回数</th>
                              <td>
                                <input
                                  type="number"
                                  name="count"
                                  class="form-control"
                                  min="0"
                                  max="999"
                                  value="<?php echo $v['count']; ?>"
                                >
                              </td>
                            </tr>
                            <tr>
                              <th>エラー</th>
                              <td>
                                <textarea
                                  name="error"
                                  class="form-control"
                                  rows="5"
                                ><?php echo $v['error']; ?></textarea>
                              </td>
                            </tr>
                            <tr>
                              <th>備考</th>
                              <td>
                                <textarea
                                  name="memo"
                                  class="form-control"
                                  rows="5"
                                ><?php echo $v['memo']; ?></textarea>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">編集する</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </td>
            <td>
              <form action="user_delete.php" method="post" onSubmit="return check()">
                <input type="hidden" name="id" value="<?php echo $v['id']; ?>">
                <input type="submit" class="btn btn-secondary" value="削除">
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="mt-5">
      <a href="index.php" class="btn btn-secondary">予約テーブルに戻る</a>
    </div>
  </div>
</section>

<script>
function check(){
  if(window.confirm('本当に削除してもいいですか？')){
    return true;
  }
  return false;
}
</script>

<?php require_once 'footer.php'; ?>