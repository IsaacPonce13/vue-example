<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Swal from 'sweetalert2';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import dependencias from '@/routes/admin/dependencias';
import MapaDependencia from '@/components/dependencias/mapa.vue';
import {
    TagsInput,
    TagsInputInput,
    TagsInputItem,
    TagsInputItemDelete,
    TagsInputItemText,
} from '@/components/ui/tags-input';

import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

interface Dependencia {
    id: number;
    descripcion: string;
    adscripcion: string | null;
    id_padre: number | null;
    metadatos: string | null;
    shortname: string;
    tipo_dependencia: string;
    telefono: string;
    email: string;
    horarios: string;
    active?: boolean;
    codigo_postal: number;
    id_municipio: number;
    colonia: string;
    calle_numero: string;
    latitud: string;
    longitud: string;
}

interface IdPadreOption {
    id: number;
    descripcion: string;
}

interface TipoDependenciaOption {
    id: string;
    descripcion: string;
}

interface Props {
    dependencia?: Dependencia;
    dependenciaPadre: IdPadreOption[];
    tipoDependencias: TipoDependenciaOption[];
    isEditing: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    isEditing: false,
});

// Títulos dinámicos
const pageTitle = computed(() =>
    props.isEditing ? 'Editar dependencia' : 'Registrar dependencia',
);

const pageDescription = computed(() =>
    props.isEditing
        ? 'Modifica los datos de la dependencia seleccionada.'
        : 'Ingresa los datos para crear una nueva dependencia en el sistema.',
);

const idPadreSource = ref(props.dependenciaPadre);
const tipoDependenciaSource = ref(props.tipoDependencias);

console.log('idPadreSource:', idPadreSource.value);
console.log('tipoDependenciaSource:', tipoDependenciaSource.value);

const form = useForm({
    descripcion: props.dependencia?.descripcion || '',
    adscripcion: props.dependencia?.adscripcion || '',
    id_padre: props.dependencia?.id_padre || '',
    metadatos: props.dependencia?.metadatos
        ? JSON.parse(props.dependencia.metadatos)
        : [],
    shortname: props.dependencia?.shortname || '',
    tipo_dependencia: props.dependencia?.tipo_dependencia || '',
    calle_numero: props.dependencia?.calle_numero || '',
    colonia: props.dependencia?.colonia || '',
    id_municipio: props.dependencia?.id_municipio || '',
    codigo_postal: props.dependencia?.codigo_postal || '',
    latitud: props.dependencia?.latitud || '',
    longitud: props.dependencia?.longitud || '',
    telefono: props.dependencia?.telefono || '',
    email: props.dependencia?.email || '',
    email_confirmation: props.dependencia?.email || '',
    horarios: props.dependencia?.horarios || '',
});

