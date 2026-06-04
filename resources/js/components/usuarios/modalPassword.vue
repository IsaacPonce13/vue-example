<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import PasswordInput from '@/components/PasswordInput.vue';
import { Spinner } from '@/components/ui/spinner';
import Swal from 'sweetalert2';

interface User {
    id: number;
    name: string;
    primer_apellido: string;
    segundo_apellido: string | null;
    numero_control: string;
}

interface Props {
    isOpen: boolean;
    user?: User | null;
}

interface Emits {
    (e: 'close'): void;
}

const props = defineProps<Props>();
defineEmits<Emits>();

const password = ref('');
const passwordConfirmation = ref('');
const isLoading = ref(false);

const getFullName = (user: User | null | undefined) => {
    if (!user) return '';
    const parts = [
        user.name,
        user.primer_apellido,
        user.segundo_apellido,
    ].filter(Boolean);
    return parts.join(' ');
};

const handleSubmit = async () => {
    if (!password.value || !passwordConfirmation.value) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Los campos de contraseña no pueden estar vacíos',
        });
        return;
    }

    if (password.value !== passwordConfirmation.value) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Las contraseñas no coinciden',
        });
        return;
    }

    if (password.value.length < 8) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La contraseña debe tener al menos 8 caracteres',
        });
        return;
    }

    isLoading.value = true;

    router.put(
        `/usuarios/${props.user?.id}/password`,
        { password: password.value },
        {
            // 1. Si todo sale bien, muestra la alerta y cierra el modal
            onSuccess: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Contraseña actualizada correctamente',
                    confirmButtonColor: '#7F2841', // Tu guinda institucional opcional
                }).then(() => {
                    if (typeof closeModal === 'function') {
                        closeModal();
                    }
                });
            },

            // 2. Si hay errores de validación en el backend
            onError: (errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar la contraseña',
                });
            },

            // 3. Reemplazo del 'finally': Se ejecuta SIEMPRE al terminar la petición
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
};

const closeModal = () => {
    password.value = '';
    passwordConfirmation.value = '';
};
</script>

<template>
    <!-- Main modal -->
    <div
        v-if="isOpen"
        tabindex="-1"
        aria-hidden="false"
        class="fixed top-0 right-0 left-0 z-50 flex h-screen w-full items-center justify-center overflow-x-hidden overflow-y-auto bg-black/50 md:inset-0"
    >
        <div
            class="relative max-h-full w-full max-w-md rounded-lg bg-white p-4 shadow-xl md:p-6"
        >
            <!-- Modal content -->
            <div
                class="border-default rounded-base relative border p-4 shadow-sm md:p-6"
            >
                <!-- Modal header -->
                <div
                    class="border-default flex items-center justify-between border-b pb-4 md:pb-5"
                >
                    <h3 class="text-heading text-lg font-medium">
                        Cambiar contraseña de
                        <span class="font-bold">{{ getFullName(user) }}</span>
                    </h3>
                    <Button
                        type="Button"
                        class="text-body hover:bg-neutral-tertiary hover:text-heading rounded-base ms-auto inline-flex h-9 w-9 items-center justify-center bg-transparent text-sm"
                        @click="
                            () => {
                                closeModal();
                                $emit('close');
                            }
                        "
                    >
                        <svg
                            class="h-5 w-5"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18 17.94 6M18 18 6.06 6"
                            />
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </Button>
                </div>
                <!-- Modal body -->
                <form @submit.prevent="handleSubmit" class="pt-4 md:pt-6">
                    <div class="mb-4 rounded bg-blue-50 p-3">
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold"
                                >Número de control:</span
                            >
                            {{ user?.numero_control }}
                        </p>
                    </div>
                    <div class="mb-4">
                        <Label
                            for="password"
                            class="text-heading mb-2.5 block text-sm font-medium"
                            required
                        >
                            Nueva contraseña</Label
                        >
                        <PasswordInput
                            id="password"
                            v-model="password"
                            :tabindex="1"
                            autocomplete="new-password"
                            placeholder="Contraseña"
                        />
                        <!-- <p v-if="form.errors.password" class="text-sm text-red-600">
                        {{ form.errors.password }}
                    </p> -->
                    </div>
                    <div class="mb-6">
                        <Label
                            for="passwordConfirmation"
                            class="text-heading mb-2.5 block text-sm font-medium"
                            required
                            >Confirmar contraseña</Label
                        >
                        <PasswordInput
                            id="passwordConfirmation"
                            v-model="passwordConfirmation"
                            :tabindex="2"
                            autocomplete="new-password"
                            placeholder="Contraseña"
                        />
                        <!-- <p v-if="form.errors.password" class="text-sm text-red-600">
                        {{ form.errors.password }}
                    </p> -->
                    </div>
                    <div class="flex gap-3">
                        <Button
                            type="submit"
                            :disabled="isLoading"
                            class="mt-2"
                        >
                            <Spinner v-if="isLoading" class="mr-2 h-4 w-4" />
                            {{
                                isLoading
                                    ? 'Guardando...'
                                    : 'Guardar contraseña'
                            }}
                        </Button>
                        <Button
                            type="button"
                            @click="
                                () => {
                                    closeModal();
                                    $emit('close');
                                }
                            "
                            class="mt-2"
                            variant="outline"
                        >
                            Cancelar
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
