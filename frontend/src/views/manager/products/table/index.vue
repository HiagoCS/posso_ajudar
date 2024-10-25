  <template>
    <main class="container-fluid d-flex flex-column align-items-center">
      <div class="d-flex col-10 flex-row justify-content-end">
          <span class="btn btn-primary" @click="newProduct(!this.edit_status)">Novo Produto</span>
        </div>
      <div class="d-flex flex-column table-container">
        <span :class="`spinner ${this.spinner.status?'active':''}`" v-if="this.spinner.status" >
            <font-awesome-icon icon="spinner" spin />
        </span>
        <div v-if="!this.spinner.status">
          <tableComponent :product="this.product"  :products="this.rawproducts" @selected="(product) =>{if(this.edit_status)return;selected(product)}" @hovered="(product) =>{if(this.edit_status)return;this.rawproduct=product;}"> </tableComponent>
        </div>
        <div v-if="this.products.length === 0 
              && !this.spinner.status" 
              class="d-flex flex-row justify-content-center align-items-center">
          <h4>Nenhum produto disponível no momento</h4>
        </div>
      </div>
      <div class="d-flex flex-row justify-content-center col-12 footer">
          <div class="d-flex flex-column col-3 card-product">
            <div v-if="!this.edit_status" class="d-flex flex-row justify-content-around title">
              <p class="name" title="Nome">{{this.product.name ? this.product.name : this.rawproduct.name}} </p>
              <p class="id" title="ID">#{{this.product.id ? this.product.id: this.rawproduct.id}}</p>
            </div>
            <div v-if="this.edit_status" class="d-flex col-11 flex-row align-items-center justify-content-around title">
              <div class="col-10">
                <input id="name" type="text" placeholder="Nome do Produto" title="Nome" v-model="editingPrd['name']" class="col-10 form-control">
              </div>
              <div class="d-flex flex-row justify-content-end col-3">
                <p class="id" title="ID">#{{this.product.id ? this.product.id: this.rawproduct.id}}</p>
              </div>              
            </div>
            <div 
            v-if="!this.edit_status"
            class="d-flex col-12 justify-content-between flex-row details">
              <p class="sm_code" title="Código Reduzido">{{this.product.sm_code? this.product.sm_code:this.rawproduct.sm_code}}</p>
              <p>-</p>
              <p class="cost" title="(R$) Custo do Produto">R${{this.product.cost? this.product.cost:this.rawproduct.cost}}</p>
              <p>-</p>
              <p class="amount" title="Quantidade Total">{{ this.product.product_amount? this.product.product_amount:this.rawproduct.product_amount }} UN</p>
            </div>
            <div 
            v-if="this.edit_status"
            class="d-flex col-12 justify-content-start flex-row details">
              <div class="col-5">
                <input id="sm_code" type="text"  placeholder="Cód. Redu" title="Código Reduzido"  v-model="editingPrd['sm_code']" class="col-5 form-control">
              </div>
              <div class="col-4">
                <input id="cost" type="number"  placeholder="Custo" title="(R$) Custo do Produto" v-model.number="editingPrd['cost']" class="col-4 form-control">
              </div>
              <div class="col-3">
                <input id="product_amount" type="text" placeholder="UN" title="Quantidade do Produto" v-model="editingPrd['product_amount']" class="col-3 form-control">
              </div>
            </div>
            <div class="d-flex flex-row col-12">
              <div 
            v-if="!this.edit_status"
            class="d-flex col-8 justify-content-between flex-row bar-code">
              <p title="Código de Barras">{{ this.product.bar_code? this.product.bar_code:this.rawproduct.bar_code }}</p>
            </div>
            <div v-if="!this.edit_status" class="d-flex col-4 justify-content-between flex-row value">
              <p title="(R$) Valor">R${{ this.product.value? this.product.value:this.rawproduct.value }}</p>
            </div>
            <div 
            v-if="this.edit_status"
            class="d-flex col-8 justify-content-between flex-row bar-code">
            <input id="bar_code" placeholder="Código de Barras" title="Código de Barras" type="text" v-model="editingPrd['bar_code']" class="col-8 form-control">
            </div>
            <div v-if="this.edit_status" class="d-flex col-4 justify-content-between flex-row value">
              <input id="value" type="number"  placeholder="Valor" title="(R$) Valor do Produto" v-model.number="editingPrd['value']" class="col-4 form-control">
            </div>
            </div>
          </div>
          <div class="d-flex flex-column col-4 card-product">
            <div class="d-flex flex-row title">
              <p>Descrição do Produto:</p>
            </div>
            <div v-if="!this.edit_status" 
            class="d-flex flex-row flex-wrap description">
              <text>{{ this.product.description? this.product.description: this.rawproduct.description }}</text>
            </div>
            <div v-if="this.edit_status" 
            class="d-flex flex-row flex-wrap form-outline description">
                <textarea v-model="editingPrd['description']" class="form-control" id="description" rows="4" placeholder="Descrição do Produto"></textarea>
            </div> 
          </div>
          <div class="d-flex flex-column col-4 card-product">
            <div class="d-flex align-items-center justify-content-between flex-row col-12 actions">
              <span
              v-if="this.product.id"
              :class="`btn btn-primary ${this.disabled.plus}`"
              @click="plussMethod">
                <font-awesome-icon icon="plus"></font-awesome-icon>
              </span>
              <span
               v-if="!this.product.id"
              :class="`btn btn-primary ${this.disabled.left}`"
              @click="this.paginate(parseInt(this.currentpage)-1,7)">
                <font-awesome-icon icon="arrow-left"></font-awesome-icon>
              </span>
              <span
              v-if="this.product.id"
              :class="`btn btn-primary ${this.disabled.minus}`"
              @click="minussMethod">
                <font-awesome-icon icon="minus"></font-awesome-icon>
              </span>
              <span
              v-if="!this.product.id"
              :class="`btn btn-primary ${this.disabled.right}`"
              @click="this.paginate(parseInt(this.currentpage)+1,7)">
                <font-awesome-icon icon="arrow-right"></font-awesome-icon>
              </span>
              <span 
              :class="`btn btn-secondary ${this.disabled.copy}`"
              @click="copyProduct(!this.edit_status)">
                <font-awesome-icon icon="copy"></font-awesome-icon>
              </span>
              <span
              v-if="!this.edit_status"
              :class="`btn btn-warning ${this.disabled.edit}`"
              @click="editMethod(!this.edit_status)">
                <font-awesome-icon icon="pen-to-square"></font-awesome-icon>
              </span>
              <span
              v-if="this.edit_status"
              :class="`btn btn-success ${this.disabled.check}`"
              @click="checkMethod(!this.edit_status)">
                <font-awesome-icon icon="check"></font-awesome-icon>
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
  async created(){
    this.paginate(this.currentpage, 7);
  },
  components:{logoComponent, tableComponent, FloatingVue},
  watch:{
    product(newValue){
      if(Object.keys(this.product).length==0){
        if(this.currentpage==1)
        this.disabled.left='disabled';
        if(this.currentpage==this.lastpage)
        this.disabled.right='disabled';
      }
    },
    currentpage(newValue){
      if(this.currentpage==1)
        this.disabled.left='disabled';
      if(this.currentpage==this.lastpage)
        this.disabled.right='disabled';
    }
  },
  methods:{
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
    async paginate(index,$perpage){
      this.spinner.status=true;
      try{
        this.disabledAll();
        const {data} = await axios.get(`manager/products/${index}/${$perpage}`)
        this.rawproducts = data.data;
        this.currentpage = data.current_page;
        this.lastpage = data.last_page
        this.totalpage = data.total
      }catch(err){
        console.error('Erro ao carregar produtos:', err);
      }finally {
        this.spinner.status=false;
        this.enabledAll();
          if(Object.keys(this.product).length==0){
            if(this.currentpage===1) this.disabled.left='disabled';
            else this.disabled.left='';
            if(this.currentpage==this.lastpage || this.products.length==0) this.disabled.right='disabled';
            else this.disabled.right='';
            this.disabled.ban="disabled";
            this.disabled.edit="disabled";
            this.disabled.copy="disabled";
            this.disabled.check="disabled";
          }
      }
      
    },
    async minussMethod(){
      if(this.product.product_amount){
        try{
          this.disabledAll();
          this.spinner.status=!this.spinner.status;
          this.product.product_amount--
          const {data} = await axios.post('manager/products/update/'+this.product.id,{'product_amount': parseInt(this.product.product_amount)});
        }catch(err){console.log}
        finally{
          this.spinner.status=!this.spinner.status;
          this.enabledAll();
        }
      }
    },
    async plussMethod(){
      if(this.product.product_amount){
        try{
          this.disabledAll();
          this.spinner.status=!this.spinner.status;
          this.product.product_amount++
          const {data} = await axios.post('manager/products/update/'+this.product.id,{'product_amount': parseInt(this.product.product_amount)});
        }catch(err){console.log}
        finally{
          this.spinner.status=!this.spinner.status;
          this.enabledAll();
        }
      }
    },
    async selected(product){
      if(Object.keys(this.product).length==0){
        this.product=product
        /* this.disabled.plus=""
        this.disabled.minus=""
        this.disabled.edit=""
        this.disabled.ban=""
        this.disabled.copy="" */
      }else{
        if(this.product.id===product.id){
          this.product={}
          /* if(this.currentpage==1) this.disabled.plus='disabled';
          else this.disabled.plus='';
          if(this.lastpage==0||this.currentpage==this.lastpage) this.disabled.minus='disabled';
          else this.disabled.minus='';
          this.disabled.edit="disabled"
          this.disabled.ban="disabled"
          this.disabled.copy="disabled" */
        }else{
          this.product=product
          /* this.disabled.plus=""
          this.disabled.minus=""
          this.disabled.edit=""
          this.disabled.ban=""
          this.disabled.copy="" */
        }
      }
    },
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
    async checkMethod(status){
      this.edit_status=status
      if(!this.edit_status&&this.product_copy){
        this.copyProduct(this.edit_status)
      }else if(!this.edit_status&&!this.product_copy){
        this.editMethod(this.edit_status)
      }
    },
    async editMethod(status){
      this.edit_status=status
      if(this.edit_status){
          this.disabled = {
          plus:'disabled',
          minus:'disabled',
          copy:'disabled',
          }
          this.product_copy = false;
          const keys = Object.keys(this.product);
          keys.forEach(key =>{
            this.editingPrd[key] = this.product[key]
          });
      }else if(!this.edit_status&&!this.product_copy){
        try {
          this.spinner.status=true;
          const {data} = await axios.post('manager/products/update/'+this.product.id,this.editingPrd);
          this.edit_status = false;
          this.product = data.data
        } catch (err) {
          console.log(err)
        } finally{
          if(!this.edit_status){
            this.paginate(this.currentpage,7);
            this.spinner.status=false;
          }
        }
      }
    },
    async copyProduct(status){
      this.edit_status=status
      if(this.edit_status){
        this.disabledAll();
        this.disabled.check='';
        this.disabled.ban='';
        this.product.id = 0;
        this.product_copy = true;
        const keys = Object.keys(this.product);
        keys.forEach(key =>{
          this.editingPrd[key] = this.product[key]
        });
      }
      else if(!this.edit_status&&this.product_copy){
        this.spinner.status=true;
        try {
          if(this.editingPrd.bar_code===''||!this.editingPrd.bar_code){
            this.editingPrd.bar_code="000000000000"
          }
          let error=false;
          let emptyFields = [];
          const keys = Object.keys(this.editingPrd);
            keys.forEach(key =>{
            if(key!='bar_code'&&key!='status'&&key!='id'){
              if(this.editingPrd[key]==""){
                console.log("KEYNULL")
                $(`input#${key}`).css("borderColor", "red");
                if(key==='description')$(`#${key}`).css("borderColor", "red");
                emptyFields.push(key); 
                error=true
              }else $(`input#${key}`).css("borderColor", "black");
            }
          })
          if(error===true) {
            //Crie aqui um sweetalert para avisar dos campos que estão vazios
            this.$swal.fire({
              title: 'Campos obrigatórios vazios',
              text: `Os seguintes campos estão vazios:\n${emptyFields.join(', ')}`,
              icon: 'warning',
              confirmButtonText: 'OK'
            });
            return this.edit_status=true; // Interrompe a execução da função se houver erro
          }
          const {data} = await axios.post('manager/products/insert/',this.editingPrd);

        } catch (error) {
          console.log(error)
        }finally{
          if(!this.edit_status){
            this.product={};this.paginate(this.lastpage,7);this.spinner.status=false;
          }else{
            this.disabledAll();
            this.disabled.check=''
            this.disabled.ban=''
            this.spinner.status=false;
          }
        }
      }

    },
    async banProduct(){
      if(this.edit_status){
        if(Object.keys(this.product).length==0){
          this.disabledAll();
          this.paginate(this.currentpage,7)
        }else{
          this.enabledAll();
          this.paginate(this.currentpage,7)
        }
        this.editingPrd = {};
        this.product = {};
        return this.edit_status =false;
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
        if(this.product.status===0){
          try{
            const { data } = await axios.post('manager/products/update/' + this.product.id, { status: '1' });
            this.product.status = 1;
          }catch(err){console.log(err)}
          finally{
              this.paginate(parseInt(this.currentpage), 7)
          }
        }
        else{
          try {
            const { data } = await axios.delete('manager/products/delete/' + this.product.id);
            this.product = {};
            this.rawproducts.splice(this.rawproducts.findIndex(raw => raw.id === data.data.id), 1);
          } catch (err) {
            console.log(err)
          }finally{
            this.paginate(parseInt(this.currentpage), 7)
          }
        }
      } else if (result.isDenied) {
        // Código para desativar o produto
        if(this.product.status===0){
          try{
            const { data } = await axios.delete('manager/products/delete/' + this.product.id);
            this.product = {};
            const response = await axios.get('manager/products')
            this.rawproducts = response.data;
            this.$forceUpdate();
          }catch(err){

          }finally{
            this.paginate(parseInt(this.currentpage), 7)
          }
        }
        else{
          try{
            const { data } = await axios.post('manager/products/update/' + this.product.id, { status: '0' });
          this.product.status = 0;
          }catch(err){console.log(err)}
          finally{
            this.paginate(parseInt(this.currentpage), 7)
          }
        }
      } else {
        return this.$swal.fire({
          title: `Ação Cancelada!`,
          icon:'error',
          confirmButtonText: 'OK',
        });
      }
    }
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
  data(){
    return{
      totalpage:0,
      edit_status:false,
      product_copy:false,
      spinner:{status:false},
      rawproducts:[],
      rawproduct:{},
      product:{},
      editingPrd:{
        name:"",
        sm_code:"",
        bar_code:"",
        description:"",
        value:"",
        product_amount:""
      },
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
      config: {
          prefix: 'R$'
        }
    }
  }
}
</script>
<style lang="scss" src="./style.scss"></style>