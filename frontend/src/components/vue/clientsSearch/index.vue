<template>
    <main class="col-12">
        <input type="text"
                v-model="client"
                class="form-control"
                @input="filterClients"
                @focus="showDropdown = true"
                @blur="hideDropdown"
                autocomplete="off"
                required>
        <label class="client-label">Clientes</label>
        <ul v-if="this.showDropdown && this.filteredCli.length" class="dropdown">
            <li 
                v-for="(method, index) in this.filteredCli" 
                :key="index" 
                @mousedown="$emit('returnClients', this.filteredCli[index]);this.client = this.filteredCli[index].name"
            >{{ method.name }}</li>
        </ul>
    </main>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
import axios from 'axios';
    export default{
        async created(){
            const {data} = await axios.get('/cashier/get/clients');
            this.rawclients = data;
            console.log(this.rawclients);
        },
        methods:{
            selectPg(method) {
                this.pgmethod = method.name;
                this.showDropdown = false;
            },
            filterClients(){
                const query = this.client.toLowerCase();
                this.filteredCli = this.rawclients.filter(method =>
                    method.name.toLowerCase().includes(query)
                );
                this.$emit('returnClients', {'name':this.client, 'cpf':null})
                this.filteredCli.forEach(method =>{
                    if(method.name === this.client){
                        this.$emit('returnClients', {'name':method.name, 'cpf':method.cpf});
                    }
                })
                
            },
            hideDropdown() {
                setTimeout(() => {
                    this.showDropdown = false;
                }, 200); // Delay to ensure click is registered
            }
        },
        data(){
            return{
                client:"",
                rawclients:[],
                filteredCli:[],
                showDropdown: false
            }
        }
    }
</script>