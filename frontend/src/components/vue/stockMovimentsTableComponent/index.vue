<template>
    <table class="stock-table col-12">
          <thead>
            <tr style="font-family:'Quicksand-Bold'">
              <th class="col-1 text-center">#</th>
              <th>Nome</th>
              <th class="col-1">R$</th>
              <th class="col-1">Custo</th>
              <th>Data da Movimentação</th>
              <th>Movimentos</th>
            </tr>
          </thead>
        <tbody>
          <tr v-for="(stock, index) in this.stocks" :key="index"  
            @mouseover="$emit('hovered', stock)" 
            @mouseleave="$emit('hovered', {})" 
            @click="selectProduct(stock, index)">
            <td :class="`${this.stk.id===index?this.stk.status:''} col-1`" 
            :style="`font-family:Quicksand-Regular`">
                {{ index + 1}}
            </td>
            <td :class="this.stk.id===index?this.stk.status:''"
            :style="`font-family:Quicksand-Regular`">
                {{ this.stock.name }}
            </td>
            <td :class="`${this.stk.id===index?this.stk.status:''} col-1`"
            :style="`font-family:Quicksand-Regular`">
                R${{ this.stock.value }}
            </td>
            <td :class="`${this.stk.id===index?this.stk.status:''} col-1`"
            :style="`font-family:Quicksand-Regular`">
                R${{ this.stock.cost }}
            </td>
            <td :class="`${this.stk.id===index?this.stk.status:''} text-center`">
              {{this.formatDate(stock.date) }}
            </td>
            <td v-if="stock.type==='entry'"
            class="moves entry"
            style="background-color: #2fa9fe; font-family: 'Quicksand-Bold'; color: white;">
            <i style="color:black"><font-awesome-icon icon="right-to-bracket"></font-awesome-icon></i> Entrada || + {{ stock.quantity }}
            </td>
            <td v-if="stock.type==='sale'"
            class="moves sale"
            style="" :title="`R$${ (this.stock.value * stock.quantity).toFixed(2) }`">
            <i style="color:black;font-size: 14px;"><font-awesome-icon icon="arrow-up"></font-awesome-icon>
                  <font-awesome-icon icon="dollar-sign"></font-awesome-icon>
                </i> Venda || - {{ stock.quantity }}
            </td>
            <td v-if="stock.type==='direct_out'"
            class="moves out"
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
        if(Object.keys(this.stk).length !== 0){
          this.selected = this.stocks[this.stk.id]
          this.$emit('selected', this.selected);
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
            stk:{
              id:0,
              status:'active'
            }
          }
        },
        methods:{
          formatDate(date){
            const datestr = dayjs(date);
            return datestr.format('DD/MM/YYYY');
            },
          selectProduct(stock, index) {
            if(Object.keys(this.stk).length !==0 && index===this.stk.id){
              this.stk = {}
              this.selected = null
              console.log('disselecte');
              this.$emit('selected', {});
              return;
            }
            if(Object.keys(this.stk).length===0 || index!==this.stk.id){
              this.selected = stock;
              this.stk = {
                id:index,
                status:'active'
              }
              console.log('selecteddd');
              this.$emit('selected', this.selected);
              return;
            }
          }
        }
    }
</script>