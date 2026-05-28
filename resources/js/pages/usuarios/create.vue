<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

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
    { id_rol: 1, value: 'admin', label: 'Administrador' },
    { id_rol: 2, value: 'user', label: 'Usuario' },
    { id_rol: 3, value: 'guest', label: 'Invitado' },
];

const dependenciasSource = [
    { id_dependencia: 1, value: 'it', label: 'Departamento TI' },
    { id_dependencia: 2, value: 'hr', label: 'Recursos Humanos' },
    { id_dependencia: 3, value: 'finance', label: 'Finanzas' },
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
    form.post(route('usuarios.store'));
};
</script>

<template>
    <Head title="Registrar" />
    <div class="flex flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <h1 class="text-brand-gray text-2xl font-bold">Registrar usuario</h1>

        <form
            v-bind="form"
            :reset-on-success="['password', 'password_confirmation']"
            @submit="handleSubmit"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6 md:grid-cols-2">
                <div class="grid gap-2">
                    <Label for="name">Nombre(s)</Label>
                    <Input
                        id="name"
                        v-model="form.name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="nombre"
                        placeholder="Nombre(s)"
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="primer_apellido">Primer apellido</Label>
                    <Input
                        id="primer_apellido"
                        v-model="form.primer_apellido"
                        type="text"
                        required
                        :tabindex="2"
                        autocomplete="primer_apellido"
                        placeholder="Ingrese el primer apellido"
                    />
                    <InputError :message="form.errors.primer_apellido" />
                </div>

                <div class="grid gap-2">
                    <Label for="segundo_apellido">Segundo apellido</Label>
                    <Input
                        id="segundo_apellido"
                        v-model="form.segundo_apellido"
                        type="text"
                        required
                        :tabindex="3"
                        autocomplete="segundo_apellido"
                        placeholder="Ingrese el segundo apellido"
                    />
                    <InputError :message="form.errors.segundo_apellido" />
                </div>

                <div class="grid gap-2">
                    <Label for="numero_control">Número de control</Label>
                    <Input
                        id="numero_control"
                        v-model="form.numero_control"
                        type="number"
                        required
                        :tabindex="4"
                        autocomplete="numero_control"
                        placeholder="Ingrese su número de control"
                    />
                    <InputError :message="form.errors.numero_control" />
                </div>

                <div class="grid gap-2">
                    <Label for="id_rol">Rol del Usuario</Label>
                    <Select v-model="form.id_rol" required :tabindex="5">
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
                    <InputError :message="form.errors.id_rol" />
                </div>

                <div class="grid gap-2">
                    <Label for="id_dependencia">Dependencia</Label>
                    <Select
                        v-model="form.id_dependencia"
                        required
                        :tabindex="6"
                    >
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
                    <InputError :message="form.errors.id_dependencia" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Correo electrónico</Label>
                    <Input
                        id="email"
                        v-model="form.email"
                        type="email"
                        required
                        :tabindex="7"
                        autocomplete="email"
                        placeholder="email@ejemplo.com"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="email_confirmation"
                        >Confirmar correo electrónico</Label
                    >
                    <Input
                        id="email_confirmation"
                        v-model="form.email_confirmation"
                        type="email"
                        required
                        :tabindex="8"
                        autocomplete="email"
                        placeholder="email@ejemplo.com"
                    />
                    <InputError :message="form.errors.email_confirmation" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Contraseña</Label>
                    <PasswordInput
                        id="password"
                        v-model="form.password"
                        required
                        :tabindex="9"
                        autocomplete="new-password"
                        placeholder="Contraseña"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation"
                        >Confirmar contraseña</Label
                    >
                    <PasswordInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        required
                        :tabindex="10"
                        autocomplete="new-password"
                        placeholder="Confirmar contraseña"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <Button
                    type="submit"
                    class="mt-2"
                    tabindex="11"
                    :disabled="form.processing"
                >
                    <Spinner v-if="form.processing" class="mr-2" />
                    Agregar usuario
                </Button>
            </div>
        </form>
    </div>
</template>
