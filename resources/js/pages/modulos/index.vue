<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
// Importamos el helper tipado para la lista y el submódulo con las rutas CRUD
import { modulos } from '@/routes';
import modulosRoutes from '@/routes/modulos';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Modulos',
                // Agregamos .url porque modulos() devuelve un objeto, no un string
                href: modulos().url, 
            },
        ],
    },
});

var modulo = [
    { id: 1, nombre: 'Modulo 1', tipo_modulo: 'Tipo A' },
    { id: 2, nombre: 'Modulo 2', tipo_modulo: 'Tipo B' },
    { id: 3, nombre: 'Modulo 3', tipo_modulo: 'Tipo C' },
];

defineProps({ modulos: Array });

const columns = [
    { title: 'Id', data: 'id' },
    { title: 'Nombre', data: 'nombre' },
    { title: 'Tipo modulo', data: 'tipo_modulo' },
];
const options = { responsive: true };
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <h1>Modulos</h1>
            <Link 
                :href="modulosRoutes.create().url" 
                as="button" 
                id="btnNuevo"
                class="ml-auto rounded-lg bg-black px-4 py-2 text-white hover:bg-gray-700 cursor-pointer transition-colors duration-300">
                Nuevo módulo
            </Link>
        </div>
        <div class="bg-white p-6 shadow-xl rounded-lg">
            <DataTable :data="modulo" :columns="columns" :options="options" class="w-full" />
        </div>
    </div>
</template>