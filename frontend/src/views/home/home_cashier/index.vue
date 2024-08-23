<template>
    <main>
      <div class="d-flex flex-column col-12">
        <div class="d-flex flex-row col-12">
          <logoComponent :module="this.$route.name"></logoComponent>
        </div>
        <div class="d-flex flex-row col-12">
          <!--SELETOR DE MESA-->
        </div>
        <div class="d-flex flex-column align-items-center">
          <div class="d-flex flex-row cashier-table">
            <div class="d-flex col-12 flex-row">
              <span class="d-flex justify-content-center col-1 act-btn">
                <font-awesome-icon icon="filter"/>
              </span>
              <span class="d-flex justify-content-center col-1 act-btn">
                <font-awesome-icon icon="ban"/>
              </span>
              <span class="d-flex col-5 act-btn">
                <font-awesome-icon icon="magnifying-glass"/>
                <a style="font-size: 70%;">Código de Barra</a>
              </span>
              <span class="d-flex col-5 act-btn">
                <font-awesome-icon icon="magnifying-glass"/>
                <a style="font-size: 70%;">Produto</a>
              </span>
            </div>
          </div>
          <div class="d-flex flex-column cashier-table table">
            <div class="d-flex flex-row justify-content-between table-header">
              <span>#</span>
              <span>Cód. Reduzido</span>
              <span>Cód. Barra</span>
              <span>Produto</span>
              <span>Descrição</span>
              <span>R$</span>
              <span>Quant.</span>
            </div>
            <div class="d-flex flex-row justify-content-between table-items">
              <span>#</span>
              <span>Cód. Reduzido</span>
              <span>Cód. Barra</span>
              <span>Produto</span>
              <span>Descrição</span>
              <span>R$</span>
              <span>Quant.</span>
            </div>
          </div>
          
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