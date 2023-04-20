<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="info">

      <b-navbar-brand>
        <NuxtLink to="/">{{ title }}</NuxtLink>
        <span v-if="user !== ''">（{{ user.name }}）</span>
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>

        <b-navbar-nav>
          <b-nav-item-dropdown right>
            <template #button-content>
              <em>User</em>
            </template>
            <b-dropdown-item v-if="user !== ''" :to="'/user/' + user.name">
              My Page
            </b-dropdown-item>
            <b-dropdown-item to="/user/signin">
              Sign In
            </b-dropdown-item>
            <b-dropdown-item @click="signOut()">Sign Out</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>

        <b-navbar-nav class="ml-auto">
          <form action="/search" method="get">
            <b-input-group>
              <b-form-input v-model="searchWord" name="searchWord"></b-form-input>
              <b-input-group-append>
                <b-button type="submit" variant="secondary">検索する</b-button>
              </b-input-group-append>
            </b-input-group>
          </form>
        </b-navbar-nav>

      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: process.env.title,
      items: [],
      user: "",
      searchWord: "",
    }
  },
  mounted(){
    this.setUser()
  },
  methods: {
    setUser(){
      let user = localStorage.getItem("mvf_user")
      if ( user === null) return false
      try {
        this.user = JSON.parse(user)
      } catch (error) {
        alert("ユーザーセット失敗")
      }
    },
    signOut(){
      localStorage.removeItem("mvf_user")
      this.user = ""
      location.reload()
    }
  },
}
</script>
