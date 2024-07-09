<template>
    <main>
      <div class="d-flex flex-row justify-content-between col-12" style="width: 100vw;">
        <Navbar @toggle-navbarWidth="(newValue) =>{this.navbarWidth === newValue}"></Navbar>
        <div class="col-5 d-flex flex-column align-items-start" :style="{'margin-left':this.navbarWidth}">
            <h3 style="color: white;">Bem-vindo Caixa</h3>
            <h1 style="color: white;"> {{ this.user.name }}</h1>
        </div>
      </div>
      
    </main>
  </template>

<script>
import axios from 'axios'
import VueCookie from 'vue-cookie';
import Navbar from './navbar/index.vue'
export default{
  /* setup(){
    return {navbarWidth}
  }, */
  components:{Navbar},
  async created(){
    if(!this.$root.isLoggedIn) await this.$router.go(-1);
    const {data} = await axios.get('user', {headers:{'Authorization':`Bearer ${VueCookie.get('token')}`}});
    this.user = data.user;
    this.roles = data.roles_nm;
    console.log(this.user)
    console.log(this.roles)
  },
  data(){
    return{
        user:{},
        roles:[],
        items:[{
          title:'Veiculos',
          route:'/home/veiculos'
        }],
        navbarWidth:''
    }
  }
}
</script>
<style lang="scss" src="./style.scss" scoped></style>./navbar/state