const handleSubmit = () => {
    if (props.isEditing && props.dependencia) {
        form.put(dependencias.update(props.dependencia.id).url, {
            onSuccess: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Dependencia actualizada',
                    text: 'La dependencia ha sido actualizada exitosamente.',
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
                    title: 'Dependencia creada',
                    text: 'La dependencia ha sido creada exitosamente.',
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
                    <Label for="descripcion" required>Descripción</Label>
                    <Input
                        id="descripcion"
                        v-model="form.descripcion"
                        type="text"
                        autofocus
                        :tabindex="1"
                        autocomplete="descripcion"
                        placeholder="Ingrese la descripción de la dependencia"
                    />
                    <p
                        v-if="form.errors.descripcion"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.descripcion }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="shortname" required
                        >Nombre corto (Shortname)</Label
                    >
                    <Input
                        id="shortname"
                        v-model="form.shortname"
                        type="text"
                        :tabindex="2"
                        autocomplete="shortname"
                        placeholder="Ej. SEGOB, Finanzas"
                    />
                    <p
                        v-if="form.errors.shortname"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.shortname }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="adscripcion" required>Adscripción</Label>
                    <Input
                        id="adscripcion"
                        v-model="form.adscripcion"
                        type="text"
                        :tabindex="3"
                        autocomplete="adscripcion"
                        placeholder="Ingrese la adscripción"
                    />
                    <p
                        v-if="form.errors.adscripcion"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.adscripcion }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="id_padre"
                        >Dependencia a la que pertenece (Opcional)</Label
                    >
                    <Select v-model="form.id_padre" :tabindex="4">
                        <SelectTrigger id="id_padre" class="w-full">
                            <SelectValue
                                placeholder="Seleccione la dependencia padre"
                            />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Dependencias</SelectLabel>
                                <SelectItem
                                    v-for="item in idPadreSource"
                                    :key="item.id"
                                    :value="item.id"
                                >
                                    {{ item.descripcion }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <p v-if="form.errors.id_padre" class="text-sm text-red-600">
                        {{ form.errors.id_padre }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="tipo_dependencia" required
                        >Tipo de Dependencia</Label
                    >
                    <Select v-model="form.tipo_dependencia" :tabindex="5">
                        <SelectTrigger id="tipo_dependencia" class="w-full">
                            <SelectValue placeholder="Seleccione un tipo" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Tipos de dependencia</SelectLabel>
                                <SelectItem
                                    v-for="item in tipoDependenciaSource"
                                    :key="item.id"
                                    :value="item.id"
                                >
                                    {{ item.descripcion }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <p
                        v-if="form.errors.tipo_dependencia"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.tipo_dependencia }}
                    </p>
                </div>
            </div>

            <h2 class="text-lg font-semibold text-gray-700">
                Información de contacto y ubicación
            </h2>
            <div class="grid gap-6 md:grid-cols-2">
                <div class="grid gap-2">
                    <Label for="telefono" required>Teléfono</Label>
                    <Input
                        id="telefono"
                        v-model="form.telefono"
                        type="tel"
                        :tabindex="10"
                        placeholder="Ej. 3121234567"
                    />
                    <p v-if="form.errors.telefono" class="text-sm text-red-600">
                        {{ form.errors.telefono }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="horarios" required>Horarios de atención</Label>
                    <Input
                        id="horarios"
                        v-model="form.horarios"
                        type="text"
                        :tabindex="15"
                        placeholder="Ej. Lunes a Viernes de 9:00 a 15:00 hrs"
                    />
                    <p v-if="form.errors.horarios" class="text-sm text-red-600">
                        {{ form.errors.horarios }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="email" required>Correo electrónico</Label>
                    <Input
                        id="email"
                        v-model="form.email"
                        type="email"
                        :tabindex="13"
                        autocomplete="email"
                        placeholder="email@ejemplo.com"
                    />
                    <p v-if="form.errors.email" class="text-sm text-red-600">
                        {{ form.errors.email }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="email_confirmation" required
                        >Confirmar correo electrónico</Label
                    >
                    <Input
                        id="email_confirmation"
                        v-model="form.email_confirmation"
                        type="email"
                        :tabindex="14"
                        autocomplete="email"
                        placeholder="email@ejemplo.com"
                    />
                    <p
                        v-if="form.errors.email_confirmation"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.email_confirmation }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="metadatos">Metadatos</Label>
                    <TagsInput v-model="form.metadatos" class="w-[300px]">
                        <TagsInputItem
                            v-for="item in form.metadatos"
                            :key="item"
                            :value="item"
                        >
                            <TagsInputItemText />
                            <TagsInputItemDelete />
                        </TagsInputItem>
                        <TagsInputInput
                            id="metadatos"
                            placeholder="Metadatos de la dependencia"
                            :tabindex="16"
                        />
                    </TagsInput>
                    <p
                        v-if="form.errors.metadatos"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.metadatos }}
                    </p>
                </div>
                <br />

                <div class="grid gap-2">
                    <Label for="codigo_postal" required>Código Postal</Label>
                    <Input
                        id="codigo_postal"
                        v-model="form.codigo_postal"
                        type="number"
                        :tabindex="6"
                        placeholder="Ej. 28000"
                    />
                    <p
                        v-if="form.errors.codigo_postal"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.codigo_postal }}
                    </p>
                </div>
                <div class="grid gap-2">
                    <Label for="id_municipio" required>Municipio</Label>
                    <Select v-model="form.id_municipio" :tabindex="7">
                        <SelectTrigger id="id_municipio" class="w-full">
                            <SelectValue
                                placeholder="Seleccione un municipio"
                            />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Municipios</SelectLabel>
                                <!-- <SelectItem
                                    v-for="item in MunicipioSource"
                                    :key="item.id"
                                    :value="item.id"
                                    disabled
                                > 
                                    {{ item.descripcion }}
                                </SelectItem>-->
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <p
                        v-if="form.errors.id_municipio"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.id_municipio }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="calle_numero" required>Calle y número</Label>
                    <Input
                        id="calle_numero"
                        v-model="form.calle_numero"
                        type="text"
                        :tabindex="8"
                        placeholder="Ej. Av. Principal 123"
                    />
                    <p
                        v-if="form.errors.calle_numero"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.calle_numero }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="colonia" required>Colonia</Label>
                    <Input
                        id="colonia"
                        v-model="form.colonia"
                        type="text"
                        :tabindex="9"
                        placeholder="Nombre de la colonia"
                    />
                    <p v-if="form.errors.colonia" class="text-sm text-red-600">
                        {{ form.errors.colonia }}
                    </p>
                </div>
                <div class="grid gap-2">
                    <Label for="latitud" required>Latitud</Label>
                    <Input
                        id="latitud"
                        v-model="form.latitud"
                        type="text"
                        :tabindex="11"
                        placeholder="Ej. 19.245233"
                    />
                    <p v-if="form.errors.latitud" class="text-sm text-red-600">
                        {{ form.errors.latitud }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="longitud" required>Longitud</Label>
                    <Input
                        id="longitud"
                        v-model="form.longitud"
                        type="text"
                        :tabindex="12"
                        placeholder="Ej. -103.724086"
                    />
                    <p v-if="form.errors.longitud" class="text-sm text-red-600">
                        {{ form.errors.longitud }}
                    </p>
                </div>
            </div>
            <MapaDependencia
                :ubicacion="{
                    direccion: `${form.calle_numero}, ${form.colonia}, ${form.codigo_postal}`,
                    latitud: form.latitud,
                    longitud: form.longitud,
                }"
            />

            <div class="mt-4 flex items-center gap-4">
                <Button type="submit" tabindex="17" :disabled="form.processing">
                    <Spinner v-if="form.processing" class="mr-2 h-4 w-4" />
                    {{
                        props.isEditing
                            ? 'Actualizar dependencia'
                            : 'Agregar dependencia'
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
