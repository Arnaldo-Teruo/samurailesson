<template>
  <b-container>

    <h1 class="alert alert-primary mt-4">サインイン</h1>

    <table class="signIn">
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

    <b-button variant="primary" @click="signIn()">サインインする</b-button>

  </b-container>
</template>

<script>
export default {
  head() {
    return {
      title: "Sign In",
    };
  },
  data() {
    return {
      name: "",
      password: "",
    };
  },
  methods: {
    /**
     * サインイン処理
     */
    signIn() {
      try {
        let users = localStorage.getItem("mvf_users")
        // 全ユーザーの存在チェック
        if ( users === null ) {
          alert("ユーザーが1人も存在しません\nユーザー登録をしてください")
        }else{
          // ユーザーが1人以上存在している場合の処理
          users = JSON.parse(users)
          if ( users.length > 0 ) {
            // ユーザー名とパスワードが一致した場合の処理
            for (const user of users) {
              if (user.name === this.name && user.password === this.password) {
                let obj = {
                  name: this.name,
                  password: this.password,
                }
                localStorage.setItem("mvf_user", JSON.stringify(obj))
                location.href = "/"
                return
              }
            }
            // ユーザー名とパスワードが一致しない場合の処理
            alert("間違っているようです")
          }
        }
      } catch (error) {
        // なんらかのエラーが発生した場合の処理
        alert("サインイン失敗")
      }
    },
  },
}
</script>