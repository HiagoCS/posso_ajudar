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
            <img src="./user_logo.jpg" width="90px" height="90px">
          </div>
        </div>
        <div class="d-flex flex-column" style="margin-bottom: 5vh; height: 70vh;width: 100%;z-index: 2;">
          <NavbarLink :items="{'item1':{'name':'groupname', 'items':[{'name': 'subitem1', 'icon':'cog'}, {'name': 'subitem2', 'icon':'cog'}]}, 'item2':{'name':'String Item 2', 'icon':'cog'}, 'item3':{'name':'groupname', 'items':[{'name': 'subitem1', 'icon':'cog'}, {'name': 'subitem2', 'icon':'cog'}]}, 'item4':{'name':'String Item 4','icon':'cog'}, 'item5':{'name':'groupname', 'items':[{'name': 'subitem1', 'icon':'cog'}, {'name': 'subitem2', 'icon':'cog'}]},}" to="/" icon="cog" :collapsed="collapsed" :nvActive="this.navbarActive" />
        </div>
        <span class="collapse-icon" @click="toggleNavbar" style="z-index: 1;">
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