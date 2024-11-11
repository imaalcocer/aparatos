<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import NavLink from '@/Components/NavLink.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import { ref } from 'vue';

const props = defineProps({
    productos: { type: Object },
    flash: { type: Object }
});

console.log('Productos recibidos:', props.productos);

const form = useForm({ id: '', title: '' });
const showModalDel = ref(false);
const showSuccessMessage = ref(props.flash.success ? true : false);
const successMessage = ref(props.flash.success || '');

const openModalDel = (b) => {
    form.id = b.id;
    form.title = b.title;
    showModalDel.value = true;
};

const closeModalDel = () => {
    showModalDel.value = false;
};

const remove = () => {
    console.log('ID a eliminar:', form.id);
    form.delete(route('productos.destroy', form.id), {
        onSuccess: () => {
            closeModalDel();
            form.reset();
            successMessage.value = 'Producto eliminado exitosamente.';
            showSuccessMessage.value = true;
            setTimeout(() => {
                showSuccessMessage.value = false;
            }, 3000);
        },
        onError: (errors) => {
            console.error('Errores al eliminar el producto:', errors);
            alert('Error al eliminar el producto: ' + JSON.stringify(errors));
        }
    });
};
</script>

<template>
    <Head title="Productos" />
    <AuthenticatedLayout>
        <template #header>
            Productos
        </template>

        <!-- Mensaje de éxito -->
        <div v-if="showSuccessMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span>{{ successMessage }}</span>
        </div>

        <div v-if="productos.data && productos.data.length > 0" class="w-full overflow-hidden rounded-lg border shadow-md">
            <div class="w-full overflow-x-auto bg-white">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Código de producto</th>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Imagen</th>
                            <th class="px-4 py-3">Detalle</th>
                            <th class="px-4 py-3">Editar</th>
                            <th class="px-4 py-3">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(b, i) in productos.data" :key="b.id" class="text-gray-700">
                            <td class="px-4 py-3 text-sm">{{ i + 1 }}</td>
                            <td class="px-4 py-3 text-sm">{{ b.codigo_producto }}</td>
                            <td class="px-4 py-3 text-sm">{{ b.title || 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <img :src="`/storage/img/${b.image}`" width="50" alt="Imagen del producto" v-if="b.image">
                                <span v-else>Sin imagen</span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <NavLink :href="route('productos.show', b.id)">
                                    <SecondaryButton>Ver</SecondaryButton>
                                </NavLink>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <NavLink :href="route('productos.edit', b.id)">
                                    <WarningButton>Editar</WarningButton>
                                </NavLink>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <DangerButton @click="openModalDel(b)">Eliminar</DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :links="productos.links" />
        </div>
        <div v-else>
            <p class="text-center text-gray-500">No hay productos disponibles.</p>
        </div>

        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                <p class="text-lg font-medium text-gray-900">¿Estás seguro de que deseas eliminar este producto?</p>
            </div>
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
                <DangerButton @click="remove">Eliminar</DangerButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
