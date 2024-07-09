<template>
<div :class="`navbar ${this.navbarActive}`" ref="navbar">
        <div class="d-flex flex-row justify-content-between navheader">
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
            <img src="../default_user.png" width="90px" height="90px">
          </div>
        </div>
        <NavbarLink to="/" icon="" :collapsed="collapsed">HOME</NavbarLink>
        <span class="collapse-icon" @click="toggleNavbar">
          <font-awesome-icon icon="angle-double-left" :class="`icon ${this.navbarActive}`"></font-awesome-icon>
        </span>
      </div>
</template>

<script>
import NavbarLink from './navbar_link/index.vue'
import {ref} from 'vue';
export default{
    created(){
      this.collapsed === ref(false)
    },
    components:{NavbarLink},
    watch:{
      collapsed(oldValue, newValue){
        if(!this.collapsed)
        this.navbarActive = ``;
        if(this.collapsed)
        this.navbarActive = `active`;
      }
    },
    data(){
      return{
        collapsed: ref(false),
        navbarActive: `active`
      }
    },
    methods:{
      async toggleNavbar(){
        this.collapsed = !this.collapsed
        /* this.$emit('toggle-navbarWidth', navbarWidth); */
      }
    }

}
</script>

<style lang="scss" src="./style.scss" scoped/>