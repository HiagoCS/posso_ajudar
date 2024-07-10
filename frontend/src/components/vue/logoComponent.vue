<template>
    <div class="d-flex flex-row-reverse align-items-center justify-content-between logo">
        <h4>Posso Ajudar?</h4>
        <i>- MÓDULO {{ module }}</i>
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