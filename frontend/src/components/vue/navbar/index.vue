<template>
  <div :class="`navbar ${this.navbarActive}`" ref="navbar">
    <div :class="`d-flex flex-row justify-content-between navheader ${this.navbarActive}`">
      <div :class="`d-flex flex-column profile-div ${this.navbarActive}`">
        <div class="d-flex flex-column profile-info">
          <i class="text-end text-black">{{ this.user.name }}</i>
          <div class="d-flex flex-row justify-content-end">
            <i class="text-end text-white" v-for="roles in this.roles" :key="roles">
              <span class="text-white">{{ $t(`roles.${roles}`) }}</span>
              <span class="text-black">{{ `${roles === this.roles[this.roles.length - 1] ? ' ' : '/'} `}}</span>
            </i>
          </div>
          <i class="text-end text-nowrap">Kiosque 18 Ikigai Mió</i>
        </div>
        <div class="act-btn d-flex flex-column col-12">
          <div class="col-12">
            <button class="btn btn-primary">CONFIGURAÇÕES</button>
          </div>
        </div>
      </div>
      <div :class="`d-flex flex-column align-content-center profile ${this.navbarActive}`">
        <img :class="`${this.navbarActive} user_img`" @mouseout="this.profileopct=0" @mouseover="this.profileopct=50" :src="userImg" width="90px" height="90px" />
        <img v-if="!userImg" :class="`${this.navbarActive} default_img`" src="./default_user.png" width="90px" height="90px" />
        <img :class="`${this.navbarActive} default_img`" @mouseout="this.profileopct=0" @mouseover="this.profileopct=50" :style="`opacity: ${this.profileopct}%;`" src="./default_user.png" width="90px" height="90px" />
      </div>
    </div>
    <div :class="`d-flex flex-column navlink ${this.navbarActive}`">
      <NavbarLink :items="link" :collapsed="collapsed" :nvActive="this.navbarActive" />
    </div>
    <span class="collapse-icon" @click="toggleNavbar">
      <font-awesome-icon icon="angle-double-left" :class="`icon ${this.navbarActive}`"></font-awesome-icon>
    </span>
  </div>
</template>


<script>
import NavbarLink from './navbar_link/index.vue'
import links from "./links.json"
import api from 'axios'
import {ref} from 'vue';
import VueCookie from 'vue-cookie';
export default{
    async created(){
      api.defaults.headers.common['Authorization'] = `Bearer ${VueCookie.get('token')}`;
      const user = await api.get('/user');
      this.user = user.data
      const roles = await api.get('/user/roles')
      this.roles = roles.data

      this.userImg = new URL('./user_logo.jpg', import.meta.url).href;
    },
    components:{NavbarLink},
    watch:{
      collapsed(){
        if(!this.collapsed)
        this.navbarActive = ``;
        if(this.collapsed)
        this.navbarActive = `active`;
      }
    },
    data(){
      return{
        collapsed: ref(true),
        navbarActive: `active`,
        link: links,
        user:[],
        roles:[],
        profileopct:0,
        userImg:null
      }
    },
    methods:{
      async click(){
        console.log("Hello World");
      },
      async toggleNavbar(){
        this.collapsed = !this.collapsed
        this.moduleActv = '';
        this.$emit("toggleNav");
      },
      async changeModule(){
        let htmlTEXT = "";
        this.user.roles.forEach((role) =>{
          htmlTEXT = `${htmlTEXT}<div class='d-grid col-${12 / this.user.roles.length - 1}'><button class='btn btn-primary btn-lg text-capitalize' id="${role}" onclick="$(location).attr('href',$('#${role}').attr('id'))">${this.$t(`roles.${role}`)}</button></div>`
        })
        this.$swal({
          icon:'question',
          confirmButtonText:`Voltar`,
          html:`
            <div class='d-flex flex-column'>
              <div class='d-flex flex-row justify-content-center'>
                <h2>Você deseja trocar de módulo?</h2>
              </div>
              <div class='d-flex flex-row justify-content-between'>
                ${htmlTEXT}
              </div>
            </div>`
        });
      }
    }

}
</script>

<style lang="scss" src="./style.scss" scoped/>