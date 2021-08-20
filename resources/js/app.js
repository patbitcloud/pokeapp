/** @format */

require('alpinejs')

import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import router from './router'
import UserProfile from './views/UserProfile'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.component('user-profile', UserProfile)

new Vue({
  el: '#app',
  router
})
