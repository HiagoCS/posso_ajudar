<template>
    <main>
      <div class="d-flex flex-column col-12">
        <div class="d-flex flex-row col-12">
          <logoComponent :module="this.$route.name"></logoComponent>
        </div>
        <div class="d-flex flex-row col-12">
          <!--SELETOR DE MESA-->
        </div>
        <div class="d-flex flex-column align-items-center">
          <div class="d-flex flex-row cashier-table">
            <div class="d-flex col-12 flex-row act" >
              <span class="d-flex justify-content-center col-1 act-btn">
                <font-awesome-icon icon="filter"/>
              </span>
              <span class="d-flex justify-content-center col-1 act-btn">
                <font-awesome-icon icon="ban"/>
              </span>
              <searchComponent placeholder="Código de Barras" search-term="bar_code" @result="(resul) =>{ this.rawproducts.push(resul)}"></searchComponent>
              <searchComponent placeholder="Código Reduzido" search-term="sm_code" @result="(resul) =>{ this.rawproducts.push(resul)}"></searchComponent>
              <searchComponent placeholder="Produto" search-term="name" @result="(resul) =>{this.rawproducts.push(resul)}"></searchComponent>
            </div>
          </div>
          <div class="d-flex flex-row cashier-table product-table-container">
            <span class="spinner" >
                  <font-awesome-icon icon="spinner" spin />
                </span>
            <div class="table-wrapper">
              <productsTableComponent  ref="productsTableComponent" :rawproducts="rawproducts"  :products="this.products" @index="(index)=>{this.tbIndex=index}">
                <div class="d-flex col-12 justify-content-between flex-row ">
                  <span :class="`btn ${this.products[this.tbIndex].quantity < this.products[this.tbIndex].product_amount ? 'btn-primary' : 'btn-primary disabled'} col-3`"
                    @click="()=>{this.rawproducts.push(this.products[this.tbIndex])}"
                  ><font-awesome-icon icon="plus"/>
                  </span>
                  <span 
                    :class="`btn ${this.products[this.tbIndex].quantity > 1 ? 'btn-secondary' : 'btn-secondary disabled'} col-3 `"
                    @click="()=>{this.rawproducts.splice(this.rawproducts.findIndex(raw => raw.id === this.products[this.tbIndex].id), 1);}">
                    <font-awesome-icon icon="minus"/>
                  </span>
                  <span class="d-flex justify-content-center align-items-center btn btn-warning col-3" @click="()=>{if(!this.products[this.tbIndex].editing)startEditing(this.products[this.tbIndex], this.tbIndex);else this.$refs.productsTableComponent.stopEditing(this.products[this.tbIndex], this.tbIndex);}">
                    <font-awesome-icon icon="r"/>
                    <font-awesome-icon icon="dollar-sign"/>
                  </span>
                  <span class="btn btn-danger col-3" @click="()=>{
                      for(let i = this.rawproducts.length - 1; i >= 0; i--) {
                          if(this.rawproducts[i].id === this.products[this.tbIndex].id)this.rawproducts.splice(i, 1);
                      }
                  }">
                    <font-awesome-icon icon="ban"/>
                  </span>
                </div>
                               
                    
              </productsTableComponent>
            </div>
          </div>
          <div class="d-flex flex-row cashier-table act-footer">
            <div class="d-flex col-4 flex-column align-items-center justify-content-center total-item">
              <span class="title">Total</span>
              <span class="total">R${{ total_value.toFixed(2) }}</span>
            </div>
            <div class="d-flex col-3 offset-1 flex-column justify-content-between info-sale">
              <div class="d-flex col-12 input-group autocomplete">
                <clientsSearchComponent @returnClients="(client) =>{this.client=client}"/>
              </div>
              <div class="d-flex col-12 input-group autocomplete pg">
                <pgMethodsComponent @returnPayment="(pgmethod) =>{this.pgmethod=pgmethod}"/>
              </div>
            </div>
            <div class="d-flex col-2 offset-1 flex-column justify-content-between" style="padding:1vh 1vw 1vh 1vw">
              <button class="btn btn-primary" @click="finalize()">Finalizar</button>
              <button class="btn btn-primary">Buscar Clientes</button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </template>
