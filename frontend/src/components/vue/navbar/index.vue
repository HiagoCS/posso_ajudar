<template>
<div :class="`navbar ${this.navbarActive}`" ref="navbar">
        <div :class="`d-flex flex-row justify-content-between navheader ${this.navbarActive}`">
          <div :class="`d-flex flex-column profile-div ${this.navbarActive}`">
            <div class="d-flex flex-column profile-info">
              <i class="text-end text-black">{{this.user.data.name}}</i>
              <div class="d-flex flex-row">
                <i class="text-end text-white" v-for="roles in this.user.roles">
                <span class="text-white">{{ $t(`roles.${roles}`) }}</span>
                <span class="text-black">{{ `${roles === this.user.roles[this.user.roles.length - 1] ? ' ' : '/'} `}}</span>
              </i>
              </div>
              <i class="text-end text-nowrap">Kiosque 18 Ikigai Mió</i>
            </div>
            <div class="act-btn d-flex flex-column col-12">
              <div class="col-12">
                <button class="btn btn-primary">CONFIGURAÇÕES</button>
              </div>
              <div class="module-btn col-12">
                <button :class="`btn btn-primary text-nowrap ${this.moduleActv}`" @click="async () =>{this.moduleActv='active'}">ALTERNAR MÓDULO</button>
                <span class="d-flex flex-row modules">
                  <router-link :to="roles" class="btn btn-primary" 
                    style="text-transform: capitalize;" 
                    v-for="roles in this.user.roles"
                    @click="">{{ roles}}</router-link>
                  <!-- <span class="btn btn-primary">MANAGER</span>
                  <span class="btn btn-primary">BAR</span>
                  <span class="btn btn-primary">CASHIER</span> -->
                </span>
              </div>
            </div>
          </div>
          <div :class="`d-flex flex-column align-content-center profile ${this.navbarActive}`">
            <img :class="this.navbarActive" src="./user_logo.jpg" width="90px" height="90px">
          </div>
        </div>
        <div :class="`d-flex flex-column navlink ${this.navbarActive}`">
          <NavbarLink :items="link" :collapsed="collapsed" :nvActive="this.navbarActive" />
        </div>
        <span class="collapse-icon" @click="toggleNavbar" >
          <font-awesome-icon icon="angle-double-left" :class="`icon ${this.navbarActive}`"></font-awesome-icon>
        </span>
      </div>
</template>

<script>
import NavbarLink from './navbar_link/index.vue'
import links from "./links.json"
import {ref} from 'vue';
export default{
    props:['user'],
    async created(){
      this.collapsed === ref(false);
      await this.user;
      console.log('user', this.user);

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
        collapsed: ref(false),
        navbarActive: ``,
        link: links,
        moduleActv:``
      }
    },
    methods:{
      async toggleNavbar(){
        this.collapsed = !this.collapsed
        this.moduleActv = '';
        this.$emit("toggleNav");
      },
      async changeModule(module){
        console.log(module)
        this.$router.push({path: module+"/home"})
      }
    }

}
</script>

<style lang="scss" src="./style.scss" scoped/>