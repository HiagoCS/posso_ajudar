<script>
import { RouterView } from 'vue-router'
import axios from 'axios'
import VueCookie from 'vue-cookie';
import Navbar from "@/components/vue/navbar/index.vue"

export default{
  components:{
    Navbar
  },
  data(){
    return{
      isLoggedIn: !!VueCookie.get('token'),
      user:{},
      active:'active'
    }
  },
  async created(){
    await this.userData();
    if(!this.$root.isLoggedIn &&
    this.$router.currentRoute.value.name != "home") this.$router.push("login");
  },
  methods:{
    async userData(){
      if(this.isLoggedIn){
        const {data} = await axios.get('user', {headers:{'Authorization':`Bearer ${VueCookie.get('token')}`}});
        this.user = data.user;
        this.roles = data.roles_nm;
        console.log("DATA", data);
        return data;
      }else {this.user = {}; return {}};
    }
  }
}
</script>

<template>
  <main>
    <div class="d-flex flex-row main-div col-12">
      <div class="d-flex flex-row">
        <Navbar @toggleNav="() =>{this.active=='active'}" :user="{'data':this.user, 'roles':this.roles}"></Navbar>
      </div>
      <RouterView :user="user"/>
    </div> 
  </main>
</template>

<style lang="scss" src="./style.scss" />
