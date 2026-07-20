<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { Paginator } from '@/types/modulo';

// Generico: sirve para cualquier paginador de Laravel, no solo modulos.
defineProps<{ paginator: Paginator<unknown> }>();
</script>

<template>
    <nav
        v-if="paginator.last_page > 1"
        class="flex flex-wrap items-center justify-between gap-3 pt-2"
        aria-label="Paginación"
    >
        <p class="text-sm text-gray-500">
            Mostrando {{ paginator.from }}–{{ paginator.to }} de
            {{ paginator.total }}
        </p>

        <ul class="flex items-center gap-1">
            <li v-for="(link, i) in paginator.links" :key="i">
                <span
                    v-if="!link.url"
                    class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm text-gray-300"
                    v-html="link.label"
                ></span>
                <Link
                    v-else
                    :href="link.url"
                    preserve-scroll
                    class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm transition-colors"
                    :class="
                        link.active
                            ? 'bg-primary text-white'
                            : 'text-gray-600 hover:bg-gray-100'
                    "
                    v-html="link.label"
                ></Link>
            </li>
        </ul>
    </nav>
</template>
