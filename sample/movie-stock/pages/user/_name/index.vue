<template>
  <b-container>

    <h1 class="alert alert-danger mt-4">{{ user }}</h1>

    <b-input-group prepend="絞り込み" class="mt-5 mb-4">
      <b-form-input v-model="searchWord"></b-form-input>
    </b-input-group>

    <div v-if="favorites.length === 0" class="alert alert-warning mt-4 mb-5">
      お気に入り映画が1つ以上ありましたらこちらに表示されます
    </div>

    <div v-if="resCount" class="h2">{{ resCount }} 件</div>

    <b-card-group
      columns
      v-if="favorites.length > 0"
      class="table-responsive py-4"
    >
      <b-card
        v-for="(item, k) in filteredList"
        :key="k"
        :title="item.title"
        :img-src="apiUrlImg342 + item.img"
        :img-alt="item.title"
        img-top
        tag="article"
        class="mb-2"
      >
        <b-card-text>{{ item.release }}</b-card-text>
        <b-button :to="'/movie/' + item.id" variant="warning">
          詳しく見る
        </b-button>
      </b-card>
    </b-card-group>

  </b-container>
</template>

<script>
export default {
  head() {
    return {
      title: "My Page",
    }
  },
  data() {
    return {
      user: this.$route.params.name,
      items: [],
      favorites: [],
      searchWord: "",
      resCount: "",
      apiUrlImg342: process.env.apiUrlImg342,
    }
  },
  mounted(){
    this.setFavorites()
  },
  methods: {
    setFavorites(){
      let favorites = localStorage.getItem("mvf_favorites")
      if ( favorites === null ) return false
      favorites = JSON.parse(favorites)
      for (const item of favorites) {
        if ( item.user === this.user ) {
          this.favorites = item.favorites
          return
        }
      }
    },
  },
	computed: {
		filteredList(){
			let lists = [];
			let searchWord = String(this.searchWord)
      if ( searchWord === "" ) {
        this.resCount = this.favorites.length
        return this.favorites
      }
			if ( searchWord.length > 0 ) {
				for(let item of this.favorites) {
          let str = String(item.id) + String(item.title) + String(item.account) + String(item.password) + String(item.mail) + String(item.memo) + String(item.created_at)
					if(str.toLowerCase().indexOf(searchWord) !== -1) {
						lists.push(item);
					}
				}
			}
			this.resCount = lists.length
			return lists;
		},
	},
}
</script>
