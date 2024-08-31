<template>
    <table class="product-table">
              <thead style="font-size: 20px;">
                <tr>
                  <th>#</th>
                  <th>Cód. Reduzido</th>
                  <th>Produto</th>
                  <th>Descrição</th>
                  <th>R$</th>
                  <th>Quant.</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody style="font-size: 15px;">
                
              <tr v-for="(product, index) in products" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ product.sm_code }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td class="value">
                  
                <span  :class="`${index}`">
                  {{  (product.value * product.quantity).toFixed(2) }}
                </span>
                <input
                v-if="stopEditing"
                  type="number" 
                  v-model.number="product.value" 
                  @blur="stopEditing(product, index)" 
                  @focusout="stopEditing(product, index)"
                  @keyup.enter="stopEditing(product, index)"
                  :class="`form-control ${index}`"
                />
              </td>
                <td>{{ product.quantity }}</td>
                <td>
                  {{ this.$emit("index", index) }}
                  <slot>
                  </slot>
                </td>
              </tr>
            </tbody>
            </table>
</template>
<style src="./style.scss" lang="scss"></style>
<script>
import axios from 'axios';
    export default{
      watch:{
        products(){
          console.log(this.products);
        }
      },
        props:['products', 'rawproducts'],
        methods:{
          async stopEditing(product) {
       
          this.$forceUpdate();
          try{
            if(product.value) {
            axios.post(`/manager/products/update/${product.id}`,{"value":product.value})
              .then(() => {
                  const index = this.rawproducts.findIndex(raw => raw.id === product.id);
                  this.rawproducts.forEach(async(raw, index) =>{
                    if(raw.id==product.id)
                      this.rawproducts[index].status = "0";
                  });
                  $(".spinner").addClass('active');
                  this.rawproducts.forEach(async (raw, index) =>{
                      const {data} = await axios.get(`/manager/products/search/id/${raw.id}`);
                      this.rawproducts[index].value = data.id.value;
                  });
                  console.log('this.rawproducts',this.rawproducts);
                  $(`span.${index}`).css("display","flex");
                  $(`input.form-control.${index}`).css("display","none");
                  this.rawproducts.forEach(async (raw, index) =>{
                      if(raw.id==product.id)
                        await setTimeout(()=>{$(".spinner.active").removeClass('active');}, 800);
                        await setTimeout(()=>{this.rawproducts[index].status = "1"}, 800);
              
                  });
                }).catch(err => console.log(err));
            }
      } catch (error) {
        console.error(error);
      }
    },
        }
    }
</script>