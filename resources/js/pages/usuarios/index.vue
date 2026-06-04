<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usuarios } from '@/routes';
import usuariosRoutes from '@/routes/usuarios';

// Importación normal de los iconos en PascalCase
import {
    SquarePen,
    ToggleRight,
    ToggleLeft,
    LockKeyhole,
} from 'lucide-vue-next';

import ModalPassword from '@/components/usuarios/modalPassword.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'usuarios',
                href: usuarios().url,
            },
        ],
    },
});

interface users {
    id: number;
    name: string;
    primer_apellido: string;
    segundo_apellido: string | null;
    numero_control: string;
    id_rol: number;
    id_dependencia: number;
    active?: boolean;
}

interface Props {
    users: users[];
}

const props = defineProps<Props>();
const users = props.users || [];

const isModalOpen = ref(false);
const selectedUser = ref<users | null>(null);

const openPasswordModal = (user: users) => {
    selectedUser.value = user;
    isModalOpen.value = true;
};

const closePasswordModal = () => {
    isModalOpen.value = false;
    selectedUser.value = null;
};

const columns = [
    {
        title: 'Número de control',
        data: 'numero_control',
        className: 'dt-left',
    },
    {
        title: 'Nombre',
        data: null,
        className: 'dt-left',
        render: (usuario: any) => {
            const parts = [
                usuario.name,
                usuario.primer_apellido,
                usuario.segundo_apellido,
            ].filter(Boolean);
            return parts.join(' ');
        },
    },
    {
        title: 'Rol',
        data: 'id_rol',
        className: 'dt-left',
    },
    {
        title: 'Dependencia',
        data: 'id_dependencia',
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
            <h1 class="text-brand-gray text-2xl font-bold">Usuarios</h1>
            <Link
                :href="usuariosRoutes.create().url"
                as="button"
                id="btnNuevo"
                class="ml-auto cursor-pointer rounded-lg bg-primary px-4 py-2 text-white transition-colors duration-300 hover:bg-secondary"
            >
                Nuevo usuario
            </Link>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-xl">
            <DataTable
                :data="users"
                :columns="columns"
                :options="options"
                class="w-full"
            >
                <template #column-4="{ cellData, rowData }">
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            class="cursor-pointer transition-colors"
                            title="Cambiar estado"
                        >
                            <ToggleRight
                                v-if="rowData.active !== false"
                                class="h-6 w-6 text-green-600 hover:text-green-700"
                            />
                            <ToggleLeft
                                v-else
                                class="h-6 w-6 text-gray-400 hover:text-gray-500"
                            />
                        </button>

                        <Link
                            :href="`/usuarios/${rowData.id}/editar`"
                            class="text-yellow-600 transition-colors hover:text-yellow-800"
                            title="Editar usuario"
                        >
                            <SquarePen class="h-5 w-5" />
                        </Link>
                        <!-- <Link
                            :href="`/usuarios/${rowData.id}/password`"
                            class="text-blue-600 transition-colors hover:text-blue-800"
                            title="Editar contraseña"
                        >
                            <LockKeyhole class="h-5 w-5" />
                        </Link> -->

                        <button
                            @click="openPasswordModal(rowData)"
                            class="text-blue-600 transition-colors hover:text-blue-800"
                            type="button"
                            title="Cambiar contraseña"
                        >
                            <LockKeyhole class="h-5 w-5" />
                        </button>
                    </div>
                </template>
            </DataTable>
        </div>
        <ModalPassword
            :is-open="isModalOpen"
            :user="selectedUser"
            @close="closePasswordModal"
        />
    </div>
</template>
