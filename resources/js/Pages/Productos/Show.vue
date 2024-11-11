<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({
    producto: { type: Object },
    marcas: { type: Object }
});
</script>

<template>
    <Head title="Producto Detalle" />
    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full">
                {{ producto.title }}
                <NavLink :href="route('productos.index')">
                    <DarkButton>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                            <path d="M9 1v3M15 1v3M9 20v3M15 20v3M20 9h3M20 15h3M1 9h3M1 15h3"></path>
                            <path d="M10 10h4v4h-4z"></path>
                        </svg>
                    </DarkButton>
                </NavLink>
            </div>
        </template>
        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <p>Descripción: <span class="text-gray-900 font-semibold">{{ producto.description }}</span></p>
                <p>Código de producto: <span class="text-gray-900 font-semibold">{{ producto.codigo_producto }}</span></p>
                <p>Marca: 
                    <span v-if="producto.marcas.length" class="text-gray-900 font-semibold">
                        <span v-for="(marca, index) in producto.marcas" :key="marca.id">
                            {{ marca.name }}<span v-if="index < producto.marcas.length - 1">, </span>
                        </span>
                    </span>
                    <span v-else class="text-gray-500">No disponible</span>
                </p>
                <p>Fecha de lanzamiento: <span class="text-gray-900 font-semibold">{{ producto.release_date }}</span></p>
            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="`/storage/${producto.image}`" :alt="producto.title" width="500">
            </div>
        </div>
    </AuthenticatedLayout>
</template>
