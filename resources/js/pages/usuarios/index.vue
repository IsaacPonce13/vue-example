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

var usuario = [
    { id: 1, nombre: 'usuario 1', tipo_usuario: 'Tipo A' },
    { id: 2, nombre: 'usuario 2', tipo_usuario: 'Tipo B' },
    { id: 3, nombre: 'usuario 3', tipo_usuario: 'Tipo C' },
];

defineProps({ usuarios: Array });

const columns = [
    { title: 'Id', data: 'id' },
    { title: 'Nombre', data: 'nombre' },
    { title: 'Tipo usuario', data: 'tipo_usuario' },
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
                :data="usuario"
                :columns="columns"
                :options="options"
                class="w-full"
            />
        </div>
    </div>
</template>
