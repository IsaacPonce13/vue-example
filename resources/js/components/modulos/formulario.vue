<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { modulos } from '@/routes';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Crear nuevo módulo',
                href: modulos(),
            },
        ],
    },
});

</script>

<template>
    <Head title="Crear módulo" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <h1>Crear módulo</h1>
        </div>
    </div>
</template>
