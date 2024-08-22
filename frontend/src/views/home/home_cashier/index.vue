<template>
    <main>
      <div class="d-flex flex-column col-12">
        <div class="d-flex flex-row col-12">
          <logoComponent :module="this.$route.name"></logoComponent>
        </div>
        <div class="d-flex flex-row col-12">
          <!--SELETOR DE MESA-->
        </div>
        <div class="d-flex flex-row col-12">
          
        </div>
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
  data(){
    return{
        user:{},
        roles:[],
        active:""
    }
  },
  async created(){
    console.log('CASHIER HOMEEE')
  }
}
</script>
<style lang="scss" src="./style.scss" scoped></style>