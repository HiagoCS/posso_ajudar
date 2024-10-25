<template>
    <main>
        <div class="d-flex col-10 offset-1 flex-row search-header">
            <div class="d-flex col-12 flex-row act">
              <span class="d-flex justify-content-center col-1 act-btn">
                <font-awesome-icon icon="filter"/>
              </span>
              <span class="d-flex justify-content-center col-1 act-btn">
                <font-awesome-icon icon="ban"/>
              </span>
              <searchComponent placeholder="Código de Barras" search-term="bar_code" @result="(resul) =>{ this.rawproducts.push(resul)}"></searchComponent>
              <searchComponent placeholder="Código Reduzido" search-term="sm_code" @result="(resul) =>{ this.rawproducts.push(resul)}"></searchComponent>
              <searchComponent placeholder="Produto" search-term="name" @result="(resul) =>{this.rawproducts.push(resul)}"></searchComponent>
            </div>
          </div>
    </main>
</template>
<script>
import searchComponent from "@/components/vue/productsSearch/index.vue";
export default{
    components:{searchComponent},
    async created(){

    }
}
</script>
<style lang="scss" src="./style.scss" scoped/>