<template>
  <main class="app-main">
    <div class="main-container">
      <div class="side-navbar" v-if="this.$route.name !== 'login'">
        <Navbar @toggleNav="() => { this.active === 'active' }"></Navbar>
      </div>
      <div class="d-flex flex-column content-area">
        <div class="col-12" v-if="this.$route.name !== 'login'">
          <logoComponent :module="this.$route.name"></logoComponent>
        </div>
        <div class="col-12">
          <RouterView :user="user"/>
        </div>
        
      </div>
    </div>
  </main>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
import { RouterView } from 'vue-router';
import axios from 'axios';
import VueCookie from 'vue-cookie';
import Navbar from '@/components/vue/navbar/index.vue';
import logoComponent from './components/vue/logoComponent.vue';

export default {
  components: {
    Navbar,logoComponent
  },
  data() {
    return {
      isLoggedIn: !!VueCookie.get('token'),
      user: {},
      active: 'active',
    };
  },
  async created() {
  console.log("this.$route.name",this.$route.name)
    await this.userData();
  },
  methods: {
    async userData() {
      if (this.isLoggedIn) {
        try {
          const { data } = await axios.get('user', {
            headers: { Authorization: `Bearer ${VueCookie.get('token')}` },
          });
          this.user = data.user;
          this.roles = data.roles_nm;
          console.log('DATA', data);
        } catch (error) {
          console.error('Erro ao buscar dados do usuário:', error);
        }
      } else {
        const route = await this.$route.name;
        if (!window.location.pathname.includes('login')) {
          this.$swal({
            title: 'Usuário não está logado',
            text: 'Por favor, faça login para continuar.',
            icon: 'warning',
            confirmButtonText: 'OK',
          }).then(() => {
            this.$router.push({ name: 'login' });
          });
        } else {
          this.user = {};
        }
      }
    },
  },
};
</script>
