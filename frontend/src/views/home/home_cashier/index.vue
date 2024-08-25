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
            <div class="d-flex col-12 flex-row act">
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
          <div class="d-flex flex-row cashier-table product-table-container">
            <div class="table-wrapper">
              <table class="product-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Cód. Reduzido</th>
                  <th>Cód. Barra</th>
                  <th>Produto</th>
                  <th>Descrição</th>
                  <th>R$</th>
                  <th>Quant.</th>
                </tr>
              </thead>
              <tbody>
              <tr v-for="(product, index) in products" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ product.codReduzido }}</td>
                <td>{{ product.codBarra }}</td>
                <td>{{ product.nome }}</td>
                <td>{{ product.descricao }}</td>
                <td>{{ product.preco }}</td>
                <td>{{ product.quantidade }}</td>
              </tr>
            </tbody>
            </table>
            </div>
          </div>
          
        </div>
      </div>
    </main>
  </template>
<!-- <tr>
  <td>#</td>
  <td>Cód. Reduzido</td>
  <td>Cód. Barra</td>
  <td>Produto</td>
  <td>Descrição</td>
  <td>R$</td>
  <td>Quant.</td>
</tr> -->
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
        active:"",
        count: 30,
        products: [
        { codReduzido: '001', codBarra: '123456789', nome: 'Produto 1', descricao: 'Descrição 1', preco: '10.00', quantidade: 1 },
        { codReduzido: '002', codBarra: '987654321', nome: 'Produto 2', descricao: 'Descrição 2', preco: '15.00', quantidade: 2 },
        { codReduzido: '001', codBarra: '123456789', nome: 'Produto 1', descricao: 'Descrição 1', preco: '10.00', quantidade: 1 },
        { codReduzido: '002', codBarra: '987654321', nome: 'Produto 2', descricao: 'Descrição 2', preco: '15.00', quantidade: 2 },
        { codReduzido: '001', codBarra: '123456789', nome: 'Produto 1', descricao: 'Descrição 1', preco: '10.00', quantidade: 1 },
        { codReduzido: '002', codBarra: '987654321', nome: 'Produto 2', descricao: 'Descrição 2', preco: '15.00', quantidade: 2 },
        { codReduzido: '001', codBarra: '123456789', nome: 'Produto 1', descricao: 'Descrição 1', preco: '10.00', quantidade: 1 },
        { codReduzido: '002', codBarra: '987654321', nome: 'Produto 2', descricao: 'Descrição 2', preco: '15.00', quantidade: 2 }
      ]
    }
  },
  async created(){
    console.log('CASHIER HOMEEE')
  }
}
</script>
<style lang="scss" src="./style.scss" scoped></style>