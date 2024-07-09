<script>
    export default{
        props:{
            to:{type:String, required:true},
            icon:{type:String, required:true},
            collapsed:{type:Boolean, required:true}
        },
       watch:{
        /* collapsed(oldValue, newValue){
            console.log('collapsed')
            console.log('oldValue', oldValue)
            console.log('newValue', newValue)
        } */
       }
    }
</script>
<template>
    <router-link :to="to" class="link" :class="{active:isActive}">
        <i class="icon" >
            <Transition name="fade">
                <span v-if="!collapsed">
                    <slot></slot>
                </span>
            </Transition>
        </i>
    </router-link>
</template>
<style lang="scss" src="./style.scss" scoped></style> 