<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <title>vue-chart</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
  <h1>vue-chart</h1>
  <div id="app">
    {{ message }}
  
    <line-chart></line-chart>
  </div>
</div>


<!-- jQuery、Popper.js、Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@1.1.2"></script> -->
<script>
Vue.component('line-chart', {
 extends: VueChartJs.Pie,
 mounted() {
  this.renderChart({
   labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
   datasets: [{
    label: 'Data One',
    data: [10, 20, 30, 40, 50, 60, 40],
    backgroundColor: ["red", "black", "blue", "orange", "yellow", "pink", "purple"],
   }]
  }, {
   responsive: true,
   maintainAspectRatio: false
  })
 }
})
var app = new Vue({
  el: '#app',
  data: {
    message: 'Hello Vue!'
  }
})
</script>
</body>
</html>