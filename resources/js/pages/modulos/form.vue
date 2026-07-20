<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Swal from 'sweetalert2';
import type { Modulo, TipoModulo } from '@/types/modulo';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import dependencias, { estado } from '@/routes/admin/dependencias';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import EditorTexto from '@/components/modulos/EditorTexto.vue';
import InputFechas from '@/components/modulos/InputFechas.vue';

interface DetalleTypeOptions {
    detalle_id: number;
    detalle_type: string;
}

interface IdCategoriaOptions {
    id: number;
    descripcion: string;
}

interface TipoModuloOptions {
    id: number;
    descripcion: string;
}

interface Props {
    modulo?: Modulo;
    isEditing: boolean;
    detalleTypeSource: DetalleTypeOptions[];
    categoriaSource: IdCategoriaOptions[];
    tipoModuloSource: TipoModuloOptions[];
}

const props = withDefaults(defineProps<Props>(), {
    isEditing: false,
});

// Títulos dinámicos
const pageTitle = computed(() =>
    props.isEditing ? 'Editar módulo' : 'Registrar módulo',
);

const pageDescription = computed(() =>
    props.isEditing
        ? 'Modifica los datos del módulo seleccionado.'
        : 'Ingresa los datos para crear un nuevo módulo.',
);

const form = useForm({
    nombre: props.modulo?.nombre || '',
    descripcion: props.modulo?.descripcion || '',
    detalle_type: props.modulo?.detalle_type || '',
    detalle_id: props.modulo?.detalle_id || '',
    contenido: props.modulo?.contenido || '',
    id_categoria: props.modulo?.id_categoria || '',
    tipo_modulo: props.modulo?.tipo_modulo || '',
    estado: props.modulo?.estado || '',
    fecha_alta: props.modulo?.fecha_alta || '',
    fecha_pub_programada: props.modulo?.fecha_pub_programada || '',
    fecha_baja: props.modulo?.fecha_baja || '',
});

const detalleTypeSource = computed(() => props.detalleTypeSource || []);
const categoriaSource = computed(() => props.categoriaSource || []);
const tipoModuloSource = computed(() => props.tipoModuloSource || []);

const handleSubmit = () => {
    if (props.isEditing && props.modulo) {
        form.put(dependencias.update(props.modulo.id).url, {
            onSuccess: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Módulo actualizado',
                    text: 'El módulo ha sido actualizado exitosamente.',
                    timer: 2000,
                    showConfirmButton: false,
                });
            },
            onError: (errors) => {
                console.error('[FORM] Errores de validación:', errors);
            },
        });
    } else {
        form.post(dependencias.store().url, {
            onSuccess: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Modulo creada',
                    text: 'El módulo ha sido creado exitosamente.',
                    timer: 2000,
                    showConfirmButton: false,
                });
            },
            onError: (errors) => {
                console.error('[FORM] Errores de validación:', errors);
            },
        });
    }
};

const handleCancel = () => {
    // Para regresar a la tabla principal de dependencias sin usar Ziggy:
    router.visit(dependencias.index().url); // <--- .url
};
</script>

