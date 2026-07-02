<script setup lang="ts">
import { ref, computed, watch, nextTick } from 'vue';
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Checkbox } from '@/components/ui/checkbox';
import { Spinner } from '@/components/ui/spinner';
import Swal from 'sweetalert2';

interface Permission {
    id: number;
    name: string;
}

interface Rol {
    id: number;
    name: string;
    permissions?: Permission[];
}

interface Props {
    isOpen: boolean;
    rol?: Rol | null;
    permissions?: Permission[];
}

interface Emits {
    close: [];
    success: [];
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const nombreRol = ref('');
const permisosSeleccionados = ref<number[]>([]);
const isLoading = ref(false);
const selectAll = ref(false);
const checkboxKey = ref(0); // Para forzar re-renderización

// Actualizar estado de "Seleccionar todos"
const updateSelectAllState = () => {
    const list = props.permissions || [];
    selectAll.value =
        list.length > 0 && permisosSeleccionados.value.length === list.length;
};

// Manejar selección individual de Permission
const togglePermiso = (permisoId: number | string) => {
    const id = Number(permisoId); // <-- Conversión explícita
    const index = permisosSeleccionados.value.indexOf(id);
    if (index === -1) {
        permisosSeleccionados.value.push(id);
    } else {
        permisosSeleccionados.value.splice(index, 1);
    }
    updateSelectAllState();
};

// Manejar seleccionar/deseleccionar todos
const toggleAllPermissions = (checked: boolean) => {
    selectAll.value = checked;
    const list = props.permissions || [];
    if (checked) {
        permisosSeleccionados.value = list.map((p) => p.id);
    } else {
        permisosSeleccionados.value = [];
    }
};

// Vigilante para cuando se abre en modo Edición
watch(
    () => props.rol,
    (newRol) => {
        console.log('Watch triggered - newRol:', newRol);

        if (newRol && newRol.id && newRol.id > 0) {
            nombreRol.value = newRol.name || '';

            // Debug: log los datos disponibles
            console.log('📋 Checking permissions in newRol:');
            console.log('   - newRol.permissions:', newRol.permissions);
            console.log('   - newRol.Permission:', (newRol as any).Permission);

            const rPermisos = Array.isArray(newRol.permissions)
                ? newRol.permissions
                : Array.isArray((newRol as any).Permission)
                  ? (newRol as any).Permission
                  : [];

            console.log('Final permisos array:', rPermisos);

            if (rPermisos.length > 0) {
                const permisoIds = rPermisos.map((p: any) => Number(p.id));
                console.log('Setting permisosSeleccionados to:', permisoIds);
                permisosSeleccionados.value = permisoIds;

                console.log('IDs asignados (rol):', permisoIds);
                console.log(
                    'IDs disponibles (catálogo completo):',
                    (props.permissions || []).map((p) => p.id),
                );
                console.log(
                    '¿Coinciden?',
                    permisoIds.every((id) =>
                        (props.permissions || []).some(
                            (p) => Number(p.id) === id,
                        ),
                    ),
                );
                // Forzar re-renderización de checkboxes
                nextTick(() => {
                    checkboxKey.value++;
                    console.log(
                        '🔄 Checkboxes re-rendered, key is now:',
                        checkboxKey.value,
                    );
                });
            } else {
                console.log('⚠️ No permissions found, clearing array');
                permisosSeleccionados.value = [];
            }
        } else {
            console.log('🔄 Creating new rol, clearing data');
            nombreRol.value = '';
            permisosSeleccionados.value = [];
        }
        updateSelectAllState();
    },
    { immediate: true },
);

// Agrupar permisos por su prefijo (ej: "usuarios.editar" -> "usuarios")
const permisosAgrupados = computed(() => {
    const grupos: { [key: string]: Permission[] } = {};
    const list = props.permissions || [];

    list.forEach((p) => {
        const partes = p.name.split('.');
        const grupo = partes[0] || 'otros';
        if (!grupos[grupo]) {
            grupos[grupo] = [];
        }
        grupos[grupo].push(p);
    });
    return grupos;
});

const handleSubmit = async () => {
    if (!nombreRol.value.trim()) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'La descripción del rol es requerida',
        });
        return;
    }

    isLoading.value = true;
    const isEditing = !!(props.rol && props.rol.id && props.rol.id > 0);
    const method = isEditing ? 'put' : 'post';
    const endpoint = isEditing
        ? `/admin/roles/${props.rol!.id}`
        : `/admin/roles`;

    router[method](
        endpoint,
        {
            name: nombreRol.value,
            permisos: permisosSeleccionados.value,
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
                        'No se pudo procesar la solicitud',
                });
            },
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
};

const closeModal = () => {
    nombreRol.value = '';
    permisosSeleccionados.value = [];
    selectAll.value = false;
    emit('close');
};
</script>

<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div
            class="flex max-h-[90vh] w-full max-w-2xl flex-col rounded-lg bg-white p-6 shadow-xl"
        >
            <div class="flex items-center justify-between border-b pb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ props.rol ? 'Editar rol' : 'Crear rol' }}
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

            <form
                @submit.prevent="handleSubmit"
                class="mt-4 flex-1 overflow-y-auto pr-2"
            >
                <div class="mb-6">
                    <Label for="rol" class="mb-2 block text-sm font-medium">
                        Descripción del rol <span class="text-red-500">*</span>
                    </Label>
                    <Input
                        id="rol"
                        v-model="nombreRol"
                        type="text"
                        placeholder="Ej: Administrador, Editor, Usuario..."
                        class="w-full"
                    />
                </div>

                <div class="mb-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-md font-semibold text-gray-900">
                            Asignar Permisos:
                        </h3>
                        <label
                            class="flex cursor-pointer items-center space-x-2"
                        >
                            <Checkbox
                                :model-value="selectAll"
                                @update:model-value="toggleAllPermissions"
                            />
                            <span class="text-sm text-gray-600"
                                >Seleccionar todos</span
                            >
                        </label>
                    </div>
                    <div class="space-y-4">
                        <div
                            v-for="(listaPermisos, grupo) in permisosAgrupados"
                            :key="grupo"
                            class="rounded-lg border border-gray-200 p-4"
                        >
                            <h4
                                class="mb-3 text-sm font-bold tracking-wider text-gray-700 uppercase"
                            >
                                {{ grupo }}
                            </h4>
                            <div
                                class="grid grid-cols-2 gap-3"
                                :key="`grupo-${grupo}-${checkboxKey}`"
                            >
                                <label
                                    v-for="permiso in listaPermisos"
                                    :key="`permiso-${permiso.id}-${checkboxKey}`"
                                    class="flex cursor-pointer items-center space-x-3 rounded-md p-2 hover:bg-gray-50"
                                >
                                    <!-- Checkboxes de permisos individuales -->
                                    <Checkbox
                                        :model-value="
                                            permisosSeleccionados.includes(
                                                Number(permiso.id),
                                            )
                                        "
                                        @update:model-value="
                                            () => togglePermiso(permiso.id)
                                        "
                                        :id="`permiso-${permiso.id}`"
                                    />
                                    <span
                                        class="text-sm text-gray-700 capitalize"
                                    >
                                        {{ permiso.name.split('.').join(' ') }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sticky bottom-0 flex gap-3 border-t bg-white pt-4">
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
