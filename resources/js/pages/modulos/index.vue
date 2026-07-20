<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Modulo, Paginator } from '@/types/modulo';

import ModuloCard from '@/components/modulos/ModuloCard.vue';
import ModuloPreviewModal from '@/components/modulos/ModuloPreviewModal.vue';
import Pagination from '@/components/Pagination.vue';

import { modulos } from '@/routes';
import modulosRoutes from '@/routes/modulos';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Modulos',
                href: modulos().url,
            },
        ],
    },
});

const props = defineProps<{ modulos: Paginator<Modulo> }>();

const modeloEnPreview = ref<Modulo | null>(null);

const abrirPreview = (modulo: Modulo) => {
    modeloEnPreview.value = modulo;
};

const cerrarPreview = () => {
    modeloEnPreview.value = null;
};
const modules = props.modulos || [];
console.log('Modulo: ', modules);

const alternarEstado = (modulo: Modulo) => {
    // router.patch(
    //     modulosRoutes.toggleEstado(modulo.id).url,
    //     {},
    //     { preserveScroll: true, preserveState: true },
    // );
    console.log('Cambiar estado de:', props.modulos.data);
};
</script>

<template>
    <Head title="Catálogo de módulos" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="mb-2 flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">
                Catálogo de módulos
            </h1>
            <Link
                :href="modulosRoutes.create().url"
                id="btnNuevo"
                class="ml-auto cursor-pointer rounded-lg bg-primary px-4 py-2 text-sm text-white transition-colors duration-300 hover:bg-secondary"
            >
                Agregar módulo
            </Link>
        </div>

        <div
            class="flex flex-1 flex-col gap-6 rounded-lg bg-white p-6 shadow-xl"
        >
            <p
                v-if="props.modulos.data === null"
                class="py-12 text-center text-sm text-gray-500"
            >
                Todavía no hay módulos cargados. Creá el primero con "Agregar
                módulo".
            </p>
            <div
                v-else
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3"
            >
                <ModuloCard
                    v-for="modulo in props.modulos.data"
                    :key="modulo.id"
                    :modulo="modulo"
                    @preview="abrirPreview"
                    @toggle="alternarEstado"
                />
            </div>

            <Pagination :paginator="props.modulos" />
        </div>
    </div>

    <ModuloPreviewModal :modulo="modeloEnPreview" @close="cerrarPreview" />
</template>