<template>
    <Head :title="pageTitle" />
    <div class="flex flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <h1 class="text-brand-gray text-2xl font-bold">{{ pageTitle }}</h1>
        <p class="text-sm text-gray-600">{{ pageDescription }}</p>

        <form @submit.prevent="handleSubmit" class="flex flex-col gap-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="grid gap-2">
                    <Label for="nombre" required>Nombre:</Label>
                    <Input
                        id="nombre"
                        v-model="form.nombre"
                        type="text"
                        :tabindex="2"
                        autocomplete="nombre"
                        placeholder="Ingrese el nombre del modulo"
                    />
                    <p v-if="form.errors.nombre" class="text-sm text-red-600">
                        {{ form.errors.nombre }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="descripcion" required>Descripción</Label>
                    <Input
                        id="descripcion"
                        v-model="form.descripcion"
                        type="text"
                        autofocus
                        :tabindex="1"
                        autocomplete="descripcion"
                        placeholder="Ingrese la descripción del módulo"
                    />
                    <p
                        v-if="form.errors.descripcion"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.descripcion }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="detalle_type">Tipo de detalle</Label>
                    <Select v-model="form.detalle_type" :tabindex="4">
                        <SelectTrigger id="detalle_type" class="w-full">
                            <SelectValue
                                placeholder="Seleccione el tipo de módulo"
                            />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Tipo de detalle</SelectLabel>
                                <SelectItem
                                    v-for="item in detalleTypeSource"
                                    :value="item.detalle_id"
                                    :key="item.detalle_id"
                                >
                                    {{ item.detalle_type }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <p
                        v-if="form.errors.detalle_type"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.detalle_type }}
                    </p>
                </div>
                <div class="grid gap-2">
                    <Label for="id_categoria">Categoria del módulo: </Label>
                    <Select v-model="form.id_categoria" :tabindex="4">
                        <SelectTrigger id="id_categoria" class="w-full">
                            <SelectValue
                                placeholder="Seleccione la categoria del módulo"
                            />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Categorias</SelectLabel>
                                <SelectItem
                                    v-for="item in categoriaSource"
                                    :key="item.id"
                                    :value="item.id"
                                >
                                    {{ item.descripcion }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <p
                        v-if="form.errors.id_categoria"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.id_categoria }}
                    </p>
                </div>
            </div>
            <div class="grid flex-auto gap-6 md:grid-cols-4">
                <div class="grid gap-2" max-w-max>
                    <Label for="tipo_modulo" required>Tipo de módulo</Label>
                    <Select v-model="form.tipo_modulo" :tabindex="5">
                        <SelectTrigger id="tipo_modulo" class="w-full">
                            <SelectValue
                                placeholder="Seleccione un tipo de módulo"
                            />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Tipo de módulo</SelectLabel>
                                <SelectItem
                                    v-for="item in tipoModuloSource"
                                    :key="item.id"
                                    :value="item.id"
                                >
                                    {{ item.descripcion }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <p
                        v-if="form.errors.tipo_modulo"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.tipo_modulo }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="fecha_alta" required>Fecha alta:</Label>
                    <InputFechas v-model="form.fecha_alta" />
                    <p
                        v-if="form.errors.fecha_alta"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.fecha_alta }}
                    </p>
                </div>
                <div class="grid gap-2">
                    <Label for="fecha_baja" required>Fecha baja:</Label>
                    <InputFechas v-model="form.fecha_baja" />
                    <p
                        v-if="form.errors.fecha_baja"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.fecha_baja }}
                    </p>
                </div>
                <div class="grid gap-2">
                    <Label for="fecha_pub_programada" required
                        >Fecha de publicación programada:</Label
                    >
                    <InputFechas v-model="form.fecha_pub_programada" />
                    <p
                        v-if="form.errors.fecha_pub_programada"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.fecha_pub_programada }}
                    </p>
                </div>
            </div>

            <div class="grid gap-2">
                <Label for="horarios" required
                    >Código de contenido del módulo</Label
                >
                <EditorTexto v-model="form.contenido" />
                <p v-if="form.errors.contenido" class="text-sm text-red-600">
                    {{ form.errors.contenido }}
                </p>
            </div>
            <br />

            <div class="mt-4 flex items-center gap-4">
                <Button type="submit" tabindex="17" :disabled="form.processing">
                    <Spinner v-if="form.processing" class="mr-2 h-4 w-4" />
                    {{
                        props.isEditing ? 'Actualizar módulo' : 'Agregar módulo'
                    }}
                </Button>

                <Button
                    type="button"
                    variant="outline"
                    @click="handleCancel"
                    :disabled="form.processing"
                    tabindex="18"
                >
                    Cancelar
                </Button>
            </div>
        </form>
    </div>
</template>
