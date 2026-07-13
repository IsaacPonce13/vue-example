<script>
import { Head } from '@inertiajs/vue3';
import { modulos } from '@/routes';
import formulario from '@/components/modulos/formulario.vue';
</script>

<template>
    <Head title="Crear módulo" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <h1>Crear módulo</h1>
        </div>
        <formulario/>
    </div>

</template>