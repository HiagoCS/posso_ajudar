<template>
    <main class="d-flex align-items-center justify-content-between flex-row col-12 actions">
        <!--GRUPO 01-->
        <span
            title="Página Anterior"
            
            :class="`btn btn-primary ${this.disabled.left}`"
            @click="this.$emit('paginate', parseInt(this.currentpage)-1)">
            <font-awesome-icon icon="arrow-left"></font-awesome-icon>
        </span>
<!----------------------------------------------------------------------------------->
<!--GRUPO 02-->
        <span
              title="Próxima Página"
              :class="`btn btn-primary ${this.disabled.right}`"
              @click="this.$emit('paginate', parseInt(this.currentpage)+1)">
                <font-awesome-icon icon="arrow-right"></font-awesome-icon>
        </span>
        <!-- <span
              title="Adicionar nova Saída"
              v-if="this.productstock.id"
              :class="`btn btn-primary ${this.disabled.export}`"
              @click="this.$emit('newOut', !this.edit_status)">
                <font-awesome-icon icon="file-export"></font-awesome-icon>
        </span>
        <span
              title="Próxima Página"
              v-if="!this.productstock.id"
              :class="`btn btn-primary ${this.disabled.right}`"
              @click="this.$emit('paginate', parseInt(this.currentpage)+1)">
                <font-awesome-icon icon="arrow-right"></font-awesome-icon>
        </span> -->
<!-----------------------------------------------------------------------------------> 
<!--GRUPO 03-->
        <span
            :class="`btn btn-secondary disabled`"
            @click="() =>{console.log('select',this.stockproduct)}">
            <font-awesome-icon icon="file-import"></font-awesome-icon>
        </span>
        <span
            v-if="Object.keys(this.stockproduct.stockMovements.selected).length != 0
            &&this.stockproduct.stockMovements.selected.type==='entry'"
            title="Adicionar nova Entrada"
            :class="`btn btn-primary ${Object.keys(this.stockproduct.stockMovements.selected).length != 0 ? '':'disabled'}`"
            @click="() =>{console.log('select',this.stockproduct)}">
            <font-awesome-icon icon="file-import"></font-awesome-icon>
        </span>
        <span
            v-if="Object.keys(this.stockproduct.stockMovements.selected).length != 0
                && this.stockproduct.stockMovements.selected.type==='out'"
            title="Editar Saída"
            :class="`btn btn-danger ${this.disabled.import}`"
            @click="() =>{console.log('select',this.stockproduct)}">
            <font-awesome-icon icon="file-export"></font-awesome-icon>
        </span>
        <span
            v-if="Object.keys(this.stockproduct.stockMovements.selected).length != 0
                && this.stockproduct.stockMovements.selected.type==='sale'"
            title="Editar venda"
            :class="`btn btn-warning ${this.disabled.edit}`"
            @click="() =>{console.log('select',this.stockproduct)}">
            <font-awesome-icon icon="pen-to-square"></font-awesome-icon>
        </span>
       <!--  <span
               v-if="!this.edit_status"
              title="Exibir tudo (entradas, saídas e vendas)"
              :class="`btn btn-primary ${this.disabled.lines}`"
              @click="this.$emit('allMoviments', this.productstock)">
                <font-awesome-icon icon="file-lines"></font-awesome-icon>
        </span>
        <span
            v-if="this.edit_status&&this.send_data.add_entry===false"
            :class="`btn btn-success out ${this.disabled.check}`"
            @click="this.$emit('newOut_obj', !this.edit_status)">
            <font-awesome-icon icon="check"></font-awesome-icon>
        </span>
        <span
            v-else-if="this.edit_status&&this.send_data.add_entry===true"
            :class="`btn btn-success add_entry ${this.disabled.check}`"
            @click="this.$emit('newEntry_obj', !this.edit_status)">
            <font-awesome-icon icon="check"></font-awesome-icon>
        </span> -->
<!-----------------------------------------------------------------------------------> 
<!--GRUPO 04-->
        <!-- <span
              v-if="!this.edit_status"
              title="Exportar tudo (entradas, saídas e vendas)"
              :class="`btn btn-primary ${this.disabled.pdf}`"
              @click="">
                <font-awesome-icon icon="file-pdf"></font-awesome-icon>
        </span>
        <span 
              v-if="this.edit_status"
              :class="`btn btn-danger ${this.disabled.ban}`"
              @click="this.$emit('cancel', false)">
                <font-awesome-icon icon="ban"></font-awesome-icon>
        </span> -->
    </main>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
    export default{
        props:['productstock', 'disabled', 'edit_status', 'currentpage', 'send_data', 'stockproduct'],
        watch:{
            stockproduct(newValue){
                console.log("newcocok - act", newValue);
            }
        },  
        async created(){
            console.log('allcocjk',Object.keys(this.stockproduct.stockMovements.selected).length)
        }
    }
</script>