<template>
    <span class="d-flex flex-row col-3 act-btn">
        <font-awesome-icon class="col-2" icon="magnifying-glass"/>
        <input
                class="form-control"
                type="text" 
                v-model="search" 
                :placeholder="this.placeholder" 
                @focus="showDropdown = true"
                @blur="hideDropdown"
                @input="filterProducts"
              />
              <div v-if="showDropdown && filteredProducts.length" class="dropdown">
                <ul>
                  <li v-for="(product, index) in filteredProducts" :key="index" @click="$emit('result', product)">
                    {{ product.name }}
                  </li>
                </ul>
              </div>
    </span>
</template>
<style src="./style.scss" lang="scss" scoped></style>

<script>
import axios from 'axios'
    export default{
        props:['placeholder', 'searchTerm'],
        data(){
            return{
                search: "",
                filteredProducts: [],
                showDropdown: false
            }
        },
        methods:{
            async filterProducts() {
                if (this.search) {
                     try {
                        const response = await axios.get('/manager/products/search/'+this.searchTerm+'/'+this.search);
                        this.filteredProducts = response.data[this.searchTerm];
                    } catch (error) {
                        console.error("Erro ao buscar produtos:", error);
                    }
                } else {
                    this.filteredProducts = [];
                }
            },
            hideDropdown() {
                setTimeout(() => {
                    this.showDropdown = false;
                }, 200);
            }
        }
    }
</script>