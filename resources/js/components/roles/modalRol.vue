<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Checkbox } from '@/components/ui/checkbox';
import { Spinner } from '@/components/ui/spinner';
import Swal from 'sweetalert2';

interface Permiso {
    id: number;
    name: string;
    description?: string; // Opcional: para mostrar descripción del permiso
}

interface Rol {
    id: number;
    name: string;
    permisos?: Permiso[]; // Permisos actuales del rol
}

interface Props {
    isOpen: boolean;
    Rol?: Rol | null;
    Permisos: Permiso[];
}

interface Emits {
    (e: 'close'): void;
    (e: 'success'): void; // Emitir cuando se guarde exitosamente
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const roles = ref('');
const permisosSeleccionados = ref<number[]>([]);
const isLoading = ref(false);
const selectAll = ref(false);

// Cargar datos existentes cuando se abre el modal
watch(
    () => props.Rol,
    (newRol) => {
        if (newRol) {
            roles.value = newRol.name || '';
            // Cargar permisos existentes del rol
            if (newRol.permisos && Array.isArray(newRol.permisos)) {
                permisosSeleccionados.value = newRol.permisos.map((p) => p.id);
            }
        } else {
            roles.value = '';
            permisosSeleccionados.value = [];
        }
    },
    { immediate: true },
);

// Computed para verificar si todos los permisos están seleccionados
// const allPermissionsSelected = computed(() => {
//    return (
//        props.Permisos.length > 0 &&
//        permisosSeleccionados.value.length === props.Permisos.length
//    );
// });

// // Manejar selección individual de permiso
// const togglePermiso = (permisoId: number) => {
//     const index = permisosSeleccionados.value.indexOf(permisoId);
//     if (index === -1) {
//         permisosSeleccionados.value.push(permisoId);
//     } else {
//         permisosSeleccionados.value.splice(index, 1);
//     }
//     updateSelectAllState();
// };

// // Manejar seleccionar/deseleccionar todos
// const toggleAllPermissions = () => {
//     if (selectAll.value) {
//         permisosSeleccionados.value = props.Permisos.map((p) => p.id);
//     } else {
//         permisosSeleccionados.value = [];
//     }
// };

// // Actualizar estado de "Seleccionar todos"
// const updateSelectAllState = () => {
//     selectAll.value =
//         permisosSeleccionados.value.length === props.Permisos.length;
// };

// // Agrupar permisos por categoría (opcional)
// const permisosAgrupados = computed(() => {
//     const grupos: { [key: string]: Permiso[] } = {};

//     props.Permisos.forEach((permiso) => {
//         // Asumiendo que los permisos tienen un formato como "usuarios.crear" o "roles.editar"
//         const partes = permiso.name.split('.');
//         const grupo = partes[0] || 'otros';

//         if (!grupos[grupo]) {
//             grupos[grupo] = [];
//         }
//         grupos[grupo].push(permiso);
//     });

//     return grupos;
// });

const handleSubmit = async () => {
    if (!roles.value.trim()) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'La descripción del rol es requerida',
        });
        return;
    }

    // if (permisosSeleccionados.value.length === 0) {
    //     Swal.fire({
    //         icon: 'warning',
    //         title: 'Atención',
    //         text: 'Debe seleccionar al menos un permiso',
    //     });
    //     return;
    // }

    isLoading.value = true;

    const isEditing = props.Rol && props.Rol.id && props.Rol.id > 0;
    const method = isEditing ? 'put' : 'post';
    const endpoint = isEditing ? `/roles/${props.Rol!.id}` : `/roles`;

    router[method](
        endpoint,
        {
            name: roles.value,
            // permisos: permisosSeleccionados.value,
        },
        {
            onSuccess: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: isEditing
                        ? 'Rol actualizado correctamente'
                        : 'Rol creado correctamente',
                    confirmButtonColor: '#7F2841',
                }).then(() => {
                    emit('success');
                    closeModal();
                });
            },
            onError: (errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text:
                        Object.values(errors).flat().join('\n') ||
                        'No se pudo actualizar el rol',
                });
            },
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
};

const closeModal = () => {
    roles.value = '';
    // permisosSeleccionados.value = [];
    selectAll.value = false;
    emit('close');
};
</script>

<template>
    <!-- Main modal -->
    <div
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div class="w-full max-w-2xl rounded-lg bg-white p-6 shadow-xl">
            <!-- Modal header -->
            <div class="flex items-center justify-between border-b pb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ props.Rol ? 'Editar rol' : 'Crear rol' }}
                </h3>
                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    @click="closeModal"
                >
                    <span class="sr-only">Cerrar modal</span>
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </Button>
            </div>

            <!-- Modal body -->
            <form @submit.prevent="handleSubmit" class="mt-4">
                <!-- Nombre del rol -->
                <div class="mb-6">
                    <Label
                        for="rol"
                        required
                        class="mb-2 block text-sm font-medium"
                    >
                        Descripción del rol
                    </Label>
                    <Input
                        id="rol"
                        v-model="roles"
                        type="text"
                        placeholder="Ej: Administrador, Editor, Usuario..."
                        class="w-full"
                    />
                </div>

                <!-- Sección de permisos -->
                <div class="mb-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Permisos:
                        </h3>
                        <!-- Seleccionar todos -->
                        <!-- <label
                            class="flex cursor-pointer items-center space-x-2"
                        >
                            <Checkbox
                                v-model="selectAll"
                                @update:modelValue="toggleAllPermissions"
                            />
                            <span class="text-sm text-gray-600"
                                >Seleccionar todos</span
                            >
                        </label> -->
                    </div>

                    <!-- Grid de permisos agrupados -->
                    <!-- <div class="space-y-4">
                        <div
                            v-for="(permisos, grupo) in permisosAgrupados"
                            :key="grupo"
                            class="rounded-lg border border-gray-200 p-4"
                        >
                            <h4
                                class="mb-3 text-sm font-semibold text-gray-600 uppercase"
                            >
                                {{ grupo }}
                            </h4>
                            <div class="grid grid-cols-2 gap-3">
                                <label
                                    v-for="permiso in permisos"
                                    :key="permiso.id"
                                    class="flex cursor-pointer items-center space-x-3 rounded-md p-2 hover:bg-gray-50"
                                >
                                    <Checkbox
                                        :model-value="
                                            permisosSeleccionados.includes(
                                                permiso.id,
                                            )
                                        "
                                        @update:model-value="
                                            () => togglePermiso(permiso.id)
                                        "
                                        :id="`permiso-${permiso.id}`"
                                    />
                                    <span class="text-sm text-gray-700">
                                        {{ permiso.name }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- Botones -->
                <div class="flex gap-3 border-t pt-4">
                    <Button
                        type="submit"
                        :disabled="isLoading"
                        class="min-w-[100px]"
                    >
                        <Spinner v-if="isLoading" class="mr-2 h-4 w-4" />
                        {{ isLoading ? 'Guardando...' : 'Guardar' }}
                    </Button>
                    <Button type="button" variant="outline" @click="closeModal">
                        Cancelar
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>
