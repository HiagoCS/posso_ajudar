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