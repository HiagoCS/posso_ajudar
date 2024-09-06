<template>
<main class="container-fluid d-flex flex-column align-items-center">
    <header class="logo-container" >
        <logoComponent module="products - stock"></logoComponent>
    </header>
    <div class="d-flex flex-column table-container">
        <span :class="`spinner ${this.spinner.status?'active':''}`" v-if="this.spinner.status" >
            <font-awesome-icon icon="spinner" spin />
        </span>
        <div v-if="!this.spinner.status">
          <tableComponent :stock="this.productstock"  :stocks="productstocks" @selected="(stock) =>{this.productstock=stock}" @hovered="(stock) =>{this.rawproductstock=stock;}"> </tableComponent>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-center col-12 footer">
        <div class="d-flex flex-column col-4 card-product">
            <div  class="d-flex flex-row justify-content-around title">
              <p class="name" title="Nome">{{this.productstock.name ? this.productstock.name : this.rawproductstock.name}} </p>
              <p class="id" title="ID">#{{this.productstock.id ? this.productstock.id: this.rawproductstock.id}}</p>
            </div>
            <div class="d-flex col-12 justify-content-between flex-row details">
              <p class="cost" title="(R$) Custo do Produto">R${{this.productstock.cost? this.productstock.cost:this.rawproductstock.cost}}</p>
              <p>-</p>
              <p class="value" title="(R$) Valor do Produto">R${{this.productstock.value? this.productstock.value:this.rawproductstock.value}}</p>
              <p>-</p>
              <p class="amount" title="Quantidade Total">{{ this.productstock.amount? this.productstock.amount:this.rawproductstock.product_amount }} UN</p>
            </div>
            <div class="d-flex col-12 justify-content-between flex-row details total_sales" style="font-size: 15px;">
                <i class="title">Total de Vendas: </i>
                <i class="unity" title="Quantidade Vendas (UN)" >{{ this.productstock.total_sales ? this.productstock.total_sales : '0' }}UN</i>
                X<i class="value" title="Valor Produto (R$)" > R${{ this.productstock.value ? this.productstock.value:this.rawproductstock.value }}</i>
                <i title="Total de Venda (R$)">= R${{ this.productstock.total_sales? parseInt((this.productstock.total_sales * this.productstock.value)).toFixed(2):""  }}</i>
            </div>
        </div>
        <div class="d-flex flex-column col-4 card-product">
            
        </div>

        <div class="d-flex flex-column col-4 card-product">
            <h4>HelloWorld</h4>
        </div>
    </div>
</main>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
import logoComponent from '@/components/vue/logoComponent.vue';
import tableComponent from "@/components/vue/stockTableComponent/index.vue"
import axios from 'axios';
    export default{
        components:{logoComponent,tableComponent},
        computed:{
            productstocks() {
                const stockMap = new Map();
                this.rawproductstocks.forEach(product => {
                    // Extrair o último objeto dos arrays "direct_out", "entries" e "sales_out"
                    const lastOut = product.direct_out.length !=0 ? product.direct_out.reduce((latest, current) => 
                        new Date(current.dt_out) > new Date(latest.dt_out) ? current : latest) : [];

                    const lastEntry = product.entries.length !=0 ? product.entries.reduce((latest, current) => 
                        new Date(current.dt_entry) > new Date(latest.dt_entry) ? current : latest) : [];

                    const lastSale = product.sales_out.length !=0 ? product.sales_out.reduce((latest, current) => 
                        new Date(current.dt_sale) > new Date(latest.dt_sale) ? current : latest) : [];

                    const totalSales = product.sales_out.length !=0 ? product.sales_out.reduce((total, current) => 
                        total + current.qunt_remove, 0) : 0;

                    const salesAfterEntry = product.sales_out.length !=0 ? product.sales_out
                        .filter(sale => new Date(sale.dt_sale) >= new Date(lastEntry.dt_entry)) // Filtra as vendas após a última entrada
                        .reduce((total, current) => total + current.qunt_remove, 0) : 0;

                    const key = `${product.id}-${product.name}-${product.value}-${product.product_amount}-${product.cost}-${product.last_entry}-${product.last_sale}-${product.last_out}`;
                    product = {
                        id: product.id,      // ID do produto
                        name: product.name,          // Nome do produto
                        value: product.value,        // Valor do produto
                        amount: product.product_amount,
                        cost:product.cost,      // Quantidade do produto
                        last_entry: {
                            ...lastEntry,
                            sales_after_entry: salesAfterEntry 
                        },    
                        last_sale: lastSale,         // Última venda
                        last_out: lastOut,// Última saída direta
                        total_sales:totalSales,
                        total_cost: (lastEntry.qunt_toAdd * product.cost) 
                    }
                    if (stockMap.has(key)) {
                        const prd = stockMap.get(key);
                    } else {
                        stockMap.set(key, {
                            ...product
                        });
                    }
                });
                return Array.from(stockMap.values());
            }
        },
        data(){
            return{
                edit_status:false,
                spinner:{status:false},
                productstock:{
                    id:"",
                    name:"",
                    value:"",
                    amount:"",
                    last_entry:{},
                    last_sale:{},
                    last_out:{}
                },
                rawproductstocks:[],
                rawproductstock:{},
                disabled:{
                    plus:'disabled',
                    minus:'disabled',
                    edit:'disabled',
                    copy:'disabled',
                    ban:'disabled',
                    left:'disabled',
                    right:'disabled',
                    check:'disabled'
                },
                currentpage:1,
                lastpage:0,
                totalpage:0,
            }
        },
        async created(){
            this.paginate(1,7);
        },
        methods:{
            async paginate(index,$perpage){
                this.spinner.status=true;
                try {
                    this.disabledAll();
                    const {data} = await axios.get(`manager/products/${index}/${$perpage}`)
                    this.rawproductstocks = data.data;
                    this.currentpage = data.current_page;
                    this.lastpage = data.last_page
                    this.totalpage = data.total
                } catch (err) {
                    console.error('Erro ao carregar produtos:', err);
                }finally{
                    this.spinner.status=false;
                    console.log(this.productstocks);
                }
            },
            async selected(stock){
                this.productstock=stock;
                if(Object.keys(this.product).length==0){
                    this.product=product
                }else{
                    if(this.product.id===product.id){
                        this.product={}
                    }else{
                        this.product=product
                    }
                }
            },
            async enabledAll(){
                this.disabled.plus=""
                this.disabled.minus=""
                this.disabled.edit=""
                this.disabled.ban=""
                this.disabled.copy=""
                this.disabled.left=""
                this.disabled.right=""
                this.disabled.check=""
            },
            async disabledAll(){
                this.disabled.plus="disabled"
                this.disabled.minus="disabled"
                this.disabled.edit="disabled"
                this.disabled.ban="disabled"
                this.disabled.copy="disabled"
                this.disabled.left="disabled"
                this.disabled.right="disabled"
                this.disabled.check="disabled"
            },
            
        }
    }
</script>