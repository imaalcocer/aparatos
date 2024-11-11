<script setup>
import { type } from 'jquery';
import Form from './Form.vue';
const props = defineProps ({
    marcas:{type:Object},
    producto:{type:Object},
    marcaOfProducto:{type:Object},
});
</script>

<template>
    <Form :marcas="marcas" :producto="producto"
    :marcaOfProducto="marcaOfProducto" />
</template>