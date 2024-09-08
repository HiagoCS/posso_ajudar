<template>
    <table class="stock-table col-12">
          <thead>
            <tr style="font-family:'Quicksand-Bold'">
              <th> # </th>
              <th>Nome</th>
              <th>R$</th>
              <th style="font-size: 14px;">Quantidade (Total)</th>
              <th style="background-color: #2fa9fe;border-color: #2fa9fe;color:white">
                <i style="color:black"><font-awesome-icon icon="right-to-bracket"></font-awesome-icon></i>
                <i style="color:white;font-size: 14px;"> Ultima Entrada</i>
              </th>
              <th style="background-color: #1e9234;border-color: #1e9234;">
                <i style="color:black;font-size: 14px;"><font-awesome-icon icon="arrow-up"></font-awesome-icon>
                  <font-awesome-icon icon="dollar-sign"></font-awesome-icon>
                </i>
                <i style="color:white;font-size: 14px;"> Ultima Venda</i>
              </th>
              <!---->
              <th style="background-color: #e13333;border-color: #e13333;color:white">
                <i style="color:black"><font-awesome-icon icon="outdent"></font-awesome-icon></i>
                <i style="color:white;"> Ultima Saída</i>
              </th>
            </tr>
          </thead>
        <tbody>
          <tr v-for="(stock, index) in this.stocks" :key="index"  
            @mouseover="$emit('hovered', stock)" 
            @mouseleave="$emit('hovered', {})" 
            @click="selectProduct(stock)">
            <td :class="this.stk.id===stock.id?this.stk.status:''" 
            :style="`font-family:Quicksand-Regular`">
                {{ stock.id }}
            </td>
            <td :class="this.stk.id===stock.id?this.stk.status:''" 
            :style="`font-family:Quicksand-Regular`">
                {{ stock.name }}
            </td>
            <td  :class="`${this.stk.id===stock.id?this.stk.status:''}`" 
            :style="`font-family:Quicksand-Regular`"
            :title="`#${stock.id} - ${stock.name} = R$${stock.value}`">
                R${{ stock.value }}
            </td>
            <td  :class="this.stk.id===stock.id?this.stk.status:''" 
            :style="`font-family:Quicksand-Regular`"
            :title="`#${stock.id} - ${stock.name} = ${stock.amount}UN`">
                {{ stock.amount }}
            </td>
            <td :class="this.stk.id===stock.id?this.stk.status:''" 
            :style="`font-family:Quicksand-Regular;font-size:15px`"
            :title="`#${stock.id} - ${stock.name} = ${this.formatDate(stock.last_entry.dt_entry)}`">
                <i style="color: #2fa9fe;font-family:'Quicksand-Bold'">+ {{ stock.last_entry.qunt_toAdd }}</i> || <i style="font-family:'Quicksand-Regular-Oblique'">{{ this.formatDate(stock.last_entry.dt_entry) }}</i>
            </td>
            <td  :class="this.stk.id===stock.id?this.stk.status:''" 
            :style="`font-family:Quicksand-Regular;font-size:15px`"
            :title="`#${stock.id} - ${stock.name} = ${this.formatDate(stock.last_sale.dt_sale)}`">
                <i style="color: #1e9234;font-family:'Quicksand-Bold'">- {{ stock.last_sale.qunt_remove }}</i> || <i style="font-family:'Quicksand-Regular-Oblique'">{{ this.formatDate(stock.last_sale.dt_sale) }}</i>
            </td>
            <td  :class="this.stk.id===stock.id?this.stk.status:''" 
            :style="`font-family:Quicksand-Regular;font-size:15px`"
            :title="`#${stock.id} - ${stock.name} = ${this.formatDate(stock.last_out.dt_out)}`">
              <i style="color: #e13333;font-family:'Quicksand-Bold'">- {{ stock.last_out.qunt_remove }}</i> || <i style="font-family:'Quicksand-Regular-Oblique'">{{ this.formatDate(stock.last_out.dt_out) }}</i>
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
        if(this.stock.id){
          this.selected = this.stock;
          this.stk.status = 'active';
          this.stk.id = this.stock.id;
        }
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
            stk:{
              id:0,
              status:''
            }
          }
        },
        methods:{
          formatDate(date){
            const datestr = dayjs(date);
                // Then specify how you want your dates to be formatted
            return datestr.format('DD/MM/YYYY');
            },
          selectProduct(stock) {
            if(!this.stk.id || this.stk.id!=stock.id){
              this.selected = stock;
              this.stk.status = 'active';
              this.stk.id = stock.id;
              this.$emit('selected', stock);
            }else if(this.stk.id===stock.id){
              console.log(this.stk.id, stock.id)
              this.stk.status = '';
              this.stk.id = null;
              this.$emit('selected', {
                    last_entry:{
                      dt_entry:'0000-00-00',
                    }
                });
              console.log("vazio")

            }
          }
        }
    }
</script>