<template>
    <table class="product-table col-12">
          <thead>
            <tr>
              <th> # </th>
              <th>Código de Barras</th>
              <th>Código Reduzido</th>
              <th>Produto</th>
              <th>Descrição</th>
              <th>Quantidade</th>
              <th>R$</th>
            </tr>
          </thead>
        <tbody>
          <tr v-for="(product, index) in this.products" :key="index"  
            @mouseover="$emit('hovered', product)" 
            @mouseleave="$emit('hovered', {})" 
            @click="selectProduct(product)">
            <td :class="this.prd.id===product.id?this.prd.status:''" 
                :style="`color:${product.status===0?'#8b8a8a':'black'};font-family:${product.status===0?'Quicksand-Regular-Oblique':'Quicksand-Regular'}`">
                {{ product.id }}
            </td>
            <td :class="this.prd.id===product.id?this.prd.status:''" 
                :style="`color:${product.status===0?'#8b8a8a':'black'};font-family:${product.status===0?'Quicksand-Regular-Oblique':'Quicksand-Regular'}`">
                {{ product.bar_code }}
            </td>
            <td :class="this.prd.id===product.id?this.prd.status:''" 
                :style="`color:${product.status===0?'#8b8a8a':'black'};font-family:${product.status===0?'Quicksand-Regular-Oblique':'Quicksand-Regular'}`">
                {{ product.sm_code }}
            </td>
            <td :class="this.prd.id===product.id?this.prd.status:''" 
                :style="`color:${product.status===0?'#8b8a8a':'black'};font-family:${product.status===0?'Quicksand-Regular-Oblique':'Quicksand-Regular'}`">
                {{ product.name }}
            </td>
            <td :class="this.prd.id===product.id?this.prd.status:''" 
                :style="`color:${product.status===0?'#8b8a8a':'black'};font-family:${product.status===0?'Quicksand-Regular-Oblique':'Quicksand-Regular'}`">
                {{ product.description }}
            </td>
            <td :class="this.prd.id===product.id?this.prd.status:''" 
                :style="`color:${product.status===0?'#8b8a8a':'black'};font-family:${product.status===0?'Quicksand-Regular-Oblique':'Quicksand-Regular'}`">
                {{ product.product_amount }}
            </td>
            <td :class="this.prd.id===product.id?this.prd.status:''" 
                :style="`color:${product.status===0?'#8b8a8a':'black'};font-family:${product.status===0?'Quicksand-Regular-Oblique':'Quicksand-Regular'}`">
                R${{ product.value }}
            </td>
          </tr>
        </tbody>
      </table>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
    export default{
      created(){
        if(this.product.id){
          this.selected = this.product;
          this.prd.status = 'active';
          this.prd.id = this.product.id;
        }
      },
        props: {
            products: {
                type: Array,
                required: true
            },
            product:{
              type:Object,
              required:false
            }
        },
        data(){
          return{
            selected:null,
            prd:{
              id:0,
              status:''
            }
          }
        },
        methods:{
          selectProduct(product) {
            if(!this.prd.id || this.prd.id!=product.id){
              this.selected = product;
              this.prd.status = 'active';
              this.prd.id = product.id;
              this.$emit('selected', product);
            }else{
              this.selected = {};
              this.prd.status = '';
              this.prd.id = null;
              this.$emit('selected', product);
            }
          },
          isSelected(product) {
            return this.selectedProduct && this.selectedProduct.id === product.id;
          }
        }
    }
</script>