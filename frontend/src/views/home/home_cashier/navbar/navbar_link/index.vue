<script>
import { collapsed } from '../state';

    export default{
        props:{
            collapsed:{type:Boolean, required:true},
            items:{type:Object, required:true},
            nvActive:{type:Boolean, required:true}
        }
    }
</script>
<template>
    <div class="link d-flex flex-column" :class="{active:isActive}">
        <div v-for="item in items">
            <div v-if="!item['items']" class="item item-nogroup">
                <router-link :to="item.to" :class="`rt ${nvActive}`" style="">{{item.name}}</router-link>
                <font-awesome-icon :icon="item.icon" :class="`icon ${nvActive}`"></font-awesome-icon>
            </div>

            <div v-else class="d-flex flex-column-reverse item group">
                <router-link v-for="subitem in item.items" :to="subitem.to" class="d-flex flex-row align-items-center item-group">
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