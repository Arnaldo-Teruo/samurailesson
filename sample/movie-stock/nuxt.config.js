/**
 * 環境変数の読込
 * 開発環境と本番環境で読み込むenvファイルを変更するようにしていますが、今回は同じ値がセットされています
 */
const appEnvironment = require(`./config/env.${process.env.NODE_ENV}.js`)

export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: appEnvironment.title,
    htmlAttrs: {
      lang: 'js'
    },
    titleTemplate: '%s | ' + appEnvironment.title,
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: appEnvironment.description },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    "~/assets/css/style.css"
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    'bootstrap-vue/nuxt',
  ],
  bootstrapVue: {
    icons: true
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  },

  /**
   * グローバル変数のセット
   */
  env: appEnvironment
}
