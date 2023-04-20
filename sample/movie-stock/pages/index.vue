<template>
  <div>

    <section class="head bg-primary py-5">
      <b-container>
        <h1 class="text-white mb-3">果てしない映画の旅へ</h1>
        <h2 class="text-white mb-5">感動と力をもたらすストーリー、革新的な映像、何百万本もの映画に出会ってください！</h2>
        <form action="/search" method="get">
          <b-input-group prepend="映画検索" class="mt-3">
            <b-form-input name="searchWord"></b-form-input>
            <b-input-group-append>
              <b-button type="submit" variant="secondary">検索する</b-button>
            </b-input-group-append>
          </b-input-group>
        </form>
      </b-container>
    </section>

    <section class="favorite">
      <b-container>
        <div class="d-flex align-items-center mt-4">
          <b-icon-heart-fill class="h3 mr-2 text-danger"></b-icon-heart-fill>
          <h3>あなたのお気に入り（{{ favorites.length }}）</h3>
        </div>
        <div v-if="favorites.length === 0" class="alert alert-warning mt-4 mb-5">
          サインインし、お気に入り映画が1つ以上ありましたらこちらに表示されます
        </div>
        <div v-if="favorites.length > 0" class="table-responsive py-4">
          <b-row class="flex-nowrap">
            <b-col v-for="(favorite, k) in favorites" :key="k" cols="3">
              <b-card
                :title="favorite.title"
                :img-src="'http://image.tmdb.org/t/p/w342/' + favorite.img"
                :img-alt="favorite.title"
                img-top
                tag="article"
                class="mb-2"
              >
                <b-card-text>{{ favorite.release }}</b-card-text>
                <b-button :to="'/movie/' + favorite.id" variant="warning">
                  詳しく見る
                </b-button>
              </b-card>
            </b-col>
          </b-row>
        </div>
      </b-container>
    </section>

    <b-container>
      <b-card title="管理用">
        <div>ユーザーが存在しない場合は登録してください</div>
        <h2 class="alert alert-info mt-5">ユーザー登録</h2>
        <table class="registerUser">
          <tbody>
            <tr>
              <th>User Name</th>
              <td>
                <input
                  type="text"
                  name="name"
                  v-model="name"
                  class="form-control"
                />
              </td>
            </tr>
            <tr>
              <th>Password</th>
              <td>
                <input
                  type="password"
                  name="password"
                  v-model="password"
                  class="form-control"
                />
              </td>
            </tr>
          </tbody>
        </table>
        <div>
          <b-button variant="primary" @click="register()">登録する</b-button>
        </div>
        <h2 class="alert alert-info mt-5">ユーザー一覧</h2>
        <b-list-group>
          <b-list-group-item v-for="user in users">
            <NuxtLink :to="'/user/' + user.name">
              {{ user.name }}
            </NuxtLink>
          </b-list-group-item>
        </b-list-group>
      </b-card>
    </b-container>

  </div>
</template>

<script>
export default {
  head() {
    return {
      titleTemplate: null,
      title: process.env.title,
    }
  },
  data() {
    return {
      name: "",
      password: "",
      users: [],
      favorites: [],
    };
  },
  mounted(){
    this.setUsers()
    this.setFavorites()
  },
  methods: {
    /**
     * ユーザー登録処理
     */
    register() {
      try {
        // ユーザー名とパスワードを取得
        let obj = {
          name: this.name,
          password: this.password,
        }
        let users = localStorage.getItem("mvf_users")
        // ユーザーが1人も存在していない場合の処理
        if ( users === null ) {
          localStorage.setItem("mvf_users", JSON.stringify([obj]))
          location.reload()
        }else{
          // ユーザーが1人以上存在している場合の処理
          users = JSON.parse(users)
          if ( users.length > 0 ) {
            users.push(obj)
            localStorage.setItem("mvf_users", JSON.stringify(users))
            location.reload()
          }
        }
      } catch (error) {
        // なんらかのエラーが発生した場合の処理
        alert("登録失敗")
      }
    },
    /**
     * 全ユーザーを取得
     */
    setUsers(){
      let users = localStorage.getItem("mvf_users")
      if ( users === null ) {
        this.users = []
      }else{
        users = JSON.parse(users)
        if ( users.length > 0 ) {
          this.users = users
        }
      }
    },
    /**
     * ログイン中の場合に、お気に入りを取得
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
  },
}
</script>
