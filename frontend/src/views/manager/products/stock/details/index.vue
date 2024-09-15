<template>
    <main class="container-fluid d-flex flex-column align-items-center">
        <header class="logo-container" >
            <logoComponent module="products - stock"></logoComponent>
        </header>
        <div class="d-flex flex-column table-container">
            <span :class="`spinner ${this.spinner.status?'active':''}`" v-if="this.spinner.status" >
                <font-awesome-icon icon="spinner" spin />
            </span>
            <div v-if="!this.spinner.status" style="table-layout: fixed;">
                <tableMovimentComponent :stock="this.stockproduct"  :stocks="this.stockproduct.movements" @selected="(stock) =>{if(this.edit_status)return;this.selected=stock;}" @hovered="(stock) =>{if(this.edit_status)return;this.rawproductstock=stock;}"> </tableMovimentComponent>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-center col-12 footer">
            <div class="d-flex flex-column col-4 card-product">
            <div  class="d-flex flex-row justify-content-around title">
              <p class="name" title="Nome">{{this.stockproduct.name ? this.stockproduct.name : 'NENHUM PRODUTO SELECIONADO'}} </p>
              <p class="id" title="ID">#{{this.stockproduct.id ? this.stockproduct.id: '0'}}</p>
            </div>
            <div class="d-flex col-12 justify-content-between flex-row details">
              <p class="cost" title="(R$) Custo do Produto">R${{this.stockproduct.cost? parseFloat(this.stockproduct.cost).toFixed(2):'00,00'}}</p>
              <p>-</p>
              <p class="value" title="(R$) Valor do Produto">R${{this.stockproduct.value? parseFloat(this.stockproduct.value).toFixed(2):'00,00'}}</p>
              <p>-</p>
              <p class="amount" title="Quantidade Total">{{ this.stockproduct.product_amount ? (parseInt(this.stockproduct.product_amount) < 10 ? `0${parseInt(this.stockproduct.product_amount)}`:parseInt(this.stockproduct.product_amount)):'00' }} UN</p>
            </div>
            <div v-if="Object.keys(this.selected).length != 0"
             class="d-flex col-12 justify-content-between flex-row details total_sales" style="font-size: 15px;">
                <div class="d-flex col-12 justify-content-between flex-row" v-if="this.selected.type==='sale'">
                    <i class="title">Total de Vendas: </i>
                    <i class="unity" title="Quantidade Vendas (UN)" >{{ this.selected.quantity ? this.selected.quantity : '0' }}UN</i>
                    X<i class="value" title="Valor Produto (R$)" > R${{ this.selected.state.value ? this.selected.state.value: '00,00'}}</i>
                    <i title="Total de Venda (R$)">= 
                        <i class="value">
                            + R${{ this.selected.quantity && this.selected.state.value ? parseInt((this.selected.quantity * this.selected.state.value)).toFixed(2):""  }}
                        </i>
                    </i>
                </div>
                <div class="d-flex col-12 justify-content-between flex-row" v-if="this.selected.type==='entry'">
                    <i class="title">Total de Gastos: </i>
                    <i class="unity" title="Quantidade Entrada (UN)" >{{ this.selected.quantity ? this.selected.quantity : '0' }}UN</i>
                    X<i class="cost" title="Custo do Produto (R$)" > R${{ this.selected.state.cost ? parseFloat(this.selected.state.cost).toFixed(2):'00,00' }}</i>
                    <i title="Total de Custo (R$)">= 
                        <i class="unity">
                            - R${{ this.selected.quantity && this.selected.state.cost ? parseInt((this.selected.quantity * this.selected.state.cost)).toFixed(2):""  }}
                        </i>
                    </i>
                </div>
                <div class="d-flex col-12 justify-content-between flex-row" v-if="this.selected.type==='direct_out'">
                    <i class="title">Total Removidos: </i>
                    <i class="unity" title="Quantidade Vendas (UN)" >{{ this.selected.quantity ? this.selected.quantity : '0' }}UN</i>
                    X<i class="cost" title="Valor Produto (R$)" > R${{ this.selected.state.cost ? parseFloat(this.selected.state.cost).toFixed(2):'00,00' }}</i>
                    <i title="Total de Perca (R$)">= 
                        <i class="unity">
                            - R${{ this.selected.quantity && this.selected.state.cost ? parseInt((this.selected.quantity * this.selected.state.cost)).toFixed(2):""  }}
                        </i>
                    </i>
                </div>
            </div>
        </div>
        <div v-if="!this.edit_status" class="d-flex flex-column justify-content-center col-4 card-product cost-details">
            <div class="d-flex flex-row col-12 justify-content-between cost-title">
                <div class="d-flex col-7 title">
                    <p>Percentual de Lucro (%)</p>
                </div>
                <div class="d-flex justify-content-end col-4 dt_entry">
                    <p>{{ !this.selected.date? '00/00/0000' : this.formatDate(this.selected.date) }}</p>
                </div>  
            </div>
            <div class="d-flex flex-row justify-content-start col-12 cost-values">
                <div class="d-flex flex-column offset-1 col-3 column" >
                    <p class="row cost">R${{ Object.keys(this.selected).length === 0 ? parseFloat(this.stockproduct.cost).toFixed(2) : parseFloat(this.selected.state.cost).toFixed(2) }}</p>
                    <p class="row value">R${{ Object.keys(this.selected).length === 0 ? (parseFloat(this.stockproduct.cost) > parseFloat(this.stockproduct.value) ? parseFloat(this.stockproduct.cost) - parseFloat(this.stockproduct.value) : parseFloat(this.stockproduct.value) - parseFloat(this.stockproduct.cost)).toFixed(2) : (parseFloat(this.selected.state.cost) > parseFloat(this.selected.state.value) ? parseFloat(this.selected.state.cost) - parseFloat(this.selected.state.value) : parseFloat(this.selected.state.value) - parseFloat(this.selected.state.cost)).toFixed(2) }}</p>
                </div>
                <div class="d-flex flex-column col-1 column" >
                    <p class="simbol ">-</p>
                    <p class="simbol ">/</p>
                </div>
                <div class="d-flex flex-column col-3 column" >
                    <p class="row value">R${{ Object.keys(this.selected).length === 0 ? parseFloat(this.stockproduct.value).toFixed(2) : parseFloat(this.selected.state.value).toFixed(2) }}</p>
                    <p class="row cost">R${{ Object.keys(this.selected).length === 0 ? parseFloat(this.stockproduct.cost).toFixed(2) : parseFloat(this.selected.state.cost).toFixed(2) }}</p>
                </div>
                <div class="d-flex flex-column col-1 column" >
                    <p class="simbol">=</p>
                    <p class="simbol">=</p>
                </div>
                <div class="d-flex flex-column col-3 column" >
                    <p class="row value">R${{ Object.keys(this.selected).length === 0 ? (parseFloat(this.stockproduct.cost) > parseFloat(this.stockproduct.value) ? parseFloat(this.stockproduct.cost) - parseFloat(this.stockproduct.value) : parseFloat(this.stockproduct.value) - parseFloat(this.stockproduct.cost)).toFixed(2) : (parseFloat(this.selected.state.cost) > parseFloat(this.selected.state.value) ? parseFloat(this.selected.state.cost) - parseFloat(this.selected.state.value) : parseFloat(this.selected.state.value) - parseFloat(this.selected.state.cost)).toFixed(2) }}</p>
                    <p class="row value">{{ Object.keys(this.selected).length === 0 ? (parseFloat(this.stockproduct.cost) > parseFloat(this.stockproduct.value) ? ((parseFloat(this.stockproduct.cost) - parseFloat(this.stockproduct.value)) / this.stockproduct.cost * 100) : ((parseFloat(this.stockproduct.value) - parseFloat(this.stockproduct.cost)) / this.stockproduct.cost * 100)).toFixed(2) : (parseFloat(this.selected.state.cost) > parseFloat(this.selected.state.value) ? ((parseFloat(this.selected.state.cost) - parseFloat(this.selected.state.value)) / this.selected.state.cost * 100) : ((parseFloat(this.selected.state.value) - parseFloat(this.selected.state.cost)) / this.selected.state.cost * 100)).toFixed(2)}}%</p>
                </div>
            </div>

        </div>
        <div v-if="this.edit_status" class="d-flex flex-column justify-content-start col-4 card-product cost-details">
            <div class="d-flex justify-content-around col-12">
                <p>Nova Entrada: </p>
                <p>{{this.productstock.id}}# {{ this.productstock.name }}</p>
            </div>
            <div class="d-flex col-12 input-group" v-if="!this.send_data.out_entry">
                <input v-model.number="entry_data.qunt_toAdd" type="number" :class="`form-control`" required>
                <label for="">Quantidade da Entrada</label>
            </div>
            <div class="d-flex col-12 input-group" v-if="this.send_data.out_entry">
                <input v-model.number="out_data.qunt_remove" type="number" :class="`form-control`" required>
                <label for="">Quantidade de Saída</label>
            </div>
            <div class="d-flex col-12" v-if="!this.send_data.out_entry">
                <div class="d-flex col-5 input-group opz" style="width: 45%;">
                    <input v-model.number="entry_data.cost" type="number" :class="`form-control ${entry_data.cost ? 'disabled' : ''}`" :readonly="!entry_data.qunt_toAdd" required>
                    <label for="">Custo</label>
                </div>
                <div class="d-flex offset-1 col-5 input-group opz" style="width: 46.5%;">
                    <input v-model.number="entry_data.value" id="entry_value" type="number" :class="`form-control ${entry_data.value ? 'disabled' : ''}`" :readonly="!entry_data.qunt_toAdd" required>
                    <label for="">Valor</label>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column col-4 card-product">
                <stockMovementsActions 
                v-if="this.stockproduct"
                @paginate="(page) =>{this.paginate(page,7)}" 
                @newOut="(status) =>{this.newOut(status, null)}" 
                @newEntry="(status) =>{this.newEntry(status, null)}"
                @allMoviments="(stock) => {this.allMoviments(stock)}"
                @newOut_obj="(status) =>{this.newOut(status, this.out_data)}"
                @newEntry_obj="(status) =>{this.newEntry(status, this.entry_data)}"
                @cancel="(status) =>{this.edit_status=status}"

                :selected="this.selected"
                :productstock="this.productstock" 
                :stockproduct="this.stockproduct" 
                :edit_status="this.edit_status" 
                :disabled="this.disabled" 
                :currentpage="this.currentpage"
                :send_data="this.send_data"
                :out_data="this.out_data"/>
                
        </div>
    </div>
    </main>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
