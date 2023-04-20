<template>
  <b-container>

    <h1 class="alert alert-warning mt-4">
      <b-icon-heart-fill
        v-show="isFavorite"
        variant="danger"
        class="favoriteIcon"
      >
      </b-icon-heart-fill>
      {{ item.title }}
    </h1>

    <div class="text-right">
      <b-button
        v-if="isFavorite"
        @click="toggleFavorite()"
        variant="secondary"
        class="mb-4"
      >お気に入りから外す
      </b-button>
      <b-button
        v-if="!isFavorite"
        @click="toggleFavorite()"
        variant="danger"
        class="mb-4"
      >お気に入りにする
      </b-button>
    </div>

    <b-row>
      <b-col cols="auto">
        <img :src="apiUrlImg342 + item.poster_path" :alt="item.title">
      </b-col>
      <b-col>
        <table class="table">
          <tbody>
            <tr>
              <th>id</th>
              <td>{{ item.id }}</td>
              <tr>
                <th>genres</th>
                <td>
                  <span v-for="(genres, k) in item.genres" :key="k">
                    {{ genres.name }}
                    <span v-if="++k != item.genres.length"> / </span>
                  </span>
                </td>
              </tr>
              <tr>
                <th>homepage</th>
                <td>
                  <a :href="item.homepage" target="_blank" rel="noopener noreferrer">
                    {{ item.homepage }}
                  </a>
                </td>
              </tr>
              <tr>
                <th>original_language</th>
                <td>{{ item.original_language }}</td>
              </tr>
              <tr>
                <th>title</th>
                <td>{{ item.title }}</td>
              </tr>
              <tr>
                <th>overview</th>
                <td>{{ item.overview }}</td>
              </tr>
              <tr>
                <th>popularity</th>
                <td>{{ item.popularity }}</td>
              </tr>
            </tr>
          </tbody>
        </table>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  head() {
    return {
      title: "映画詳細 | " + this.item.title,
    }
  },
  data() {
    return {
      item: {},
      favorites: [],
      isFavorite: false,
      apiUrlImg342: process.env.apiUrlImg342,
    }
  },
  mounted(){
    this.view()
    this.setFavorites()
    this.judgeFavorite()
  },
  methods: {
    /**
     * 映画詳細を取得
     */
    view() {
      let apiKey  = process.env.apiKey
      let ajaxUrl = process.env.apiUrlMovie + this.$route.params.id + "?api_key=" + apiKey
      const param = {
        method: "GET",
        body: null,
      }
      fetch(ajaxUrl, param)
        .then( res => res.json() )
        .then(json => {
          this.item = json
        })
        .catch(error => {
          alert(error + "\n閲覧失敗")
        });
    },
    /**
     * ユーザーのお気に入りを取得
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
     * お気に入り判定
     */
    judgeFavorite(){
      let favorites = this.favorites
      let movieId = this.$route.params.id
      for (const favorite of favorites) {
        if ( favorite.id == movieId ) {
          this.isFavorite = true
          return
        }
      }
    },
    /**
     * お気に入りのON/OFF
     */
    toggleFavorite(){
      // ログイン判定
      let user = localStorage.getItem("mvf_user")
      if ( user === null ) {
        alert("ログイン中でないとお気に入り操作できません")
        return
      }
      // 必要となる要素セット
      let movieId = this.item.id
      let movieTitle = this.item.title
      let movieReleaseDate = this.item.release_date
      let posterPath = this.poster_path
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
        this.isFavorite = true
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
                this.isFavorite = false
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
            this.isFavorite = true
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
        this.isFavorite = true
        return
      }
    },
  },
}
</script>
