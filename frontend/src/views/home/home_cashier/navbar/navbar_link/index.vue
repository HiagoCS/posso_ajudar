<script>
import { collapsed } from '../state';

    export default{
        props:{
            icon:{type:String, required:true},
            collapsed:{type:Boolean, required:true},
            items:{type:Object, required:true},
            nvActive:{type:Boolean, required:true}
        },
        data(){
            return{
                hoverAct:``
            }
        }
    }
</script>
<template>
    <div class="link d-flex flex-column" :class="{active:isActive}">
        <div v-for="item in items">
            <div v-if="!item['items']" class="item item-nogroup">
                <router-link :to="item.to" class="rt" style="">{{item.name}}</router-link>
                <font-awesome-icon :icon="item.icon" :class="`icon ${nvActive}`"></font-awesome-icon>
            </div>

            <div v-else class="d-flex flex-column-reverse item group">
                <div v-for="subitem in item.items" class="d-flex flex-row align-items-center item-group">
                    <router-link class="rt" :to="subitem.to">{{ subitem.name }}</router-link>
                    <font-awesome-icon :icon="subitem.icon" :class="`icon ${nvActive}`"></font-awesome-icon>
                </div>
                <div :class="`d-flex flex-row group-name`">
                    <i>{{item.name}}</i>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" src="./style.scss" scoped></style> 