<!-- @format -->

<template>
  <div class="row" style="height: 87%;">
    <div class="col-md-3" id="userList">
      <br />
      <div class="row">
        <div class="col-md-12">
          <div class="input-icon">
            <i class="fa fa-search"></i>
            <input
              v-model.trim="searchUser"
              type="text"
              class="form-control"
              placeholder="Search user name here... "
              @input="searchForUser"
            />
          </div>
        </div>
        <div class="col-md-12 mt-3">
          <b-list-group>
            <b-list-group-item
              v-for="user in users"
              :key="user.id"
              :to="{
                name: 'otherUserDetails',
                params: { data: serializeUserData(user) }
              }"
              >{{ user.full_name }}</b-list-group-item
            >
          </b-list-group>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <b-container fluid>
        <router-view></router-view>
      </b-container>
    </div>
  </div>
</template>

<script>
import { debounce } from 'lodash'
import http from '../utils/http'

export default {
  data() {
    return {
      users: [],
      searchUser: ''
    }
  },
  methods: {
    //encrypting or serialize passing data to child components [OtherUserDetails.vue]' for security purposes
    serializeUserData(data) {
      return btoa(JSON.stringify(data))
    },
    //get all users list from user table
    retrieveUsers() {
      http.get('/user/list').then(response => {
        this.users = response.data.data
      })
    },
    //search user lists
    searchForUser() {
      this.search(this)
    },
    search: debounce(async vm => {
      const { data } = await http.get(`/user/list?search=${vm.searchUser}`)
      vm.users = data.data
    }, 250)
  },
  mounted() {
    this.retrieveUsers()
  }
}
</script>

<style scoped>
#userList {
  background-color: azure;
  height: 100%;
}
</style>
