<script setup lang="ts">
import { computed } from 'vue';
import type { EstadoModulo } from '@/types/modulo';

const props = defineProps<{ estado: EstadoModulo }>();

const config: Record<EstadoModulo, { label: string; classes: string }> = {
    borrador: { label: 'Borrador', classes: 'bg-gray-100 text-gray-600' },
    programada: { label: 'Programada', classes: 'bg-amber-100 text-amber-700' },
    publicado: {
        label: 'Publicado',
        classes: 'bg-emerald-100 text-emerald-700',
    },
    archivado: { label: 'Archivado', classes: 'bg-red-100 text-red-700' },
};

const current = computed(() => config[props.estado]);
</script>

<template>
    <span
        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium"
        :class="current.classes"
    >
        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
        {{ current.label }}
    </span>
</template>
