<?php include 'functions.php'; ?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <title>Draggable</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container-fluid">

  <h1>Draggable</h1>

  <div id="app" class="p-4">

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
      追加する
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">追加する</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <div class="form-group">
              <label for="inputDate">Date</label>
              <input type="date" v-model="addDate" class="form-control" id="inputDate">
            </div>
            <div class="form-group">
              <label for="inputTitle">Title</label>
              <input type="text" v-model="addTitle" class="form-control" id="inputTitle">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="addList()">保存する</button>
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive pb-4">
      <div class="row row-cols-3 area mx-auto">
        <div class="col list-col1">
          <div class="mb-2">
            <i class="fas fa-circle"></i>
            <strong>列１</strong>
            <span class="badge rounded-pill bg-gray text-dark px-3" v-text="list.col1.length + '件'"></span>
          </div>
          <div class="card" @drop="drop('col1')">
            <div class="card-body">
              <draggable tag="ul" class="list-group p-3" :options="{group:'ITEMS', handle:'.handle'}" v-model="list.col1">
                <li v-for="(v, i) in list.col1" :key="i" @dragstart="dragStart(v)" class="list-group-item d-flex justify-content-between align-items-center">
                  <div class="d-flex justify-content-between align-items-center">
                    <i class="fas fa-grip-vertical text-gray handle mr-3"></i>
                    <div>
                      <span v-text="v.date" class="mr-2"></span>
                      <b v-text="v.title"></b>
                    </div>
                  </div>
                  <button class="btn btn-danger" @click="doDelete(v.col, i)">削除</button>
                </li>
              </draggable>
            </div>
          </div>
        </div>
        <div class="col list-col2">
          <div class="mb-2">
            <i class="fas fa-circle"></i>
            <strong>列２</strong>
            <span class="badge rounded-pill bg-gray text-dark px-3" v-text="list.col2.length + '件'"></span>
          </div>
          <div class="card" @drop="drop('col2')">
            <div class="card-body">
              <draggable tag="ul" class="list-group p-3" :options="{group:'ITEMS', handle:'.handle'}" v-model="list.col2">
                <li v-for="(v, i) in list.col2" :key="i" @dragstart="dragStart(v)" class="list-group-item d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <i class="fas fa-grip-vertical text-gray handle mr-3"></i>
                    <div>
                      <span v-text="v.date" class="mr-2"></span>
                      <b v-text="v.title"></b>
                    </div>
                  </div>
                  <button class="btn btn-danger" @click="doDelete(v.col, i)">削除</button>
                </li>
              </draggable>
            </div>
          </div>
        </div>
        <div class="col list-col3">
          <div class="mb-2">
            <i class="fas fa-circle"></i>
            <strong>列３</strong>
            <span class="badge rounded-pill bg-gray text-dark px-3" v-text="list.col3.length + '件'"></span>
          </div>
          <div class="card" @drop="drop('col3')">
            <div class="card-body">
              <draggable tag="ul" class="list-group p-3" :options="{group:'ITEMS', handle:'.handle'}" v-model="list.col3">
                <li v-for="(v, i) in list.col3" :key="i" @dragstart="dragStart(v)" class="list-group-item d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <i class="fas fa-grip-vertical text-gray handle mr-3"></i>
                    <div>
                      <span v-text="v.date" class="mr-2"></span>
                      <b v-text="v.title"></b>
                  </div>
                  </div>
                  <button class="btn btn-danger" @click="doDelete(v.col, i)">削除</button>
                </li>
              </draggable>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.23.2/vuedraggable.umd.min.js"></script>

<script>
const draggable = window['vuedraggable'];
// const draggable = window.vuedraggable; これでもいい
new Vue({
  el: "#app",
  components: {
    'draggable': draggable,
  },
  data: {
    list: <?php echo getListDataConverted(); ?>,
    dragTarget: {},
    droped: "",
    addDate: new Date().toISOString().substr(0, 10),
    addTitle: "",
  },
  methods: {
    dragStart(v){
      this.dragTarget = v;
    },
    drop(e){
      this.droped = e;
    },
    updateListData(){
      let url    = 'update.php';
      let params = new URLSearchParams();
      params.append('list', JSON.stringify(this.list));
      params.append('targetID', this.dragTarget.id);
      params.append('updateCol', this.droped);
      const param = {
        method: "POST",
        body: params
      }
      fetch(url, param)
        .then( res => {
          return res.text();
        })
        .then( text => {
          console.log(text);
          location.reload(true);
        })
        .catch( error => {
          alert(error + "\n送信失敗");
        });
    },
    doDelete(col, i){
      if(confirm('本当に削除していいですか？')){
        this.list[col].splice(i, 1);
      }
    },
    addList(){
      let sorts = [];
      let ids   = [];
      this.list.col1.filter( v => {
        sorts.push(v.sort);
        ids.push(v.id);
      });
      this.list.col2.filter( v => {
        ids.push(v.id);
      });
      this.list.col3.filter( v => {
        ids.push(v.id);
      });
      let maxId   = Math.max.apply(null, ids);
      let addId   = ++maxId;
      let maxSort = Math.max.apply(null, sorts);
      let addSort = ++maxSort;
      this.list.col1.push({
        col: "col1",
        date: this.addDate,
        id: addId,
        sort: maxSort,
        title: this.addTitle,
      });
    },
  },
  watch: {
    list: {
      handler: function(n){
        this.updateListData();
      },
      deep: true,
    },
  },
});
</script>

<!-- jQuery、Popper.js、Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>