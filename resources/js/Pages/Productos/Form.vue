<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    marcas: { type: Array, default: () => [] },
    producto: { type: Object, default: null }
});

const form = useForm({
    id: props.producto?.id || '',
    codigo_producto: props.producto?.codigo_producto || '',
    title: props.producto?.title || '',
    description: props.producto?.description || '',
    release_date: props.producto?.release_date || '',
    image: null, // Cambiado a null para recibir el archivo
    marca_id: props.producto?.marca_id || ''
});

const title_form = computed(() => props.producto ? 'Editar producto' : 'Crear producto');

const srcImg = ref(props.producto?.image ? `/storage/${props.producto.image}` : '/storage/img/ejemplo.jpg');

const updateImagePreview = (event) => {
    const file = event.target.files[0];
    if (file) {
        srcImg.value = URL.createObjectURL(file);
        form.image = file; // Asegúrate de que la imagen se asigne aquí
    }
};

const submitForm = () => {
    console.log('Formulario enviado:', form); // Verifica que los datos estén presentes en el formulario
    if (form.id) {
        form.put(route('productos.update', form.id), {
            onSuccess: () => {
                console.log('Producto actualizado exitosamente');
            }
        });
    } else {
        form.post(route('productos.store'), {
            onSuccess: () => {
                console.log('Producto guardado exitosamente');
            }
        });
    }
};
</script>

<template>
    <Head :title="title_form" />
    <AuthenticatedLayout>
        <div class="p-4">
            <h1 class="text-xl font-bold mb-4">{{ title_form }}</h1>
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">
                        Código de Producto
                    </label>
                    <input type="text" v-model="form.codigo_producto" placeholder="Ingrese el código de producto" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">
                        Nombre del Producto
                    </label>
                    <input type="text" v-model="form.title" placeholder="Ingrese el nombre del producto" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">
                        Descripción
                    </label>
                    <textarea v-model="form.description" placeholder="Ingrese la descripción del producto" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">
                        Fecha de Lanzamiento
                    </label>
                    <input type="date" v-model="form.release_date" placeholder="Seleccione la fecha de lanzamiento" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">
                        Imagen del Producto
                    </label>
                    <input type="file" @change="updateImagePreview" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">
                        Marca
                    </label>
                    <select v-model="form.marca_id" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option disabled value="">Seleccione una marca</option>
                        <option v-for="marca in marcas" :key="marca.id" :value="marca.id">{{ marca.name }}</option>
                    </select>
                </div>
                <PrimaryButton type="submit">Guardar</PrimaryButton>
            </form>
        </div>
        <div class="min-w-0 p-4 rounded-lg shadow-xs">
            <img :src="srcImg" :alt="form.title || 'Vista previa de la imagen'" width="500">
        </div>
    </AuthenticatedLayout>
</template>
