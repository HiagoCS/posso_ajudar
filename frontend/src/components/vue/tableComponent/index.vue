<template>
    <table class="product-table col-12">
          <thead>
            <tr>
              <th> # </th>
              <th>Código de Barras</th>
              <th>Código Reduzido</th>
              <th>Produto</th>
              <th>Descrição</th>
              <th>Quantidade</th>
              <th>R$</th>
            </tr>
          </thead>
        <tbody>
          <tr v-for="(product, index) in this.products" :class="`${this.selected} ${product.id}`" :key="index"  
            @mouseover="$emit('hovered', product)" 
            @mouseleave="$emit('hovered', {})" 
            @click="$emit('selected', product)">
            <td>{{ product.id }}</td>
            <td>{{ product.bar_code }}</td>
            <td>{{ product.sm_code }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.product_amount }}</td>
            <td>R${{ product.value }}</td>
          </tr>
        </tbody>
      </table>
</template>
<style src="./style.scss" lang="scss" scoped></style>
<script>
    export default{
        props: {
            products: {
                type: Array,
                required: true
            }
        }
    }
</script>