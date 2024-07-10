<template>
    <main>
      <div class="d-flex flex-row justify-content-between col-12" style="width: 100vw;">
        <h4 style="font-size: 50px; font-family: 'Quicksand-Bold';">CAIXA</h4>
      </div>
    </main>
  </template>

<script>
import axios from 'axios'
import VueCookie from 'vue-cookie';
/* import Navbar from './navbar/index.vue' */
import logoComponent from '@/components/vue/logoComponent.vue';
export default{
  components:{logoComponent},
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
        active:""
    }
  }
}
</script>
<style lang="scss" src="./style.scss" scoped></style>./navbar/state