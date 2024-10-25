<template>
    <main class="d-flex flex-column col-10 offset-1" >
        <div class="d-flex flex-row col-12 justify-content-end new-prd">
            <span class="btn btn-primary" @click="">Novo Produto</span>
        </div>
        <div class="d-flex flex-column col-12 table-container" style="background-color: red;">
            <span :class="`spinner ${this.spinner.status?'active':''}`" v-if="this.spinner.status" >
                <font-awesome-icon icon="spinner" spin />
            </span>
            <div class="col-12" v-if="!this.spinner.status">
                <tableComponent  :product="this.product"  :products="this.rawproducts" @selected="(product) =>{if(this.edit_status.status)return;selected(product);}" @hovered="(product) =>{if(this.edit_status.status)return;this.rawproduct=product;}"/>
            </div>
        </div>
        <div class="d-flex flex-row col-12 footer">
            <div class="d-flex flex-column col-3 card-product">
                <div v-if="!this.edit_status.status" class="d-flex flex-row justify-content-between title">
                    <p class="name" title="Nome">{{this.product.name ? this.product.name : this.rawproduct.name}} </p>
                    <p class="id" title="ID">#{{this.product.id ? this.product.id: this.rawproduct.id}}</p>
                </div>
                <div v-if="!this.edit_status.status"
                    class="d-flex col-12 justify-content-between flex-row details">
                    <p class="sm_code" title="Código Reduzido">{{this.product.sm_code? this.product.sm_code:this.rawproduct.sm_code}}</p>
                    <p>-</p>
                    <p class="cost" title="(R$) Custo do Produto">R${{this.product.cost? this.product.cost:this.rawproduct.cost}}</p>
                    <p>-</p>
                    <p class="amount" title="Quantidade Total">{{ this.product.product_amount? this.product.product_amount:this.rawproduct.product_amount }} UN</p>
                </div>
                <div class="d-flex flex-row col-12">
                    <div v-if="!this.edit_status.status"
                    class="d-flex col-8 justify-content-between flex-row bar-code">
                        <p title="Código de Barras">{{ this.product.bar_code? this.product.bar_code:this.rawproduct.bar_code }}</p>
                    </div>
                    <div v-if="!this.edit_status.status" 
                    class="d-flex col-4 justify-content-between flex-row value">
                        <p title="(R$) Valor">R${{ this.product.value? this.product.value:this.rawproduct.value }}</p>
                    </div>
                    <div v-if="this.edit_status.status"
                    class="d-flex col-8 justify-content-between flex-row bar-code">
                        <input id="bar_code" placeholder="Código de Barras" title="Código de Barras" type="text" v-model="editingPrd['bar_code']" class="col-8 form-control">
                    </div>
                    <div v-if="this.edit_status.status" class="d-flex col-4 justify-content-between flex-row value">
                        <input id="value" type="number"  placeholder="Valor" title="(R$) Valor do Produto" v-model.number="editingPrd['value']" class="col-4 form-control">
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column col-4 card-product">
                <div class="d-flex flex-row title">
                    <p>Descrição do Produto:</p>
                </div>
                <div v-if="!this.edit_status.status" 
                    class="d-flex flex-row flex-wrap description">
                    <text>{{ this.product.description? this.product.description: this.rawproduct.description }}</text>
                </div>
                <div v-if="this.edit_status.status===true" 
                    class="d-flex flex-row flex-wrap description">
                    <text>EDITANDO GUYS</text>
                </div>
            </div>
            <div class="d-flex flex-column col-4 card-product">
                <actions
                @paginateGet="(products) =>{this.rawproducts=products}"
                @spinner="(status) =>{this.spinner.status=status}"
                @editing="(status) =>{this.edit_status.status=status; console.log('isEditing?', this.edit_status)}"

                :product="this.product"
                :products="this.products"
                :edit_status="this.edit_status"
                />
            </div>
        </div>
    </main>
</template>
<style src="./new_style.scss" lang="scss" scoped></style>

<script>
import axios from 'axios';
import tableComponent from  "@/components/vue/tableComponent/index.vue"
import actions from "@/components/vue/tableComponent/actions/index.vue";
    export default{
        watch:{
            /* edit_status(newValue){
                console.log('editwar', newValue);
                this.edit_status=newValue;
            } */
        },
        components:{tableComponent, actions},
        data(){
            return{
                product:{},
                rawproduct:{},
                rawproducts:[],
                edit_status:{status:false},
                spinner:{status:false}
            }
        },
        methods:{
            async newProduct(status){
                this.edit_status=status
                if(this.edit_status){
                    if(Object.keys(this.product)!=0){
                    this.product={};
                    }
                    this.disabledAll();
                    this.disabled.check=''
                    this.disabled.ban=''
                    this.product_copy=true;
                }else{
                    this.paginate(this.currentpage, 7)
                    this.edit_status=false;
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
            
            async selected(product){
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
        },
        computed:{
            products(){
                const productMap = new Map();
                this.rawproducts.forEach(product => {
                    const key = `${product.bar_code}-${product.sm_code}-${product.name}`;
                    if (productMap.has(key)) {
                    const prd = productMap.get(key);
                    } else {
                        productMap.set(key, {
                        ...product
                        });
                    }
                });
                return Array.from(productMap.values());
            }
        },
    }
</script>