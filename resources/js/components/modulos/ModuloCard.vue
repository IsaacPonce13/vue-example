<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import modulosRoutes from '@/routes/modulos';
import EstadoBadge from '@/components/modulos/EstadoBadge.vue';
import type { Modulo } from '@/types/modulo';

const props = defineProps<{ modulo: Modulo }>();
const emit = defineEmits<{
    preview: [modulo: Modulo];
    toggle: [modulo: Modulo];
}>();

const puedeAlternarse = computed(
    () =>
        props.modulo.estado === 'publicado' ||
        props.modulo.estado === 'archivado',
);
const estaActivo = computed(() => props.modulo.estado === 'publicado');

const formatFecha = (fecha: string | null) => {
    if (!fecha) return '—';
    return new Intl.DateTimeFormat('es', { dateStyle: 'medium' }).format(
        new Date(fecha),
    );
};
</script>

<template>
    <article
        class="flex flex-col justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition-shadow hover:shadow-md"
    >
        <div>
            <div class="mb-2 flex items-start justify-between gap-2">
                <h3
                    class="truncate font-semibold text-gray-900"
                    :title="modulo.nombre"
                >
                    {{ modulo.nombre }}
                </h3>
                <EstadoBadge :estado="modulo.estado" />
            </div>

            <dl class="space-y-1 text-sm text-gray-500">
                <div class="flex gap-1">
                    <dt class="shrink-0 font-medium text-gray-700">Tipo:</dt>
                    <dd class="truncate">
                        {{ modulo.tipo_modulo?.nombre ?? 'Sin tipo' }}
                    </dd>
                </div>
                <div class="flex gap-1">
                    <dt class="shrink-0 font-medium text-gray-700">
                        Alta / baja:
                    </dt>
                    <dd>
                        {{ formatFecha(modulo.fecha_alta) }} –
                        {{ formatFecha(modulo.fecha_baja) }}
                    </dd>
                </div>
                <div
                    v-if="modulo.fecha_pub_programada"
                    class="flex items-center gap-1 text-amber-700"
                >
                    <dt class="shrink-0 font-medium">
                        Publicación programada:
                    </dt>
                    <dd>{{ formatFecha(modulo.fecha_pub_programada) }}</dd>
                </div>
            </dl>
        </div>

        <div
            class="mt-4 flex items-center justify-between gap-2 border-t border-gray-100 pt-3"
        >
            <button
                type="button"
                class="cursor-pointer rounded-md bg-primary px-3 py-1.5 text-xs font-medium text-white transition-colors duration-300 hover:bg-secondary"
                @click="emit('preview', modulo)"
            >
                Vista previa
            </button>

            <div class="flex items-center gap-3">
                <Link
                    :href="modulosRoutes.edit(modulo.id).url"
                    class="text-xs font-medium text-gray-500 hover:text-primary"
                >
                    Editar
                </Link>

                <button
                    v-if="puedeAlternarse"
                    type="button"
                    role="switch"
                    :aria-checked="estaActivo"
                    :aria-label="
                        estaActivo ? 'Deshabilitar modulo' : 'Habilitar modulo'
                    "
                    class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full transition-colors"
                    :class="estaActivo ? 'bg-primary' : 'bg-gray-300'"
                    @click="emit('toggle', modulo)"
                >
                    <span
                        class="inline-block h-4 w-4 translate-y-0.5 rounded-full bg-white shadow transition-transform"
                        :class="
                            estaActivo ? 'translate-x-4' : 'translate-x-0.5'
                        "
                    ></span>
                </button>
            </div>
        </div>
    </article>
</template>