<script>
import logoComponent from '@/components/vue/logoComponent.vue';
import searchComponent from "@/components/vue/productsSearch/index.vue";
import pgMethodsComponent from "@/components/vue/pgMethodsSearch/index.vue";
import clientsSearchComponent from "@/components/vue/clientsSearch/index.vue";
import productsTableComponent from "@/components/vue/productsTable/index.vue";
import axios from 'axios';
import Swal from 'sweetalert2';
export default{
  components:{logoComponent, searchComponent, pgMethodsComponent, clientsSearchComponent,productsTableComponent},
  methods:{
    startEditing(product, index) {
      this.products[index].editing = true;
      $(`span.${index}`).css("display","none");
      $(`input.form-control.${index}`).css("display","flex");
      this.refreshKey++;
          this.$forceUpdate();
      product.new_value = product.new_value || product.value;
    },
    async stopEditing(product) {
       
       this.$forceUpdate();
      try{
        if(product.value) {
        axios.post(`/manager/products/update/${product.id}`,{"value":product.value})
        .then(() => {
          const index = this.rawproducts.findIndex(raw => raw.id === product.id);
          this.rawproducts.forEach(async(raw, index) =>{
            
            if(raw.id==product.id)
            this.rawproducts[index].status = "0";
          });
          $(".spinner").addClass('active');
          this.rawproducts.forEach(async (raw, index) =>{
            const {data} = await axios.get(`/manager/products/search/id/${raw.id}`);
            this.rawproducts[index].value = data.id.value;
          });
          console.log('this.rawproducts',this.rawproducts);
          $(`span.${index}`).css("display","flex");
          $(`input.form-control.${index}`).css("display","none");
          this.rawproducts.forEach(async (raw, index) =>{
            if(raw.id==product.id)
              await setTimeout(()=>{$(".spinner.active").removeClass('active');}, 800);
              await setTimeout(()=>{this.rawproducts[index].status = "1"}, 800);
              
          });
        }).catch(err => console.log(err));
      }
      } catch (error) {
        console.error(error);
      }
    },
    validateCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
      return false;
    }
    let sum = 0, mod;
    for (let i = 1; i <= 9; i++) {
      sum += parseInt(cpf.substring(i-1, i)) * (11 - i);
    }
    mod = (sum * 10) % 11;
    if (mod == 10 || mod == 11) mod = 0;
    if (mod != parseInt(cpf.substring(9, 10))) return false;
    sum = 0;
    for (let i = 1; i <= 10; i++) {
      sum += parseInt(cpf.substring(i-1, i)) * (12 - i);
    }
    mod = (sum * 10) % 11;
    if (mod == 10 || mod == 11) mod = 0;
    return mod == parseInt(cpf.substring(10, 11));
  },
    async finalize(){

      const prdArray = this.products.map(product => {
        
        return {
          id: product.id,
          qunt: product.quantity
        }
    });
      if (!this.pgmethod.id) {
        document.querySelector('.pg').style.borderColor = 'red';
        document.querySelector('.pg-label').style.color = 'red'; // Deixa o label vermelho
        return; // Barrar o envio
      } else {
       document.querySelector('.pg').style.borderColor = 'black';
       document.querySelector('.pg-label').style.color = ''; // Reseta o estilo se estiver preenchido
      }

      if (this.client.name && !this.client.cpf) {
        const { value: cpf } = await Swal.fire({
        title: 'Adicionar CPF?',
        text: "Você deseja adicionar o CPF do cliente?",
        input: 'text',
        inputPlaceholder: 'Insira o CPF',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
        inputValidator: (value) => {
          if (!value) {
            return 'O CPF é necessário!'
          } else if (!this.validateCPF(value)) { // Função para validar CPF
            return 'CPF inválido!'
          }
        }
      });
      if (cpf) {
        this.client.cpf = cpf;
      } else {
        this.client.cpf = null; // Barrar o envio se o CPF não for fornecido
      }
      }

      const request = {
        "total_value":this.total_value.toFixed(2),
        "id_pg_method":this.pgmethod.id===undefined?null:this.pgmethod.id,
        "client":{
          "name":this.client['name'],
          "cpf":this.client.cpf
        },
        "products": prdArray
      }
      try {
        if(prdArray.length<=0) return;
        const {data, status} = await axios.post('/cashier/sale',request);

        Swal.fire({
          icon: 'success',
          title: 'Sucesso!',
          text: 'Compra Finalizada!',
          confirmButtonText: 'OK'
        });
        
        // Limpa os dados após sucesso
        this.rawproducts = [];
        this.client = {};
        this.pgmethod = {};
        this.refreshKey++;
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Erro!',
          text: 'Ocorreu um erro ao enviar os dados.',
          confirmButtonText: 'OK'
        });
        
        console.error('Erro na requisição', error);
      }
      
    }
  },
  data(){
    return{
        user:{},
        roles:[],
        active:"",
        count: 30,
        rawproducts: [],
        client:{},
        pgmethod:{},
        editIndex: [],
        editPrd:false,
        refreshKey: 0,
        isLoading: true,
        tbIndex:""
    }
  },
  
  computed: {
    total_value() {
      this.refreshKey;
      return this.products.reduce((acc, product) => {
        const value = product.new_value || product.value; 
        return acc + (value * product.quantity);
      }, 0);
    },
    products() {
      const productMap = new Map();
      this.rawproducts.forEach(product => {
        if (product.status !== "0") {
          const key = `${product.bar_code}-${product.sm_code}-${product.name}`;
          if (productMap.has(key)) {
            const existingProduct = productMap.get(key);
            existingProduct.quantity += 1;
            // Mantém o new_value se o produto já tiver sido editado
            existingProduct.new_value = existingProduct.new_value || product.new_value;
          } else {
            productMap.set(key, {
              ...product,
              quantity: 1,
              editing: false, // Novo campo para controlar a edição
              new_value: product.new_value || null
            });
          }
        }
        
      });
      return Array.from(productMap.values());
    }
  },
}
</script>
<style lang="scss" src="./style.scss"></style>