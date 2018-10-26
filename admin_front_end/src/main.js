// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import App from './App'
import router from './router'
import {fetch, baseURL} from './config/fetch.js'
import global from './assets/js/global.js'
import store from './store/'
import 'babel-polyfill'
import 'font-awesome/css/font-awesome.css'
import vueQuillEditor from 'vue-quill-editor' // 引入富文本工具
// require styles 引入样式
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

Vue.config.productionTip = false

Vue.use(ElementUI);
Vue.use(vueQuillEditor)

const bus = new Vue()
window.bus = bus
window.bs=global
window.fetch=fetch
window.baseURL = baseURL
window.router = router

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