import logoComponent from '@/components/vue/logoComponent.vue';
import tableComponent from "@/components/vue/stockTableComponent/index.vue"
import stockActions from "@/components/vue/stockTableComponent/actions/index.vue"
import stockMovementsActions from "@/components/vue/stockMovimentsTableComponent/actions/index.vue"
import tableMovimentComponent from "@/components/vue/stockMovimentsTableComponent/index.vue"
import axios from 'axios'; 
import dayjs from 'dayjs';
export default{
        components:{logoComponent,tableComponent,tableMovimentComponent, stockActions, stockMovementsActions},
        data(){
            return{
                send_data:{
                    add_entry:false,
                    out_entry:false,
                },
                out_data:{},
                entry_data:{},
                edit_status:false,
                spinner:{status:false},
                stockproduct:{}, 
                selected:{},
                productstock:{last_entry:{dt_entry:'0000-00-00'}},
                rawproductstocks:[],
                rawproductstock:{
                    id:"0",
                    name:"NENHUM PRODUTO SELECIONADO",
                    value:"00,00",
                    cost:'00,00',
                    amount:"00",
                    last_entry:{
                      dt_entry:'0000-00-00',

                    },
                    last_sale:{},
                    last_out:{}
                },
                disabled:{
                    import:'disabled',
                    export:'disabled',
                    left:'disabled',
                    right:'disabled',
                    lines:'disabled',
                    pdf:'disabled',
                    ban:'disabled',
                    check:'disabled',
                    edit:'disabled',
                    out:'disabled',
                    entry:'disabled'
                },
                currentpage:1,
                lastpage:0,
                totalpage:0,
            }
        },
        watch:{
            
            edit_status(newValue){
                this.add_entry = newValue;
                if(newValue){
                    this.disabledAll();
                    this.disabled.ban = ''
                    this.disabled.check = ''
                }else{
                    this.entry_data.qunt_toAdd = null;
                    this.paginate(this.currentpage, 7)
                }
            },
            productstock(newValue){
               
                if(Object.keys(this.productstock).length!=1){
                    this.enabledAll()
                }if(Object.keys(this.productstock).length==1){
                    this.enabledAll()
                    if(this.currentpage===1){
                        this.disabled.left="disabled"
                    }
                    if(this.currentpage===this.lastpage){
                        this.disabled.right="disabled"
                    }
                    this.disabled.lines="disabled";
                    this.disabled.pdf="disabled";
                }
            }
        },
        computed:{
            stockproducts() {
        const stockMap = new Map();

        this.rawproductstocks.forEach(product => {
            // Função para agrupar por data e somar os valores
            const groupByDateAndSum = (items, dateField, sumField, type) => {
                return items.reduce((acc, item) => {
                    const date = new Date(item[dateField]).toISOString().split('T')[0]; // Comparar apenas a data
                    if (!acc[date]) {
                        acc[date] = { 
                            date,
                            type, 
                            quantity: item[sumField]
                        };
                    } else {
                        acc[date].quantity += item[sumField]; // Somar os valores do campo de quantidade
                    }
                    return acc;
                }, {});
            };

            // Agrupando entradas, saídas e vendas
            const groupedEntries = groupByDateAndSum(product.entries, 'dt_entry', 'qunt_toAdd', 'entry');
            const groupedOut = groupByDateAndSum(product.direct_out, 'dt_out', 'qunt_remove', 'out');
            const groupedSales = groupByDateAndSum(product.sales_out, 'dt_sale', 'qunt_remove', 'sale');

            // Mesclar todos os grupos em um único array
            const mergedStock = Object.values({ ...groupedEntries, ...groupedOut, ...groupedSales });

            // Ordenar pela data
            const sortedStock = mergedStock.sort((a, b) => new Date(b.date) - new Date(a.date));

            // Inserir no Map do produto
            stockMap.set(product.id, {
                id: product.id,
                name: product.name,
                value: product.value,
                amount: product.product_amount,
                cost: product.cost,
                stockMovements: sortedStock  // Armazena os movimentos de estoque
            });
        });
        return Array.from(stockMap.values());
    },
            productstocks() {
                const stockMap = new Map();
                this.rawproductstocks.forEach(product => {
                    const groupByDateAndSum = (items, dateField, sumField) => {
                        return items.reduce((acc, item) => {
                            const date = new Date(item[dateField]).toISOString().split('T')[0]; // Comparar apenas as datas (ignorando o tempo)
                            if (!acc[date]) {
                                acc[date] = { ...item };
                            } else {
                                acc[date][sumField] += item[sumField]; // Somar os valores do campo de quantidade
                            }
                            return acc;
                        }, {});
                    };

                    const groupedOut = groupByDateAndSum(product.direct_out, 'dt_out', 'qunt_remove');
                    const groupedEntry = groupByDateAndSum(product.entries, 'dt_entry', 'qunt_toAdd');
                    const groupedSale = groupByDateAndSum(product.sales_out, 'dt_sale', 'qunt_remove');

                    // Extrair o último objeto dos arrays "direct_out", "entries" e "sales_out"
                    const lastOut = Object.values(groupedOut).length ? Object.values(groupedOut).reduce((latest, current) => 
                        new Date(current.dt_out) > new Date(latest.dt_out) ? current : latest) : {};

                    const lastEntry = Object.values(groupedEntry).length ? Object.values(groupedEntry).reduce((latest, current) => 
                        new Date(current.dt_entry) > new Date(latest.dt_entry) ? current : latest) : {};

                    const lastSale = Object.values(groupedSale).length ? Object.values(groupedSale).reduce((latest, current) => 
                        new Date(current.dt_sale) > new Date(latest.dt_sale) ? current : latest) : {};

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
        async created(){
            
            this.paginate(1,7);
            
        },
        methods:{
            async allMoviments(stock){
                this.stockproduct = this.stockproducts[this.stockproducts.findIndex(raw => raw.id === stock.id)];
                const array = [];
                this.stockproduct.stockMovements.forEach(st =>{
                    array.push({
                        id: this.stockproduct.id,
                        name: this.stockproduct.name,
                        value: this.stockproduct.value,
                        amount: this.stockproduct.product_amount,
                        cost: this.stockproduct.cost,
                        date: st.date,
                        quantity:st.quantity,
                        type:st.type
                    })
                    
                });
                this.stockproduct.stockMovements = array;
                
            },
            async newEntry(status, entry){
                if(!entry){
                    this.edit_status = status;
                    this.send_data.out_entry = false;
                    this.send_data.add_entry = true;
                    this.entry_data.cost = this.productstock.cost;
                    this.entry_data.value = this.productstock.value;
                    this.$forceUpdate();
                }else{
                    const {data} = await axios.post("manager/products/update/"+this.productstock.id,{cost:entry.cost,value:entry.value,product_amount:parseInt(this.productstock.amount)+parseInt(this.entry_data.qunt_toAdd)});
                    this.edit_status=false;
                    this.productstock.amount = parseInt(this.productstock.amount)+parseInt(this.entry_data.qunt_toAdd);
                    this.paginate(this.currentpage, 7)
                }
            },
            async newOut(status, out){
                
                if(!out){
                    this.edit_status = status;
                    this.send_data.out_entry = true;
                    this.send_data.add_entry = false;
                    this.$forceUpdate();
                }else{
                    const {data} = await axios.post("manager/products/update/"+this.productstock.id,{product_amount:parseInt(this.productstock.amount)-parseInt(this.out_data.qunt_remove)});
                    this.edit_status=status;
                    this.productstock.amount = parseInt(this.productstock.amount)-parseInt(this.out_data.qunt_remove);
                    this.paginate(this.currentpage, 7)
                }
            }, 
             formatDate(date){
            const datestr = dayjs(date);
                // Then specify how you want your dates to be formatted
            return datestr.format('DD/MM/YYYY');
            },
            async paginate(index,$perpage){
                this.spinner.status=true;
                try {
                    this.disabledAll();
                    const {data} = await axios.get(`manager/products/stock/${this.$route.params.id}/${index}/${$perpage}`)
                    this.stockproduct = data.product;
                    this.currentpage = data.product.movements.current_page;
                    this.lastpage = data.product.movements.last_page
                    this.totalpage = data.product.movements.total
                    this.stockproduct.movements = data.product.movements.data;
                } catch (err) {
                    console.error('Erro ao carregar produtos:', err);
                }finally{
                    this.spinner.status=false;
                    this.enabledAll();
                    if(Object.keys(this.productstock).length==1){
                        if(this.currentpage===1){
                            this.disabled.left="disabled"
                        }
                        if(this.currentpage===this.lastpage){
                            this.disabled.right="disabled"
                        }
                        this.disabled.lines="disabled";
                        this.disabled.pdf="disabled";
                    }
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
                this.disabled.import=""
                this.disabled.export=""
                this.disabled.pdf=""
                this.disabled.ban=""
                this.disabled.lines=""
                this.disabled.left=""
                this.disabled.right=""
                this.disabled.check=""
                this.disabled.edit=""
                this.disabled.out=""
                this.disabled.entry=""
            },
            async disabledAll(){
                this.disabled.import="disabled"
                this.disabled.export="disabled"
                this.disabled.pdf="disabled"
                this.disabled.ban="disabled"
                this.disabled.lines="disabled"
                this.disabled.left="disabled"
                this.disabled.right="disabled"
                this.disabled.check="disabled"
                this.disabled.edit="disabled"
                this.disabled.out="disabled"
                this.disabled.entry="disabled"
            },
            
        }
    }
</script>
