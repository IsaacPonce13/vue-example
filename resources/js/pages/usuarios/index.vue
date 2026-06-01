<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { usuarios } from '@/routes';
import usuariosRoutes from '@/routes/usuarios';

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
    name: string;
    primer_apellido: string;
    segundo_apellido: string;
    numero_control: string;
    id_rol: number;
    id_dependencia: number;
}
interface Props {
    usuarios: users[];
}

const props = defineProps<Props>();

// defineProps({ usuarios: Object });

const columns = [
    { title: 'Numero de control', data: 'numero_control' },
    { title: 'Nombre', data: 'nombre' },
    { title: 'Rol', data: 'id_rol' },
    { title: 'Dependencia', data: 'id_dependencia' },
    // { title: 'Acciones', data: null, render: (usuario) => {
    //     return `
    //         <div class="flex gap-2">
    //             <button class="edit-btn" data-id="${usuario.id}">Editar</button>
    //             <button class="delete-btn" data-id="${usuario.id}">Eliminar</button>
    //         </div>
    //     `;
    // } },
];
const options = { responsive: true };
</script>

<template>
    <Head title="Dashboard" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <h1>Usuarios</h1>
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
                :data="usuarios"
                :columns="columns"
                :options="options"
                class="w-full"
            />
        </div>
    </div>
</template>
