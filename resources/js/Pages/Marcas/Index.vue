<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import Selectinput from '@/Components/Selectinput.vue';
import { ref } from 'vue';

const props = defineProps({
    marcas: { type: Object },
    countries: { type: Array }
});

const form = useForm({ name: '', country: '', created_at: '' });
const v = ref({ id: '', name: '', country: '', productos: [] });
const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const title = ref('Editar Marca');
const currentMarcaId = ref(null);

// Variables para el mensaje de éxito
const successMessage = ref('');
const showSuccessMessage = ref(false);

const dateOnlyFormat = (date) => {
    if (!date) return '';
    const formattedDate = new Date(date).toISOString().split('T')[0];
    return formattedDate;
};

const openModalView = (a) => {
    v.value = { ...a };
    showModalView.value = true;
};

const openModalForm = (a) => {
    currentMarcaId.value = a.id;
    form.name = a.name || '';
    form.country = a.country || '';
    form.created_at = dateOnlyFormat(a.created_at) || '';
    title.value = 'Editar Marca';
    showModalForm.value = true;
};

const openModalAdd = () => {
    form.reset();
    currentMarcaId.value = null;
    title.value = 'Añadir Marca';
    showModalForm.value = true;
};

const openModalDel = (a) => {
    currentMarcaId.value = a.id;
    showModalDel.value = true;
};

const closeModalView = () => {
    showModalView.value = false;
};

const closeModalForm = () => {
    showModalForm.value = false;
};

const closeModalDel = () => {
    showModalDel.value = false;
};

const save = () => {
    if (currentMarcaId.value) {
        // Actualiza la marca existente
        form.put(route('marcas.update', currentMarcaId.value), {
            onSuccess: () => {
                ok('Marca actualizada exitosamente.');
            },
            onError: (errors) => {
                console.error('Errores al actualizar la marca:', errors);
            }
        });
    } else {
        // Crea una nueva marca
        form.post(route('marcas.store'), {
            onSuccess: () => {
                ok('Se ha creado una nueva marca exitosamente.');
            },
            onError: (errors) => {
                console.error('Errores al crear la marca:', errors);
            }
        });
    }
};

const ok = (message) => {
    successMessage.value = message;
    showSuccessMessage.value = true;
    setTimeout(() => {
        showSuccessMessage.value = false;
    }, 3000); // Oculta el mensaje después de 3 segundos

    closeModalForm();
    form.reset();
};

const remove = () => {
    form.delete(route('marcas.destroy', currentMarcaId.value), {
        onSuccess: () => {
            closeModalDel();
            currentMarcaId.value = null;
            successMessage.value = 'Marca eliminada exitosamente.';
            showSuccessMessage.value = true;
            setTimeout(() => {
                showSuccessMessage.value = false;
            }, 3000);
        },
        onError: (errors) => {
            console.error('Errores al eliminar la marca:', errors);
        }
    });
};
</script>

<template>
    <Head title="Marcas" />
    <AuthenticatedLayout>
        <template #header>
            Marcas <br>
            <DarkButton @click="openModalAdd">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4v16"></path>
                    <path d="M4 12h16"></path>
                </svg>
            </DarkButton>
        </template>

        <!-- Mensaje de éxito -->
        <div v-if="showSuccessMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span>{{ successMessage }}</span>
        </div>

        <div class="w-full overflow-hidden rounded-lg border shadow-md">
            <div class="w-full overflow-x-auto bg-white">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Country</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Detalle</th>
                            <th class="px-4 py-3">Editar</th>
                            <th class="px-4 py-3">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="(a, i) in marcas" :key="a.id" class="text-gray-700">
                            <td class="px-4 py-3 text-sm">
                                {{ i + 1 }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ a.name }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ a.country || 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ new Date(a.created_at).toLocaleDateString() || 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <SecondaryButton @click="openModalView(a)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </SecondaryButton>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <WarningButton @click="openModalForm(a)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19H4v-3L16.5 3.5z"></path>
                                    </svg>
                                </WarningButton>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <DangerButton @click="openModalDel(a)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <Modal :show="showModalView" @close="closeModalView">
            <div class="p-6">
                <p>Marca: <span class="text-lg font-medium text-gray-900">{{ v.name }}</span></p>
                <p>País: <span class="text-lg font-medium text-gray-900">{{ v.country }}</span></p>
                <p>Productos:</p>
                <ol>
                    <li v-if="v.productos.length === 0" class="text-sm text-gray-500">No hay productos asociados</li>
                    <li class="text-lg font-medium text-gray-900" v-for="(b, i) in v.productos" :key="b.id">
                        {{ (i + 1) + ') ' + b.title }}
                    </li>
                </ol>
            </div>
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalView">Cerrar</SecondaryButton>
            </div>
        </Modal>

        <Modal :show="showModalForm" @close="closeModalForm">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
                <div class="mt-6 mb-6 space-y-6 max-w-xl">
                    <InputGroup :text="'Nombre'" icon="user" v-model="form.name" :type="'text'" />
                    <InputError class="mt-1" :message="form.errors.name"></InputError>

                    <InputGroup :text="'Country'" v-model="form.country" icon="location" :options="countries" :type="'text'"/>
                    <InputError class="mt-1" :message="form.errors.country"></InputError>

                    <InputGroup
                        :text="'Fecha de Creación'"
                        icon="calendar"
                        v-model="form.created_at"
                        :type="'text'"/>
                    <InputError class="mt-1" :message="form.errors.created_at"></InputError>
                </div>
            </div>
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
                <PrimaryButton @click="save">Guardar</PrimaryButton>
            </div>
        </Modal>

        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                <p class="text-lg font-medium text-gray-900">¿Estás seguro de que deseas eliminar esta marca?</p>
            </div>
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
                <DangerButton @click="remove">Eliminar</DangerButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
