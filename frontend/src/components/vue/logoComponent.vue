<template>
    <div class="logo col-12 d-flex align-items-center justify-content-between">
    <h4>Posso Ajudar?</h4>
    <i style="text-transform: capitalize;">{{ this.$t(`roles.${module}`) }}</i>
  </div>
</template>
<script>
    export default{
        props:{
            module:{type:String, required:true}
        }
    }
</script>
<style src="./style.scss" lang="scss" scoped></style>