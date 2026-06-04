<script setup lang="ts">
import { computed, type HTMLAttributes } from 'vue'
import { Label, type LabelProps } from 'radix-vue'
import { cn } from '@/lib/utils'

// Extendemos las propiedades para aceptar "required"
const props = defineProps<LabelProps & { 
  class?: HTMLAttributes['class'];
  required?: boolean; 
}>()

const delegatedProps = computed(() => {
  const { class: _, required: __, ...delegated } = props
  return delegated
})
</script>

<template>
  <Label
    v-bind="delegatedProps"
    :class="
      cn(
        'text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70',
        props.class,
      )
    "
  >
    <span v-if="props.required" class="text-red-500 font-bold mr-0.5">*</span>
    <slot />
  </Label>
</template>