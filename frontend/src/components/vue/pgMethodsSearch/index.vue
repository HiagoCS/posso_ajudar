<template>
    <main class="col-12">
        <input type="text"
                v-model="pgmethod"
                class="form-control"
                @input="filterPayments"
                @focus="showDropdown = true"
                @blur="hideDropdown"
                autocomplete="off"
                required>
        <label class="pg-label">Método Pagamento</label>
        <ul v-if="this.showDropdown && this.filteredPg.length" class="dropdown">
            <li 
                v-for="(method, index) in this.filteredPg" 
                :key="index" 
                @mousedown="$emit('returnPayment', this.filteredPg[index]);this.pgmethod = this.filteredPg[index].name;"
            >{{ method.name }}</li>
        </ul>
    </main>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
import axios from 'axios';
    export default{
        async created(){
            const {data} = await axios.get('/cashier/get/payments');
            this.rawpayments = data;
            console.log(this.rawpayments);
        },
        methods:{
            selectPg(method) {
                this.pgmethod = method.name;
                this.showDropdown = false;
            },
            filterPayments(){
                const query = this.pgmethod.toLowerCase();
                this.filteredPg = this.rawpayments.filter(method =>
                    method.name.toLowerCase().includes(query)
                );
            },
            hideDropdown() {
                setTimeout(() => {
                    this.showDropdown = false;
                }, 200); // Delay to ensure click is registered
            }
        },
        data(){
            return{
                pgmethod:"",
                rawpayments:[],
                filteredPg:[],
                showDropdown: false
            }
        }
    }
</script>