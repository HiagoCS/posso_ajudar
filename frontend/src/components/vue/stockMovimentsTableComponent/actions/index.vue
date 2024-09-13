<template>
    <main class="d-flex align-items-center justify-content-between flex-row col-12 actions">
        <span
            title="Página Anterior"
            
            :class="`btn btn-primary ${Object.keys(this.selected).length===0 ? '': 'disabled'} ${this.disabled.left}`"
            @click="this.$emit('paginate', parseInt(this.currentpage)-1)">
            <font-awesome-icon icon="arrow-left"></font-awesome-icon>
        </span>
        <span
              title="Próxima Página"
              :class="`btn btn-primary ${Object.keys(this.selected).length===0 ? '': 'disabled'} ${this.disabled.right}`"
              @click="this.$emit('paginate', parseInt(this.currentpage)+1)">
                <font-awesome-icon icon="arrow-right"></font-awesome-icon>
        </span>
        <span v-if="Object.keys(this.selected).length===0"
            :class="`btn btn-secondary disabled`">
            <font-awesome-icon icon="pen-to-square"></font-awesome-icon>
        </span>

        <!--Alternados-->
        <!--Entrada-->
        <span v-if="Object.keys(this.selected).length!==0
                &&this.selected.type==='entry'"
            :class="`btn btn-primary`">
            <font-awesome-icon icon="pen-to-square"></font-awesome-icon>
        </span>
        <!--Saída-->
        <span v-if="Object.keys(this.selected).length!==0
                &&this.selected.type==='direct_out'"
            :class="`btn btn-warning`">
            <font-awesome-icon icon="pen-to-square"></font-awesome-icon>
        </span>
        <!--Venda-->
        <span v-if="Object.keys(this.selected).length!==0
                &&this.selected.type==='sale'"
            :class="`btn btn-success`">
            <font-awesome-icon icon="pen-to-square"></font-awesome-icon>
        </span>
        <!--Fim dos Alternados-->

        <span
            :class="`btn btn-danger ${Object.keys(this.selected).length!==0 ? '': 'disabled'}`">
            <font-awesome-icon icon="ban"></font-awesome-icon>
        </span>
    </main>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
    export default{
        props:['productstock', 'disabled', 'edit_status', 'currentpage', 'send_data', 'stockproduct', 'selected'], 
        async created(){
            console.log('stockproduct', this.stockproduct)
        },
        watch:{
            selected(newValue){
                console.log("watchprodutc", newValue)
            },
        }
    }
</script>