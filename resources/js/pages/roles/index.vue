<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { roles } from '@/routes';
import rolesRoutes from '@/routes/roles';
import { router } from '@inertiajs/vue3';

// Importación normal de los iconos en PascalCase
import { SquarePen, ToggleRight, ToggleLeft } from 'lucide-vue-next';

import modalRol from '@/components/roles/modalRol.vue';
import Swal from 'sweetalert2';
import { DataTable } from 'datatables.net-vue3';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'roles',
                href: roles().url,
            },
        ],
    },
});

interface rol {
    id: number;
    name: string;
    active?: boolean;
}

interface Props {
    rol: rol[];
}

const props = defineProps<Props>();
const rol = props.rol || [];

const isModalOpen = ref(false);
const selectedRol = ref<rol | null>(null);

const openModal = (rol: rol) => {
    selectedRol.value = rol;
    isModalOpen.value = true;
};

const openEditModal = (rol: rol) => {
    selectedRol.value = rol;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    selectedRol.value = null;
};

const cambiarEstado = (id: number, active: number) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Quieres ${active === 1 ? 'activar' : 'desactivar'} este rol?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#7F2841',
        cancelButtonColor: '#4b4f54',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.put(
                `/roles/${id}/estado`,
                { active },
                {
                    preserveScroll: true,
                    preserveState: false, // Recarga los datos
                    onSuccess: () => {
                        Swal.fire(
                            '¡Hecho!',
                            `El rol ha sido ${active === 1 ? 'activado' : 'desactivado'}.`,
                            'success',
                        );
                    },
                },
            );
        }
    });
};

const columns = [
    {
        title: 'Id',
        data: 'id',
        className: 'dt-left',
    },
    {
        title: 'Descripción',
        data: 'name',
        className: 'dt-left',
    },
    {
        title: 'Acciones',
        data: null,
        orderable: false,
        className: 'dt-left',
        cellType: 'th',
    },
];

const options = {
    responsive: true,
    dom: '<"flex items-center justify-between mb-4"lf>rt<"flex items-center justify-between mt-4"ip>',
    language: {
        search: 'Buscar:',
        lengthMenu: 'Mostrar _MENU_ registros',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        paginate: {
            first: 'Primero',
            last: 'Último',
            next: 'Siguiente',
            previous: 'Anterior',
        },
    },
};
</script>
<template>
    <Head title="Dashboard" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="mb-2 flex items-center justify-between gap-4">
            <h1 class="text-brand-gray text-2xl font-bold">Roles</h1>
            <button
                @click="openModal({ id: 0, name: '' })"
                as="button"
                id="btnNuevo"
                class="ml-auto cursor-pointer rounded-lg bg-primary px-4 py-2 text-white transition-colors duration-300 hover:bg-secondary"
            >
                Agregar un nuevo rol
            </button>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-xl">
            <DataTable
                :data="rol"
                :columns="columns"
                :options="options"
                class="w-full"
            >
                <template #column-2="{ cellData, rowData }">
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            class="cursor-pointer transition-colors"
                            title="Cambiar estado"
                            @click.stop="
                                cambiarEstado(
                                    rowData.id,
                                    rowData.active === 1 ? 0 : 1,
                                )
                            "
                        >
                            <ToggleRight
                                v-if="rowData.active === 1"
                                class="h-6 w-6 text-green-600 hover:text-green-700"
                            />
                            <ToggleLeft
                                v-else
                                class="h-6 w-6 text-red-600 hover:text-red-700"
                            />
                        </button>

                        <button
                            @click.prevent="openEditModal(rowData)"
                            class="cursor-pointer text-yellow-600 transition-colors hover:text-yellow-800"
                            title="Editar rol"
                        >
                            <SquarePen class="h-5 w-5" />
                        </button>
                    </div>
                </template>
            </DataTable>
        </div>
        <modalRol
            :is-open="isModalOpen"
            :Rol="selectedRol"
            :Permisos="[]"
            @close="closeModal"
        />
    </div>
</template>
