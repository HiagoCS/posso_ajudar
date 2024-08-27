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
            <div class="d-flex col-12 flex-row act" >
              <span class="d-flex justify-content-center col-1 act-btn">
                <font-awesome-icon icon="filter"/>
              </span>
              <span class="d-flex justify-content-center col-1 act-btn">
                <font-awesome-icon icon="ban"/>
              </span>
              <searchComponent placeholder="Código de Barras" search-term="bar_code" @result="(resul) =>{ this.products.push(resul)}"></searchComponent>
              <searchComponent placeholder="Código Reduzido" search-term="sm_code" @result="(resul) =>{ this.products.push(resul)}"></searchComponent>
              <searchComponent placeholder="Produto" search-term="name" @result="(resul) =>{ this.products.push(resul)}"></searchComponent>
            </div>
          </div>
          <div class="d-flex flex-row cashier-table product-table-container">
            <div class="table-wrapper">
              <table class="product-table">
              <thead style="font-size: 20px;">
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
              <tbody style="font-size: 15px;">
              <tr v-for="(product, index) in products" :key="index" >
                <td>{{ index + 1 }}</td>
                <td>{{ product.sm_code }}</td>
                <td>{{ product.bar_code }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.value }}</td>
                <td>{{ product.product_amount }}</td>
              </tr>
            </tbody>
            </table>
            </div>
          </div>
          
        </div>
      </div>
    </main>
  </template>
<script>
import logoComponent from '@/components/vue/logoComponent.vue';
import searchComponent from "@/components/vue/productsSearch/index.vue";
export default{
  components:{logoComponent, searchComponent},
  data(){
    return{
        user:{},
        roles:[],
        active:"",
        count: 30,
        products: [],
        
    }
  }
}
</script>
<style lang="scss" src="./style.scss" scoped></style>