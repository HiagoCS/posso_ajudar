  <template>
    <main class="container-fluid d-flex flex-column align-items-center">
      <header class="logo-container">
        <logoComponent></logoComponent>
      </header>
      <div class="table-container">
        <tableComponent :products="this.products" @selected="(product) =>{this.product=product;}" @hovered="(product) =>{this.rawproduct=product;}"> </tableComponent>
      </div>
      <div class="d-flex flex-row justify-content-center col-12 footer">
          <div class="d-flex flex-column col-3 card-product">
            <div class="d-flex flex-row justify-content-around title">
              <p class="name" title="Nome">{{this.product.name ? this.product.name : this.rawproduct.name}} </p>
              <p class="id" title="ID">#{{this.product.id ? this.product.id: this.rawproduct.id}}</p>
            </div>
            <div class="d-flex col-12 justify-content-between flex-row details">
              <p class="sm_code" title="Código Reduzido">{{this.product.sm_code? this.product.sm_code:this.rawproduct.sm_code}}</p>
              <p>-</p>
              <p class="value" title="Valor do Produto">R${{this.product.value? this.product.value:this.rawproduct.value}}</p>
              <p>-</p>
              <p class="amount" title="Quantidade Total">{{ this.product.product_amount? this.product.product_amount:this.rawproduct.product_amount }} UN</p>
            </div>
            <div class="d-flex col-12 justify-content-between flex-row bar-code">
              <p title="Código de Barras">{{ this.product.bar_code? this.product.bar_code:this.rawproduct.bar_code }}</p>
            </div>
          </div>
          <div class="d-flex flex-column col-4 card-product">
            <div class="d-flex flex-row title">
              <p>Descrição do Produto:</p>
            </div>
            <div class="d-flex flex-row flex-wrap description">
              <text>{{ this.product.description? this.product.description: this.rawproduct.description }}</text>
            </div>
          </div>
          <div class="d-flex flex-column col-4 card-product">
            <div class="d-flex align-items-center justify-content-between flex-row col-12 actions">
              <span 
              class="btn btn-primary"
              @click="plusProduct">
                <font-awesome-icon icon="plus"></font-awesome-icon>
              </span>
              <span 
              class="btn btn-primary"
              @click="minusProduct">
                <font-awesome-icon icon="minus"></font-awesome-icon>
              </span>
              <span class="btn btn-primary">
                <font-awesome-icon icon="pen-to-square"></font-awesome-icon>
              </span>
              <span class="btn btn-primary">
                <font-awesome-icon icon="copy"></font-awesome-icon>
              </span>
              <span 
              class="btn btn-primary"
              @click="banProduct">
                <font-awesome-icon icon="ban"></font-awesome-icon>
              </span>
            </div>
          </div>
      </div>
    </main>
  </template>
<script>
import axios from 'axios';
import logoComponent from '@/components/vue/logoComponent.vue';
import tableComponent from  "@/components/vue/tableComponent/index.vue"
import FloatingVue from 'floating-vue';
export default{
  components:{logoComponent, tableComponent, FloatingVue},
  methods:{
    async plusProduct(){
      this.product.product_amount++
      const {data} = await axios.post('manager/products/update/'+this.product.id,{'product_amount': parseInt(this.product.product_amount)});
      return console.log('plus',data)
    },
    async minusProduct(){
      this.product.product_amount--
      const {data} = await axios.post('manager/products/update/'+this.product.id,{'product_amount': parseInt(this.product.product_amount)});
      return console.log('minus',data)
    },
    async banProduct(){
      //Usar chat bct para criar swal de confirmação, OK, NÃO, DESATIVAR APENAS
      const {data} = await axios.delete('manager/products/delete/'+this.product.id);
      return console.log('delete',data)
    },
    toggleMethod(product, active){
      if(!active){
        this.activeProduct=true;
        $(`.gear-button`).removeClass('active');
        $(`.action-menu`).removeClass('active');
        $(`#${product.id}.gear-button`).addClass('active');
        $(`#${product.id}.action-menu`).addClass('active');
        /* $(`.action-menu#${product.id}`).css('display', 'flex'); */    
      }
      else{
        this.activeProduct=false;
        $(`#${product.id}.gear-button`).removeClass('active');
        $(`#${product.id}.action-menu`).removeClass('active');
      }
    }
  },
  async created(){
    const {data} = await axios.get('manager/products')
    this.rawproducts = data;

    console.log(this.products);
  },
  computed:{
    products(){
      const productMap = new Map();
      this.rawproducts.forEach(product => {
        const key = `${product.bar_code}-${product.sm_code}-${product.name}`;
        if (productMap.has(key)) {
          const prd = productMap.get(key);
          prd.quantity += 1;
        } else {
            productMap.set(key, {
              ...product,
              quantity: 1,
              active:""
            });
          }
      });
      return Array.from(productMap.values());
    }
  },
  data(){
    return{
      rawproducts:[],
      rawproduct:{},
      product:{}
    }
  }
}
</script>
<style lang="scss" src="./style.scss"></style>