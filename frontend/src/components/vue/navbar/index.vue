<template>
<div :class="`navbar ${this.navbarActive}`" ref="navbar">
        <div :class="`d-flex flex-row justify-content-between navheader ${this.navbarActive}`">
          <div :class="`d-flex flex-column profile-div ${this.navbarActive}`">
            <div class="d-flex flex-column profile-info">
              <i class="text-end text-black">Lennon Santos</i>
              <i class="text-end text-white"><span>Caixa</span><span class="text-black"> - </span><span class="text-white">Gerente</span></i>
              <i class="text-end text-nowrap">Kiosque 18 Ikigai Mió</i>
            </div>
            <div class="confi-btn">
              <button class="btn btn-primary btn-block">CONFIGURAÇÕES</button>
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
    created(){
      this.collapsed === ref(false)
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
        navbarActive: `active`,
        link: links
      }
    },
    methods:{
      async toggleNavbar(){
        this.collapsed = !this.collapsed
        this.$emit("toggleNav");
      }
    }

}
</script>

<style lang="scss" src="./style.scss" scoped/>