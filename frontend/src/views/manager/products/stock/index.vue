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
          <tableComponent :stock="this.stock"  :stocks="productstocks" @selected="(stock) =>{if(this.edit_status)return;selected(stock)}" @hovered="(stock) =>{if(this.edit_status)return;this.rawproductstock=stock;}"> </tableComponent>
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
                    const lastOut = product.direct_out.reduce((latest, current) => 
                        new Date(current.dt_out) > new Date(latest.dt_out) ? current : latest);

                    const lastEntry = product.entries.reduce((latest, current) => 
                        new Date(current.dt_entry) > new Date(latest.dt_entry) ? current : latest);

                    const lastSale = product.sales_out.reduce((latest, current) => 
                        new Date(current.dt_sale) > new Date(latest.dt_sale) ? current : latest);

                    const key = `${product.id}-${product.name}-${product.value}-${product.last_entry}-${product.last_sale}-${product.last_out}`;
                    product = {
                        id: product.id,      // ID do produto
                        name: product.name,          // Nome do produto
                        value: product.value,        // Valor do produto
                        amount: product.product_amount,      // Quantidade do produto
                        last_entry: lastEntry,       // Última entrada
                        last_sale: lastSale,         // Última venda
                        last_out: lastOut            // Última saída direta
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
                if(Object.keys(this.productstock).length==0){
                    this.productstock=stock
                    this.disabled.plus=""
                    this.disabled.minus=""
                    this.disabled.edit=""
                    this.disabled.ban=""
                    this.disabled.copy=""
                }else{
                    if(this.productstock.id===productstock.id){
                        this.stock={}
                        if(this.currentpage==1) this.disabled.plus='disabled';
                        else this.disabled.plus='';
                        if(this.lastpage==0||this.currentpage==this.lastpage) this.disabled.minus='disabled';
                        else this.disabled.minus='';
                        this.disabled.edit="disabled"
                        this.disabled.ban="disabled"
                        this.disabled.copy="disabled"
                    }else{
                        this.stock=stock
                        this.disabled.plus=""
                        this.disabled.minus=""
                        this.disabled.edit=""
                        this.disabled.ban=""
                        this.disabled.copy=""
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