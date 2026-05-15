<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Modulos',
                href: dashboard(),
            },
        ],
    },
});

defineProps({ users: Array });
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
        </div>
        <div class="bg-white p-6 shadow-xl rounded-lg">
            <DataTable :data="users" :columns="columns" :options="options" class="w-full" />
        </div>
    </div>
</template>
