  <template>
    <main class="container-fluid d-flex flex-column align-items-center">
      <header class="logo-container" >
        <logoComponent module="products - general"></logoComponent>
      </header>
      <br>
      <div class="d-flex col-10 flex-row justify-content-end">
          <span class="btn btn-primary" @click="newProduct">Novo Produto</span>
        </div>
      <div class="d-flex flex-column table-container">
        <tableComponent :products="this.products" @selected="(product) =>{selected(product)}" @hovered="(product) =>{this.rawproduct=product;}"> </tableComponent>
      </div>
      <div class="d-flex flex-row justify-content-center col-12 footer">
          <div class="d-flex flex-column col-3 card-product">
            <div v-if="!this.editingPrd.status" class="d-flex flex-row justify-content-around title">
              <p class="name" title="Nome">{{this.product.name ? this.product.name : this.rawproduct.name}} </p>
              <p class="id" title="ID">#{{this.product.id ? this.product.id: this.rawproduct.id}}</p>
            </div>
            <div v-if="this.editingPrd.status" class="d-flex col-11 flex-row align-items-center justify-content-around title">
              <div class="col-10">
                <input type="text" placeholder="Nome do Produto" title="Nome" v-model="editingPrd['name']" class="col-10 form-control">
              </div>
              <div class="d-flex flex-row justify-content-end col-3">
                <p class="id" title="ID">#{{this.product.id ? this.product.id: this.rawproduct.id}}</p>
              </div>              
            </div>
            <div 
            v-if="!this.editingPrd.status"
            class="d-flex col-12 justify-content-between flex-row details">
              <p class="sm_code" title="Código Reduzido">{{this.product.sm_code? this.product.sm_code:this.rawproduct.sm_code}}</p>
              <p>-</p>
              <p class="value" title="Valor do Produto">R${{this.product.value? this.product.value:this.rawproduct.value}}</p>
              <p>-</p>
              <p class="amount" title="Quantidade Total">{{ this.product.product_amount? this.product.product_amount:this.rawproduct.product_amount }} UN</p>
            </div>
            <div 
            v-if="this.editingPrd.status"
            class="d-flex col-12 justify-content-start flex-row details">
              <div class="col-5">
                <input type="text"  placeholder="Cód. Redu" title="Código Reduzido"  v-model="editingPrd['sm_code']" class="col-5 form-control">
              </div>
              <div class="col-3">
                <input type="text"  placeholder="R$0" title="(R$) Preço" v-model="editingPrd['value']" class="col-3 form-control">
              </div>
              <div class="col-3">
                <input type="text" placeholder="UN" title="Quantidade do Produto" v-model="editingPrd['product_amount']" class="col-3 form-control">
              </div>
            </div>
            <div 
            v-if="!this.editingPrd.status"
            class="d-flex col-12 justify-content-between flex-row bar-code">
              <p title="Código de Barras">{{ this.product.bar_code? this.product.bar_code:this.rawproduct.bar_code }}</p>
            </div>
            <div 
            v-if="this.editingPrd.status"
            class="d-flex col-12 justify-content-between flex-row bar-code">
            <input placeholder="Código de Barras" title="Código de Barras" type="text" v-model="editingPrd['bar_code']" class="col-12 form-control">
            </div>
          </div>
          <div class="d-flex flex-column col-4 card-product">
            <div class="d-flex flex-row title">
              <p>Descrição do Produto:</p>
            </div>
            <div v-if="!this.editingPrd.status" 
            class="d-flex flex-row flex-wrap description">
              <text>{{ this.product.description? this.product.description: this.rawproduct.description }}</text>
            </div>
            <div v-if="this.editingPrd.status" 
            class="d-flex flex-row flex-wrap form-outline description">
                <textarea v-model="editingPrd['description']" class="form-control" id="bar_code" rows="4" placeholder="Descrição do Produto"></textarea>
            </div> 
          </div>
          <div class="d-flex flex-column col-4 card-product">
            <div class="d-flex align-items-center justify-content-between flex-row col-12 actions">
              <span
              :class="`btn btn-primary ${this.disabled.plus}`"
              @click="plusProduct">
                <font-awesome-icon v-if="this.product.id" icon="plus"></font-awesome-icon>
                <font-awesome-icon v-if="!this.product.id"icon="arrow-left"></font-awesome-icon>
              </span>
              <span 
              :class="`btn btn-primary ${this.disabled.minus}`"
              @click="minusProduct">
                <font-awesome-icon v-if="this.product.id"icon="minus"></font-awesome-icon>
                <font-awesome-icon v-if="!this.product.id"icon="arrow-right"></font-awesome-icon>
              </span>
              <span 
              :class="`btn btn-secondary ${this.disabled.copy}`"
              @click="copyProduct(!this.editingPrd.status)">
                <font-awesome-icon icon="copy"></font-awesome-icon>
              </span>
              <span 
              :class="`btn ${this.editingPrd.status?'btn-success':'btn-warning'} ${this.disabled.edit}`"
              @click="editProduct(!this.editingPrd.status)">
                <font-awesome-icon v-if="!this.editingPrd.status" icon="pen-to-square"></font-awesome-icon>
                <font-awesome-icon v-if="this.editingPrd.status" icon="check"></font-awesome-icon>
              </span>
              <span 
              :class="`btn btn-danger ${this.disabled.ban}`"
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
    async selected(product){
      if(this.product.id!=product.id){
        this.product=product;
        this.disabled={plus:'', minus:'', edit:'', copy:'',ban:''}
      }else if(this.product.id==product.id){
        this.product={};
        this.disabled = {
        plus: this.page==1?'disabled' :'',
        ban:'disabled',
        edit:'disabled',
        copy:'disabled',
      }
      }
    },
    async newProduct(status){
      this.editingPrd.status=status
      if(this.editingPrd.status){
        this.disabled = {
          plus:'disabled',
          minus:'disabled',
          copy:'disabled',
        }
      }
    },
    async editProduct(status){
      this.editingPrd.status=status
      if(this.editingPrd.status){
        this.disabled = {
        plus:'disabled',
        minus:'disabled',
        copy:'disabled',
      }
        const keys = Object.keys(this.product);
        keys.forEach(key =>{
          this.editingPrd[key] = this.product[key]
        })
      }else if(!this.editingPrd.status && this.product.id != '0'){
        delete this.editingPrd['status'];
        const {data} = await axios.post('manager/products/update/'+this.product.id,this.editingPrd);
        this.disabled = {
          plus:'',
          minus:'',
          copy:'',
        }
        this.editingPrd.status =false;
        this.product = data.data
        return this.$swal.fire({
          title: `Produto #${data.data.id}\n${data.data.name}\nAtualizado com sucesso!`,
          icon:'success',
          confirmButtonText: 'OK',
        });
        
      }
      else {
        delete this.editingPrd['status'];
        const {data} = await axios.post('manager/products/insert/',this.editingPrd);
        this.disabled = {
          plus:'',
          minus:'',
          copy:'',
        }
        this.editingPrd.status =false;
        this.product=data.data;
        this.paginate(parseInt(this.currentpage), 7)
        return this.$swal.fire({
          title: `Produto \n${data.data.name}\nCriado com sucesso!`,
          icon:'success',
          confirmButtonText: 'OK',
        });
        
      }

    },
    async copyProduct(status){
      this.editingPrd.status=status
      if(this.editingPrd.status){
        this.disabled = {
        plus:'disabled',
        minus:'disabled',
        copy:'disabled',
      }
        this.product.id = 0;
        const keys = Object.keys(this.product);
        keys.forEach(key =>{
          this.editingPrd[key] = this.product[key]
        })
      }

    },
    async plusProduct(){
      if(!this.product.id) {
        this.currentpage = parseInt(this.currentpage)-1
        if(this.currentpage==1) this.disabled.plus='disabled';
        if(this.currentpage<this.lastpage) this.disabled.minus='';
        return this.paginate(parseInt(this.currentpage), 7)
      }
      this.product.product_amount++
      const {data} = await axios.post('manager/products/update/'+this.product.id,{'product_amount': parseInt(this.product.product_amount)});
      return console.log('plus',data)
    },
    async minusProduct(){
      if(!this.product.id) {
        this.currentpage = parseInt(this.currentpage)+1
        if(this.currentpage>1) this.disabled.plus='';
        if(this.currentpage===this.lastpage) this.disabled.minus='disabled';
        return this.paginate(parseInt(this.currentpage), 7)
      }
      this.product.product_amount--
      const {data} = await axios.post('manager/products/update/'+this.product.id,{'product_amount': parseInt(this.product.product_amount)});
      return console.log('minus',data)
    },
    async banProduct(){
      if(this.editingPrd.status){
        if(this.product.id){
          this.disabled = {
            plus:'',
            minus:'',
            copy:'',
            ban:'',
            edit:''
          }
        }else{
          this.disabled = {
            plus:'',
            minus:'',
            copy:'disabled',
            ban:'disabled',
            edit:'disabled'
          }
        }
        
        return this.editingPrd.status =false;
      }
      const result = await this.$swal.fire({
        title: 'Deseja excluir o produto ou só desativá-lo do sistema?',
        icon: 'warning',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: this.product.status===0?'Ativar':'Excluir',
        denyButtonText: this.product.status===0?'Excluir':'Desativar',
        cancelButtonText: 'Cancelar'
      });
      if (result.isConfirmed) {
        // Código para excluir o produto
        if(this.product.status===0){
          const { data } = await axios.post('manager/products/update/' + this.product.id, { status: '1' });
          this.product.status = 1;
          return this.$swal.fire({
          title: `Produto #${data.data.id}\n${data.data.name}\nAtivado com sucesso!`,
          icon:'success',
          confirmButtonText: 'OK',
        });
        }
        else{
          const { data } = await axios.delete('manager/products/delete/' + this.product.id);
          this.product = {};
          this.rawproducts.splice(this.rawproducts.findIndex(raw => raw.id === data.data.id), 1);
          return this.$swal.fire({
          title: `Produto #${data.data.id}\n${data.data.name}\nDeletado com sucesso!`,
          icon:'success',
          confirmButtonText: 'OK',
        });
        }
      } else if (result.isDenied) {
        // Código para desativar o produto
        if(this.product.status===0){
          const { data } = await axios.delete('manager/products/delete/' + this.product.id);
          this.product = {};
          const response = await axios.get('manager/products')
          this.rawproducts = response.data;
          this.$forceUpdate();
          return this.$swal.fire({
            title: `Produto ${data.data.name}#${data.data.id} deletado com sucesso!`,
            icon:'success',
            confirmButtonText: 'OK',
          });
        }
        else{
          const { data } = await axios.post('manager/products/update/' + this.product.id, { status: '0' });
          this.product.status = 0;
          return this.$swal.fire({
            title: `Produto #${data.data.id}\n${data.data.name}\nDesativado com sucesso!`,
            icon:'success',
            confirmButtonText: 'OK',
          });
        }
      } else {
        return this.$swal.fire({
          title: `Ação Cancelada!`,
          icon:'error',
          confirmButtonText: 'OK',
        });
      }
    },
    async paginate(index,$perpage){
      console.log(this.currentpage)
      const {data} = await axios.get(`manager/products/${index}/${$perpage}`)
      this.rawproducts = data.data;
      this.currentpage = data.current_page;
      this.lastpage = data.last_page
      console.log(data);
    }
  },
  async created(){
    if(this.currentpage==1) this.disabled.plus='disabled';
    this.paginate(this.currentpage, 7);
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
              quantity: 1
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
      product:{},
      editingPrd:{status: false},
      disabled:{
        plus:'',
        minus:'',
        edit:'disabled',
        copy:'disabled',
        ban:'disabled'
      },
      currentpage:1,
      lastpage:0
    }
  }
}
</script>
<style lang="scss" src="./style.scss"></style>