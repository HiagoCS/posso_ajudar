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
              <searchComponent placeholder="Produto" search-term="name" @result="(resul) =>{ this.rawproducts.push(resul)}"></searchComponent>
            </div>
          </div>
          <div class="d-flex flex-row cashier-table product-table-container">
            <div class="table-wrapper">
              <table class="product-table">
              <thead style="font-size: 20px;">
                <tr>
                  <th>#</th>
                  <th>Cód. Reduzido</th>
                  <th>Cód. Barra</th>
                  <th>Produto</th>
                  <th>Descrição</th>
                  <th>R$</th>
                  <th>Quant.</th>
                </tr>
              </thead>
              <tbody style="font-size: 15px;">
              <tr v-for="(product, index) in products" :key="index" >
                <td>{{ index + 1 }}</td>
                <td>{{ product.sm_code }}</td>
                <td>{{ product.bar_code }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.value * product.quantity}}</td>
                <td>{{ product.quantity }}</td>
              </tr>
            </tbody>
            </table>
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
import axios from 'axios';
import Swal from 'sweetalert2';
export default{
  components:{logoComponent, searchComponent, pgMethodsComponent, clientsSearchComponent},
  methods:{
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
      };
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
      const {data, status} = await axios.post('/cashier/sale',request);
      
      console.log("response", data);
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
        pgmethod:{}
    }
  },
  
  computed: {
    total_value() {
      return this.products.reduce((acc, product) => {
        return acc + (product.value * product.quantity);
      }, 0);
    },
    products() {
      const productMap = new Map();
      this.rawproducts.forEach(product => {
        const key = `${product.bar_code}-${product.sm_code}-${product.name}`;
        if (productMap.has(key)) {
          productMap.get(key).quantity += 1;
        } else {
          productMap.set(key, {
            ...product,
            quantity: 1
          });
        }
      });
      return Array.from(productMap.values());
    }
  },
}
</script>
<style lang="scss" src="./style.scss"></style>