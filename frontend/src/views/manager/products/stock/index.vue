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
          <tableComponent v-if="Object.keys(stockproduct).length === 0" :stock="this.productstock"  :stocks="productstocks" @selected="(stock) =>{if(this.edit_status)return;this.productstock=stock;}" @hovered="(stock) =>{if(this.edit_status)return;this.rawproductstock=stock;}"> </tableComponent>
          <tableMovimentComponent v-if="Object.keys(stockproduct).length !== 0" :stock="this.stockproduct"  :stocks="this.stockproduct.stockMovements" @selected="(stock) =>{if(this.edit_status)return;this.stockproduct.stockMovements=stock;}" @hovered="(stock) =>{if(this.edit_status)return;this.rawproductstock=stock;}"> </tableMovimentComponent>
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
        <div v-if="!this.edit_status" class="d-flex flex-column justify-content-center col-4 card-product cost-details">
            <div class="d-flex flex-row col-12 justify-content-between cost-title">
                <div class="d-flex col-7 title">
                    <p>Percentual de Lucro (%)</p>
                </div>
                <div class="d-flex justify-content-end col-4 dt_entry">
                    <p>{{ this.productstock.last_entry.dt_entry==='0000-00-00' ? '00/00/0000' : this.formatDate(this.productstock.last_entry.dt_entry) }}</p>
                </div>  
            </div>
            <div class="d-flex flex-row justify-content-start col-12 cost-values">
                <div class="d-flex flex-column offset-1 col-3 column" >
                    <p class="row cost">R${{ this.productstock.cost ? this.productstock.cost: '00,00' }}</p>
                    <p class="row value">R${{ this.productstock.value&&this.productstock.cost ? (this.productstock.value - this.productstock.cost).toFixed(2): '00,00' }}</p>
                    <p class="row unity">{{ this.productstock.total_sales ? this.productstock.total_sales: '00' }}UN</p>
                </div>
                <div class="d-flex flex-column col-1 column" >
                    <p class="simbol ">-</p>
                    <p class="simbol ">/</p>
                    <p class="simbol ">X</p>
                </div>
                <div class="d-flex flex-column col-3 column" >
                    <p class="row value">R${{ this.productstock.value ? this.productstock.value: '00,00' }}</p>
                    <p class="row cost">R${{ this.productstock.cost ? this.productstock.cost: '00,00' }}</p>
                    <p class="row value">R${{ this.productstock.value&&this.productstock.cost ? (this.productstock.value - this.productstock.cost).toFixed(2): '00,00' }}</p>
                </div>
                <div class="d-flex flex-column col-1 column" >
                    <p class="simbol">=</p>
                    <p class="simbol">=</p>
                    <p class="simbol">=</p>
                </div>
                <div class="d-flex flex-column col-3 column" >
                    <p class="row value">R${{ this.productstock.value&&this.productstock.cost ? (this.productstock.value - this.productstock.cost).toFixed(2): '00,00' }}</p>
                    <p class="row value">{{ this.productstock.value&&this.productstock.cost ? (this.productstock.value - this.productstock.cost).toFixed(2) / this.productstock.cost *100: '00,00' }}%</p>
                    <p class="row value">R${{ this.productstock.total_sales &&this.productstock.value&&this.productstock.cost ? ((this.productstock.value - this.productstock.cost) * this.productstock.total_sales).toFixed(2): '00' }}</p>
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
            <div class="d-flex align-items-center justify-content-between flex-row col-12 actions">
                <span
                    v-if="this.productstock.id"
                    title="Adicionar nova Entrada"
                    :class="`btn btn-primary ${this.disabled.import}`"
                    @click="newEntry(!this.edit_status, null);">
                <font-awesome-icon icon="file-import"></font-awesome-icon>
              </span>
              <span
                    v-if="!this.productstock.id"
                    title="Página Anterior"
                    :class="`btn btn-primary ${this.disabled.left}`"
                    @click="this.paginate(parseInt(this.currentpage)-1,7)">
                <font-awesome-icon icon="arrow-left"></font-awesome-icon>
              </span>
              <span
              title="Adicionar nova Saída"
              v-if="this.productstock.id"
              :class="`btn btn-primary ${this.disabled.export}`"
              @click="this.newOut(!edit_status, null)">
                <font-awesome-icon icon="file-export"></font-awesome-icon>
              </span>
              <span
              title="Próxima Página"
              v-if="!this.productstock.id"
              :class="`btn btn-primary ${this.disabled.right}`"
              @click="this.paginate(parseInt(this.currentpage)+1,7)">
                <font-awesome-icon icon="arrow-right"></font-awesome-icon>
              </span>

              <!--LIST-->
              <span
               v-if="!this.edit_status"
              title="Exibir tudo (entradas, saídas e vendas)"
              :class="`btn btn-primary ${this.disabled.lines}`"
              @click="allMoviments(this.productstock)">
                <font-awesome-icon icon="file-lines"></font-awesome-icon>
              </span>
              
              <span
                v-if="this.edit_status&&this.send_data.add_entry===false"
              :class="`btn btn-success out ${this.disabled.check}`"
              @click="newOut(!this.edit_status, this.out_data)">
                <font-awesome-icon icon="check"></font-awesome-icon>
              </span>
              <span
                v-else-if="this.edit_status&&this.send_data.add_entry===true"
              :class="`btn btn-success add_entry ${this.disabled.check}`"
              @click="newEntry(!this.edit_status, this.entry_data)">
                <font-awesome-icon icon="check"></font-awesome-icon>
              </span>
              <!--newOut(!this.edit_status, this.out_data)EXPORT ALL-->
              <span
              v-if="!this.edit_status"
              title="Exportar tudo (entradas, saídas e vendas)"
              :class="`btn btn-primary ${this.disabled.pdf}`"
              @click="">
                <font-awesome-icon icon="file-pdf"></font-awesome-icon>
              </span>
              <span 
              v-if="this.edit_status"
              :class="`btn btn-danger ${this.disabled.ban}`"
              @click="this.edit_status=false">
                <font-awesome-icon icon="ban"></font-awesome-icon>
              </span>
            </div>
        </div>
    </div>
</main>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
import logoComponent from '@/components/vue/logoComponent.vue';
import tableComponent from "@/components/vue/stockTableComponent/index.vue"
import tableMovimentComponent from "@/components/vue/stockMovimentsTableComponent/index.vue"
import axios from 'axios'; 
import dayjs from 'dayjs';
    export default{
        components:{logoComponent,tableComponent,tableMovimentComponent},
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
                    console.log("habilitadas")
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
                return console.log(this.stockproduct.stockMovements);;
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
                    console.log(entry);
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
                    console.log(out);
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
                    const {data} = await axios.get(`manager/products/${index}/${$perpage}`)
                    this.rawproductstocks = data.data;
                    this.currentpage = data.current_page;
                    this.lastpage = data.last_page
                    this.totalpage = data.total
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
            },
            
        }
    }
</script>