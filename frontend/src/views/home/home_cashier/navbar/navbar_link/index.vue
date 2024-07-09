<script>
import { collapsed } from '../state';

    export default{
        props:{
            to:{type:String, required:true},
            icon:{type:String, required:true},
            collapsed:{type:Boolean, required:true},
            items:{type:Object, required:true},
            nvActive:{type:Boolean, required:true}
        }
    }
</script>
<template>
    <router-link :to="to" class="link d-flex flex-column" :class="{active:isActive}">
        <div v-for="item in items">
            <div v-if="!item['items']" class="item">
                <i style="font-size: 20px; padding-right: 3vw;">{{item.name}}</i>
                <font-awesome-icon :icon="item.icon" :class="`icon ${nvActive}`"  style="font-size: 20px;"></font-awesome-icon>
            </div>
            <div v-else class="d-flex flex-column item group">
                <div class="d-flex flex-row group-name">
                    <i style="font-size: 25px;">{{item.name}}</i>
                </div>
                <div v-for="subitem in item.items" class="d-flex flex-row align-items-center">
                    <i style="font-size: 20px; padding-right: 3vw;">{{ subitem.name }}</i>
                    <font-awesome-icon :icon="subitem.icon" :class="`icon ${nvActive}`"  style="font-size: 20px;"></font-awesome-icon>
                </div>
            </div>
        </div>
    </router-link>
    <!-- <router-link :to="to" class="link" :class="{active:isActive}">
            <div v-if="!group && !collapsed" class="d-flex flex-row justify-content-end" style="width: 100%;">
                <div class="d-flex flex-column justify-content-center">
                    <i class="text-wrap" style="font-size: 140%;">{{ items[0] }}</i>
                </div>
                <div class="d-flex flex-column justify-content-center offset-3">
                    <font-awesome-icon :icon="icon" :class="`icon ${nvActive}`"  style="font-size: 30px;"></font-awesome-icon>
                </div>
            </div>
        
            <div v-else-if="group && !collapsed" class="d-flex flex-column" style="width: 100%; background-color: black;">
                <div class="d-flex flex-row justify-content-end" >
                    <i style="font-size: 25px; font-family: 'Nauticus-Bold';">GRUPO</i>
                </div>
                <div class="d-flex flex-row justify-content-end" v-for="item in items">
                    <div class="d-flex flex-column justify-content-center">
                        <i class="text-wrap" style="font-size: 140%; ">{{ item }}</i>
                    </div>
                    <div class="d-flex flex-column justify-content-center offset-3">
                        <font-awesome-icon :icon="icon" :class="`icon ${nvActive}`"  style="font-size: 30px;"></font-awesome-icon>
                    </div>
                </div>
            </div>
    </router-link> -->
</template>
<style lang="scss" src="./style.scss" scoped></style> 