<script>
    export default{
        props:{
            collapsed:{type:Boolean, required:true},
            items:{type:Object, required:true},
            nvActive:{type:Boolean, required:true},
            uRoles:{type:Array, required:true}
        },
        async created(){
            /* console.log("uRoles", this.uRoles) */
        }
    }
</script>
<template>
    <div :class="`link d-flex flex-column ${nvActive} ${{ active:isActive }}`">
        <div v-for="item in items">
            <div v-if="!item['items']" class="item item-nogroup">
                <router-link :to="{'name':item.to}" :class="`rt ${nvActive}`" style="">{{item.name}}</router-link>
                <font-awesome-icon :icon="item.icon" :class="`icon ${nvActive}`"></font-awesome-icon>
            </div>

            <div v-if="item['to']==''" class="d-flex flex-column-reverse item group">
                <a v-for="subitem in item.items" :href="`${item.to}${subitem.to}`" class="d-flex flex-row align-items-center item-group">
                    <i :class="`rt ${nvActive}`" >{{ subitem.name }}</i>
                    <font-awesome-icon :icon="subitem.icon" :class="`icon ${nvActive}`"></font-awesome-icon>
                </a>
                <div :class="`d-flex flex-row group-name ${nvActive}`">
                    <i>{{item.name}}</i>
                </div>
            </div>

            <div v-if="item['items']&&item['to']!==''" class="d-flex flex-column-reverse item group">
                <router-link v-for="subitem in item.items" :to="`${item.to}${subitem.to}`" class="d-flex flex-row align-items-center item-group">
                    <i :class="`rt ${nvActive}`" >{{ subitem.name }}</i>
                    <font-awesome-icon :icon="subitem.icon" :class="`icon ${nvActive}`"></font-awesome-icon>
                </router-link>
                <div :class="`d-flex flex-row group-name ${nvActive}`">
                    <i>{{item.name}}</i>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" src="./style.scss" scoped></style> 