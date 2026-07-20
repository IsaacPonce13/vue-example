<script setup lang="ts">
import { computed } from 'vue';
import type { Modulo } from '@/types/modulo';

const props = defineProps<{ modulo: Modulo | null }>();
const emit = defineEmits<{ close: [] }>();

const abierto = computed(() => props.modulo !== null);

// Nunca usamos v-html directo con contenido que viene de la BD: viajaria
// al DOM de la app y cualquier <script>/<style> del modulo podria afectar
// el resto de la pagina. Un iframe con sandbox aisla el HTML del modulo
// (sin permitir scripts) y ademas es un preview mas fiel, porque el
// contenido suele incluir sus propios estilos.
const srcdoc = computed(
    () =>
        props.modulo?.contenido ??
        '<p style="font-family:sans-serif;color:#888;padding:1rem;">Este modulo no tiene contenido cargado.</p>',
);
console.log('Contenido: ', props.modulo?.contenido);
</script>

<template>
    <Teleport to="body">
        <div
            v-if="abierto"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            @click.self="emit('close')"
        >
            <div
                class="flex max-h-[85vh] w-full max-w-3xl flex-col rounded-lg bg-white shadow-xl"
            >
                <header
                    class="flex items-center justify-between border-b border-gray-100 px-5 py-3"
                >
                    <div>
                        <h2 class="font-semibold text-gray-900">
                            {{ modulo?.nombre }}
                        </h2>
                        <p class="text-xs text-gray-500">
                            {{ modulo?.tipo_modulo?.nombre ?? 'Sin tipo' }}
                        </p>
                    </div>
                    <button
                        type="button"
                        class="cursor-pointer rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600"
                        aria-label="Cerrar vista previa"
                        @click="emit('close')"
                    >
                        ✕
                    </button>
                </header>

                <div class="flex-1 overflow-hidden p-1">
                    <iframe
                        :srcdoc="srcdoc"
                        sandbox="allow-same-origin"
                        class="h-[60vh] w-full rounded border border-gray-100"
                        title="Vista previa del modulo"
                    ></iframe>
                </div>
            </div>
        </div>
    </Teleport>
</template>
