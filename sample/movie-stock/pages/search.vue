<template>
<b-container>
  <h1 class="alert alert-success mt-4">検索結果</h1>

  <table class="table">
    <thead>
      <tr>
        <th class="text-nowrap">イメージ</th>
        <th class="text-nowrap">id</th>
        <th class="text-nowrap">オリジナル言語</th>
        <th class="text-nowrap">タイトル</th>
        <th class="text-nowrap">リリース日</th>
        <th class="text-nowrap">favorite</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, k) in items" :key="k">
        <td><img :src="apiUrlImg92 + item.poster_path" :alt="item.original_title"></td>
        <td>{{ item.id }}</td>
        <td>{{ item.original_language }}</td>
        <td>
          <NuxtLink :to="'/movie/' + item.id">
            {{ item.original_title }}
          </NuxtLink>
        </td>
        <td>{{ item.release_date }}</td>
        <td :ref="'f_' + item.id" class="favorite" :class="{ favoriteOn: isFavorite(item.id) }">
          <b-icon-heart-fill
            @click="toggleFavorite(item.id, item.original_title, item.release_date, item.poster_path)"
          >
          </b-icon-heart-fill>
        </td>
      </tr>
    </tbody>
  </table>
</b-container>
</template>

<script>
export default {
  head() {
    return {
      title: "検索結果",
    }
  },
  data() {
    return {
      items: [],
      searchWord: "",
      favorites: [],
      apiUrlImg92: process.env.apiUrlImg92,
    }
  },
  mounted(){
    this.setSearchWord()
    this.searchFetch()
    this.setFavorites()
  },
  methods: {
    /**
     * 検索処理
     */
    searchFetch() {
      let searchWord = this.searchWord
      let apiKey  = process.env.apiKey
      let apiUrlSearchMovie = process.env.apiUrlSearchMovie
      let ajaxUrl = apiUrlSearchMovie + "?api_key=" + apiKey + "&query=" + searchWord
      const param = {
        method: "GET",
        body: null,
      }
      fetch(ajaxUrl, param)
        .then( res => res.json() )
        .then(json => {
          this.items = json.results
        })
        .catch(error => {
          alert(error + "\n検索失敗")
        });
    },
    /**
     * URLクエリから検索ワードをセット
     */
    setSearchWord(){
      this.searchWord = this.$route.query.searchWord
    },
    /**
     * お気に入りのON/OFF
     */
    toggleFavorite(movieId, movieTitle, movieReleaseDate, posterPath){
      // ログイン判定
      let user = localStorage.getItem("mvf_user")
      if ( user === null ) {
        alert("ログイン中でないとお気に入り操作できません")
        return
      }
      user = JSON.parse(user)
      let favorites = localStorage.getItem("mvf_favorites")
      // 全ユーザーにおいて、お気に入りが存在しない場合の処理
      if ( favorites === null) {
        let arr = []
        arr.push({
          user: user.name,
          favorites: [
            {
              id: movieId,
              title: movieTitle,
              release: movieReleaseDate,
              img: posterPath,
            }
          ]
        })
        localStorage.setItem("mvf_favorites", JSON.stringify(arr))
        this.toggleFavoriteIcon(movieId)
      }else{
        // 全ユーザーにおいて、お気に入りが存在する場合の処理
        favorites = JSON.parse(favorites)
        // ログイン中ユーザーのお気に入りが存在していた場合の処理
        for(let v of favorites){
          if( v.user === user.name ){
            // すでにお気に入り状態であれば、お気に入りから削除する処理
            for (const favoriteIndex in v.favorites) {
              if ( v.favorites[favoriteIndex].id === movieId ) {
                v.favorites.splice(favoriteIndex, 1)
                localStorage.setItem("mvf_favorites", JSON.stringify(favorites))
                this.toggleFavoriteIcon(movieId)
                return
              }
            }
            // 新規お気に入り追加処理
            v.favorites.push(
              {
                id: movieId,
                title: movieTitle,
                release: movieReleaseDate,
                img: posterPath,
              }
            )
            localStorage.setItem("mvf_favorites", JSON.stringify(favorites))
            this.toggleFavoriteIcon(movieId)
            return
          }
        }
        // ログイン中ユーザーのお気に入りが存在していない場合の処理
        let obj = {
          user: user.name,
          favorites: [
            {
              id: movieId,
              title: movieTitle,
              release: movieReleaseDate,
              img: posterPath,
            }
          ]
        }
        favorites.push(obj)
        localStorage.setItem("mvf_favorites", JSON.stringify(favorites))
        this.toggleFavoriteIcon(movieId)
        return
      }
    },
    /**
     * お気に入りアイコンON/OFF
     */
    toggleFavoriteIcon(movieId){
      this.$refs["f_" + movieId][0].classList.toggle("favoriteOn")
    },
    /**
     * ユーザーのお気に入りをセット
     */
    setFavorites(){
      let user = localStorage.getItem("mvf_user")
      if ( user === null) return false
      let favorites = localStorage.getItem("mvf_favorites")
      if ( favorites === null) return false
      favorites = JSON.parse(favorites)
      user = JSON.parse(user)
      for (const item of favorites) {
        if ( item.user === user.name ) {
          this.favorites = item.favorites
          return
        }
      }
    },
    /**
     * 検索結果の映画ひとつひとつがお気に入りかどうかの判定
     */
    isFavorite(movieId){
      let favorites = this.favorites
      for (const favorite of favorites) {
        if ( favorite.id === movieId ) {
          return true
        }
      }
      return false
    },
  },
}
</script>
