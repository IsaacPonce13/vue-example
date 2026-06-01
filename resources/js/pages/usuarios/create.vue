<script setup lang="ts">
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';
import Swal from 'sweetalert2';

import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { usuarios } from '@/routes';
import { route } from 'ziggy-js';

import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

defineOptions({
    layout: {
        title: 'Registrar usuario',
        description:
            'Ingresa los datos para crear un nuevo usuario en el sistema.',
        breadcrumbs: [
            {
                title: 'Crear usuario',
                href: usuarios().url,
            },
        ],
    },
});

const rolesSource = [
    { id_rol: 1, value: 1, label: 'Administrador' },
    { id_rol: 2, value: 2, label: 'Usuario' },
    { id_rol: 3, value: 3, label: 'Invitado' },
];

const dependenciasSource = [
    { id_dependencia: 1, value: 1, label: 'Departamento TI' },
    { id_dependencia: 2, value: 2, label: 'Recursos Humanos' },
    { id_dependencia: 3, value: 3, label: 'Finanzas' },
];

const form = useForm({
    name: '',
    primer_apellido: '',
    segundo_apellido: '',
    numero_control: '',
    id_rol: '',
    id_dependencia: '',
    email: '',
    email_confirmation: '',
    password: '',
    password_confirmation: '',
});

const handleSubmit = () => {
    form.post(route('usuarios.store'), {
        onSuccess: () => {
            Swal.fire({
                icon: 'success',
                title: 'Usuario creado',
                text: 'El usuario ha sido creado exitosamente.',
                timer: 2000,
                showConfirmButton: false,
            });
        },
        onError: (errors) => {
            console.error('❌ [FORM] Errores de validación:', errors);
        },
    });
};

const handleCancel = () => {
    router.visit(route('usuarios'));
};
</script>

<template>
    <Head title="Registrar" />
    <div class="flex flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <h1 class="text-brand-gray text-2xl font-bold">Registrar usuario</h1>

        <form @submit.prevent="handleSubmit" class="flex flex-col gap-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="grid gap-2">
                    <Label for="name">Nombre(s)</Label>
                    <Input
                        id="name"
                        v-model="form.name"
                        type="text"
                        autofocus
                        :tabindex="1"
                        autocomplete="nombre"
                        placeholder="Nombre(s)"
                    />
                    <p v-if="form.errors.name" class="text-sm text-red-600">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="primer_apellido">Primer apellido</Label>
                    <Input
                        id="primer_apellido"
                        v-model="form.primer_apellido"
                        type="text"
                        autofocus
                        :tabindex="2"
                        autocomplete="primer_apellido"
                        placeholder="Ingrese el primer apellido"
                    />
                    <p
                        v-if="form.errors.primer_apellido"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.primer_apellido }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="segundo_apellido">Segundo apellido</Label>
                    <Input
                        id="segundo_apellido"
                        v-model="form.segundo_apellido"
                        type="text"
                        :tabindex="3"
                        autocomplete="segundo_apellido"
                        placeholder="Ingrese el segundo apellido"
                    />
                    <p
                        v-if="form.errors.segundo_apellido"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.segundo_apellido }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="numero_control">Número de control</Label>
                    <Input
                        id="numero_control"
                        v-model="form.numero_control"
                        type="number"
                        :tabindex="4"
                        autocomplete="numero_control"
                        placeholder="Ingrese su número de control"
                    />
                    <p
                        v-if="form.errors.numero_control"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.numero_control }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="id_rol">Rol del Usuario</Label>
                    <Select v-model="form.id_rol" :tabindex="5">
                        <SelectTrigger id="id_rol" class="w-full">
                            <SelectValue
                                placeholder="Seleccione un rol de usuario"
                            />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Roles del usuario</SelectLabel>
                                <SelectItem
                                    v-for="item in rolesSource"
                                    :key="item.value"
                                    :value="item.value"
                                >
                                    {{ item.label }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <p v-if="form.errors.id_rol" class="text-sm text-red-600">
                        {{ form.errors.id_rol }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="id_dependencia">Dependencia</Label>
                    <Select v-model="form.id_dependencia" :tabindex="6">
                        <SelectTrigger id="id_dependencia" class="w-full">
                            <SelectValue
                                placeholder="Seleccione una dependencia"
                            />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel
                                    >Dependencia del usuario</SelectLabel
                                >
                                <SelectItem
                                    v-for="item in dependenciasSource"
                                    :key="item.value"
                                    :value="item.value"
                                >
                                    {{ item.label }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <p
                        v-if="form.errors.id_dependencia"
                        class="text-sm text-red-600"
                    >
                        {{ form.errors.id_dependencia }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="email">Correo electrónico</Label>
                    <Input
                        id="email"
                        v-model="form.email"
                        type="email"
                        :tabindex="7"
                        autocomplete="email"
                        placeholder="email@ejemplo.com"
                    />
                    <p v-if="form.errors.email" class="text-sm text-red-600">
                        {{ form.errors.email }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="email_confirmation"
                        >Confirmar correo electrónico</Label
                    >
                    <Input
                        id="email_confirmation"
                        v-model="form.email_confirmation"
                        type="email"
                        :tabindex="8"
                        autocomplete="email"
                        placeholder="email@ejemplo.com"
                    />
                    <p v-if="form.errors.email" class="text-sm text-red-600">
                        {{ form.errors.email }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="password">Contraseña</Label>
                    <PasswordInput
                        id="password"
                        v-model="form.password"
                        :tabindex="9"
                        autocomplete="new-password"
                        placeholder="Contraseña"
                    />
                    <p v-if="form.errors.password" class="text-sm text-red-600">
                        {{ form.errors.password }}
                    </p>
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation"
                        >Confirmar contraseña</Label
                    >
                    <PasswordInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        :tabindex="10"
                        autocomplete="new-password"
                        placeholder="Confirmar contraseña"
                    />
                    <p v-if="form.errors.password" class="text-sm text-red-600">
                        {{ form.errors.password }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <Button
                    type="submit"
                    class="mt-2"
                    tabindex="11"
                    :disabled="form.processing"
                >
                    <Spinner v-if="form.processing" class="mr-2 h-4 w-4" />
                    Agregar usuario
                </Button>

                <Button
                    type="button"
                    class="mt-2"
                    variant="outline"
                    @click="handleCancel"
                    :disabled="form.processing"
                >
                    Cancelar
                </Button>
            </div>
        </form>
    </div>
</template>
