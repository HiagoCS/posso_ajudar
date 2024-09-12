<template>
    <table class="stock-table col-12">
          <thead>
            <tr style="font-family:'Quicksand-Bold'">
              <th> # </th>
              <th>Nome</th>
              <th>R$</th>
              <th>Custo</th>
              <th>Data da Movimentação</th>
              <th>Movimentos</th>
            </tr>
          </thead>
        <tbody>
          <tr v-for="(stock, index) in this.stocks" :key="index"  
            @mouseover="$emit('hovered', stock)" 
            @mouseleave="$emit('hovered', {})" 
            @click="selectProduct(stock, index)">
            <td :class="this.stk.id===index?this.stk.status:''" 
            :style="`font-family:Quicksand-Regular`">
                {{ index + 1 }}
            </td>
            <td :class="this.stk.id===index?this.stk.status:''"
            :style="`font-family:Quicksand-Regular`">
                {{ stock.name }}
            </td>
            <td :class="this.stk.id===index?this.stk.status:''"
            :style="`font-family:Quicksand-Regular`">
                R${{ this.stock.value }}
            </td>
            <td :class="this.stk.id===index?this.stk.status:''"
            :style="`font-family:Quicksand-Regular`">
                R${{ this.stock.cost }}
            </td>
            <td :class="this.stk.id===index?this.stk.status:''">
              {{this.formatDate(stock.date) }}
            </td>
            <td v-if="stock.type==='entry'"
            style="background-color: #2fa9fe; font-family: 'Quicksand-Bold'; color: white;">
            <i style="color:black"><font-awesome-icon icon="right-to-bracket"></font-awesome-icon></i> Entrada || + {{ stock.quantity }}
            </td>
            <td v-if="stock.type==='sale'"
            style="background-color: #1e9234; font-family: 'Quicksand-Bold'; color: white;" :title="`R$${ (this.stock.value * stock.quantity).toFixed(2) }`">
            <i style="color:black;font-size: 14px;"><font-awesome-icon icon="arrow-up"></font-awesome-icon>
                  <font-awesome-icon icon="dollar-sign"></font-awesome-icon>
                </i> Venda || - {{ stock.quantity }}
            </td>
            <td v-if="stock.type==='out'"
            style="background-color: #e13333; font-family: 'Quicksand-Bold'; color: white;">
            <i style="color:black"><font-awesome-icon icon="outdent"></font-awesome-icon></i>
            Saída || - {{ stock.quantity }}
            </td>
          </tr>
        </tbody>
      </table>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
import dayjs from 'dayjs';
    export default{
      created(){
        console.log(this.stocks);
        /* if(this.stock.id){
          this.selected = this.stock;
          this.stk.status = 'active';
          this.stk.id = this.stock.id;
        } */
      },
      watch:{
        stock(newValue){
          if(Object.keys(newValue).length==0)
            console.log('stock', newValue)
        }
      },
        props: {
            stocks: {
                type: Array,
                required: false
            },
            stock:{
              type:Object,
              required:false,
              default:{}
            }
        },
        data(){
          return{
            selected:null,
            stk:{}
          }
        },
        methods:{
          formatDate(date){
            const datestr = dayjs(date);
            return datestr.format('DD/MM/YYYY');
            },
          selectProduct(stock, index) {
            if(!this.stk.id || this.stk.id!=index){
              this.selected = stock;
              this.stk.status = 'active';
              this.stk.id = index;
              this.$emit('selected', this.selected);
            }else if(this.stk.id===index){
              this.stk.status = '';
              this.stk.id = null;
              this.$emit('selected', {});
            }
          }
        }
    }
</script>