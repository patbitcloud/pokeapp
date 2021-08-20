/** @format */

import Vue from 'vue'
import VueRouter from 'vue-router'

const Dashboard = () => import('./views/Dashboard')
const OtherUser = () => import('./views/OtherUser')
const OtherUserDetails = () => import('./views/OtherUserDetails')
const MyFavorites = () => import('./views/MyFavorites')
const PageNotFound = () => import('./views/PageNotFound')

const routes = [
  {
    name: 'dashboard',
    path: '/dashboard',
    component: Dashboard
  },
  {
    name: 'otherUser',
    path: '/other-user',
    component: OtherUser,
    children: [
      {
        name: 'otherUserDetails',
        path: ':data',
        component: OtherUserDetails,
        props: true
      }
    ]
  },
  {
    name: 'myFavorites',
    path: '/my-favorites',
    component: MyFavorites
  },
  {
    name: 'pageNotFound',
    path: '*',
    component: PageNotFound
  }
]

Vue.use(VueRouter)

export default new VueRouter({
  mode: 'history',
  routes
})
