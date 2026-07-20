<script setup lang="ts">
import { computed, ref, watch, type Ref } from 'vue';
import {
    DateFormatter,
    getLocalTimeZone,
    parseDate,
    today,
    type DateValue,
} from '@internationalized/date';
import { CalendarIcon, Clock } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import { cn } from '@/lib/utils';

const props = defineProps({
    modelValue: { type: String, default: '' },
    placeholder: {
        type: String,
        default: 'Seleccione fecha y hora',
    },
});
const emit = defineEmits(['update:modelValue']);

const date = ref<DateValue | undefined>();
const time = ref('12:00');
const defaultPlaceholder = today(getLocalTimeZone());

const formatter = new DateFormatter('es-MX', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    hour12: true,
});

const parseModelValue = (value: string) => {
    if (!value) {
        date.value = undefined;
        time.value = '12:00';
        return;
    }

    const normalized = value.trim().replace(' ', 'T');
    const [datePart, timePart = '12:00'] = normalized.split('T');

    if (!datePart) {
        date.value = undefined;
        return;
    }

    date.value = parseDate(datePart);
    const [hours = '12', minutes = '00'] = timePart.split(':');
    time.value = `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
};

const emitDateTime = () => {
    if (!date.value) {
        emit('update:modelValue', '');
        return;
    }

    const year = String(date.value.year).padStart(4, '0');
    const month = String(date.value.month).padStart(2, '0');
    const day = String(date.value.day).padStart(2, '0');
    const value = `${year}-${month}-${day}T${time.value}:00`;

    emit('update:modelValue', value);
};

parseModelValue(props.modelValue);

watch(
    () => props.modelValue,
    (value) => {
        if (value !== undefined) {
            parseModelValue(value);
        }
    },
);

watch([date, time], emitDateTime, { immediate: true });

const formattedDateTime = computed(() => {
    if (!date.value) {
        return props.placeholder;
    }

    const year = String(date.value.year).padStart(4, '0');
    const month = String(date.value.month).padStart(2, '0');
    const day = String(date.value.day).padStart(2, '0');
    const jsDate = new Date(`${year}-${month}-${day}T${time.value}:00`);

    return formatter.format(jsDate);
});
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                :class="
                    cn(
                        'w-[280px] justify-start text-left font-normal',
                        'text-muted-foreground',
                    )
                "
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                {{ formattedDateTime }}
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <!-- Calendario para seleccionar la fecha -->
            <Calendar
                v-model="date"
                :initial-focus="true"
                :default-placeholder="defaultPlaceholder"
                layout="month-and-year"
            />

            <!-- Sección para seleccionar la hora -->
            <div
                class="flex items-center justify-between border-t border-border p-3"
            >
                <div class="flex items-center gap-2">
                    <Clock class="h-4 w-4 text-muted-foreground" />
                    <Label for="time-picker" class="text-xs font-medium"
                        >Hora:</Label
                    >
                </div>
                <Input
                    id="time-picker"
                    v-model="time"
                    type="time"
                    class="h-8 w-auto px-2 py-1 text-xs"
                />
            </div>
        </PopoverContent>
    </Popover>
</template>
