<script setup>
import Form from './Form.vue';
const props = defineProps({
    marcas: { type: Array, default: () => [] }
});
</script>

<template>
    <Form :marcas="marcas" :producto="null" />
</template>
