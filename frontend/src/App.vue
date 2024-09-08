<script>
import { RouterView } from 'vue-router'
import axios from 'axios'
import VueCookie from 'vue-cookie';
import Navbar from "@/components/vue/navbar/index.vue"

export default{
  components:{
    Navbar
  },
  data(){
    return{
      isLoggedIn: !!VueCookie.get('token'),
      user:{},
      active:'active'
    }
  },
  async created(){
    await this.userData();
    
  },
  methods:{
    async userData(){
      if (this.isLoggedIn) {
        try {
          const {data} = await axios.get('user', {headers:{'Authorization':`Bearer ${VueCookie.get('token')}`}});
          this.user = data.user;
          this.roles = data.roles_nm;
          console.log("DATA", data);
        } catch (error) {
            // Aqui você pode tratar erros como 401 ou outros
           console.error("Erro ao buscar dados do usuário:", error);
        }
      } else{
        // Verifica se o usuário não está logado e se ele não está na rota "login"
        const route = await this.$route.name 
        console.log(route)
    if (!window.location.pathname.includes('login')) {
      this.$swal({
        title: 'Usuário não está logado',
        text: 'Por favor, faça login para continuar.',
        icon: 'warning',
        confirmButtonText: 'OK'
      }).then(() => {
        this.$router.push({ name: 'login' });
      });
    } else {
      // Se o usuário já estiver na rota "login", apenas limpar os dados sem redirecionar ou alertar
      this.user = {};
      return {};
    }
      }
  }
}
}
</script>

<template>
  <main>
    <div class="d-flex flex-row main-div col-12">
      <div class="d-flex flex-row" v-if="this.$route.name!='login'">
        <Navbar @toggleNav="() =>{this.active=='active'}"></Navbar>
      </div>
      <RouterView :user="user"/>
    </div> 
  </main>
</template>

<style lang="scss" src="./style.scss" />
