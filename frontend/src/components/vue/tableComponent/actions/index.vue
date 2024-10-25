<template>
    <main class="d-flex align-items-center justify-content-between flex-row col-12 actions">
        <span v-if="this.product.id"
        :class="`btn btn-primary ${this.disabled.plus}`"
        @click="amount('plus')">
            <font-awesome-icon icon="plus"></font-awesome-icon>
        </span>
        <span v-if="!this.product.id"
        :class="`btn btn-primary ${this.disabled.left}`"
        @click="this.paginate(parseInt(this.currentpage)-1,7)">
                <font-awesome-icon icon="arrow-left"></font-awesome-icon>
        </span>
        <span v-if="this.product.id"
        :class="`btn btn-primary ${this.disabled.minus}`"
        @click="amount('minus')">
            <font-awesome-icon icon="minus"></font-awesome-icon>
        </span>
        <span v-if="!this.product.id"
        :class="`btn btn-primary ${this.disabled.right}`"
        @click="this.paginate(parseInt(this.currentpage)+1,7)">
            <font-awesome-icon icon="arrow-right"></font-awesome-icon>
        </span>
        <span :class="`btn btn-secondary ${this.disabled.copy}`"
        @click="copy">
            <font-awesome-icon icon="copy"></font-awesome-icon>
        </span>
        <span v-if="!this.edit_status.status"
        :class="`btn btn-warning ${this.disabled.edit}`"
        @click="editMethod(!this.edit_status)">
            <font-awesome-icon icon="pen-to-square"></font-awesome-icon>
        </span>
        <span v-if="this.edit_status.status"
            :class="`btn btn-success ${this.disabled.check}`"
            @click="checkMethod(!this.edit_status)">
                <font-awesome-icon icon="check"></font-awesome-icon>
        </span>
        <span :class="`btn btn-danger ${this.disabled.ban}`"
        @click="banProduct">
            <font-awesome-icon icon="ban"></font-awesome-icon>
        </span>
    </main>
</template>
<script>
import axios from 'axios';
export default{
    async created(){
        this.paginate(this.currentpage, 7);
        console.log('isEditing?', this.edit_status)
    },
    props:['product', 'products', 'edit_status'],
    watch:{
        product(newValue, oldValue){
            if(this.edit_status.status) return;
            if(Object.keys(newValue).length==0){
                this.disabledAll();
                this.disabled.left = this.currentpage === 1 ? 'disabled':'';
                this.disabled.right= this.currentpage===this.lastpage ? 'disabled':'';
            }else if(Object.keys(newValue).length!=0&&!this.edit_status.status){
                this.enabledAll();
            }
        }
    },  
    data(){
        return{
            
            currentpage:1,
            lastpage:1,
            totalpage:0,
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
        }
    },
    methods:{
        async copy(){
            this.$emit('editing', true);
            this.$forceUpdate();
            this.disabledAll()
        },
        async amount(module){
            if(this.product.product_amount){
                try{
                    this.disabledAll();
                    this.$emit('spinner', true);
                    this.product.product_amount = module==='plus' ? parseInt(this.product.product_amount)+1:parseInt(this.product.product_amount)-1;
                    const {data} = await axios.post('manager/products/update/'+this.product.id,{'product_amount': parseInt(this.product.product_amount)});
                }catch(err){console.log}
                finally{
                    this.$emit('spinner', false);
                    this.enabledAll();
                }
            }
        },
        async paginate(index,$perpage){
            this.$emit('spinner', true)
            try{
                this.disabledAll();
                const {data} = await axios.get(`manager/products/${index}/${$perpage}`)
                this.$emit('paginateGet', data.data);
                this.currentpage = data.current_page;
                this.lastpage = data.last_page
                this.totalpage = data.total
            }catch(err){
                console.error('Erro ao carregar produtos:', err);
            }finally {
                this.$emit('spinner', false);
                if(Object.keys(this.product).length==0){
                    this.disabledAll();
                    console.log('current',this.currentpage)
                    console.log('last',this.lastpage)
                    this.disabled.left = this.currentpage === 1 ? 'disabled':'';
                    this.disabled.right= this.currentpage===this.lastpage ? 'disabled':'';
                }else{
                    this.enabledAll();
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