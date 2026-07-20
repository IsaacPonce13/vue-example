<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';

// Iconos
import { SquarePen, ToggleRight, ToggleLeft } from 'lucide-vue-next';

// Componente del Modal renombrado limpiamente en PascalCase
import RolesModal from '@/components/roles/modalRol.vue';
import Swal from 'sweetalert2';
import { DataTable } from 'datatables.net-vue3';

interface Role {
    id: number;
    name: string;
    active?: number;
    permissions?: Permission[];
    Permission?: Permission[];
}

interface Permission {
    id: number;
    name: string;
}

interface Props {
    isOpen?: boolean;
    roles: Role[];
    permissions?: Permission[];
    Permission?: Permission[];
}

const props = defineProps<Props>();
const selectedRol = ref<Role | null>(null);

const isModalOpen = ref(false);
const availablePermissions = computed(() => {
    if (Array.isArray(props.permissions) && props.permissions.length > 0) {
        return props.permissions;
    }

    return Array.isArray((props as any).Permission)
        ? (props as any).Permission
        : [];
});

const openCreateModal = () => {
    selectedRol.value = null;
    isModalOpen.value = true;
};

const openEditModal = (roleData: Role) => {
    // Obtener el rol completo con sus permisos desde el backend
    fetch(`/admin/roles/${roleData.id}/ver`)
        .then((response) => response.json())
        .then((data) => {
            console.log('Rol obtenido del servidor:', data);
            selectedRol.value = data;
            isModalOpen.value = true;
        })
        .catch((error) => {
            console.error('Error al obtener el rol:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar el rol para edición',
            });
        });
};

const closeModal = () => {
    isModalOpen.value = false;
    selectedRol.value = null;
};

const cambiarEstado = (id: number, active: number) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Quieres ${active === 1 ? 'activar' : 'desactivar'} este rol?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#7F2841',
        cancelButtonColor: '#4b4f54',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.put(
                `/admin/roles/${id}/estado`,
                { active },
                {
                    preserveScroll: true,
                    preserveState: false,
                    onSuccess: () => {
                        Swal.fire(
                            '¡Hecho!',
                            `El rol ha sido ${active === 1 ? 'activado' : 'desactivado'}.`,
                            'success',
                        );
                    },
                },
            );
        }
    });
};

const columns = [
    { title: 'Id', data: 'id', className: 'dt-left' },
    { title: 'Descripción', data: 'name', className: 'dt-left' },
    {
        title: 'Acciones',
        data: null,
        orderable: false,
        className: 'dt-left',
        cellType: 'th',
    },
];

const options = {
    responsive: true,
    dom: '<"flex items-center justify-between mb-4"lf>rt<"flex items-center justify-between mt-4"ip>',
    language: {
        search: 'Buscar:',
        lengthMenu: 'Mostrar _MENU_ registros',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        paginate: {
            first: 'Primero',
            last: 'Último',
            next: 'Siguiente',
            previous: 'Anterior',
        },
    },
};
</script>

<template>
    <Head title="Roles y Permisos" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="mb-2 flex items-center justify-between gap-4">
            <h1 class="text-brand-gray text-2xl font-bold">Roles</h1>
            <button
                @click="openCreateModal"
                type="button"
                id="btnNuevo"
                class="ml-auto cursor-pointer rounded-lg bg-primary px-4 py-2 text-white transition-colors duration-300 hover:bg-secondary"
            >
                Agregar un nuevo rol
            </button>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-xl">
            <DataTable
                :data="props.roles"
                :columns="columns"
                :options="options"
                class="w-full"
            >
                <template #column-2="{ rowData }">
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            class="cursor-pointer transition-colors"
                            title="Cambiar estado"
                            @click.stop="
                                cambiarEstado(
                                    rowData.id,
                                    rowData.active === 1 ? 0 : 1,
                                )
                            "
                        >
                            <ToggleRight
                                v-if="rowData.active === 1"
                                class="h-6 w-6 text-green-600 hover:text-green-700"
                            />
                            <ToggleLeft
                                v-else
                                class="h-6 w-6 text-red-600 hover:text-red-700"
                            />
                        </button>

                        <button
                            @click.prevent="openEditModal(rowData)"
                            type="button"
                            class="cursor-pointer text-yellow-600 transition-colors hover:text-yellow-800"
                            title="Editar rol"
                        >
                            <SquarePen class="h-5 w-5" />
                        </button>
                    </div>
                </template>
            </DataTable>
        </div>

        <RolesModal
            v-if="isModalOpen"
            :isOpen="isModalOpen"
            :rol="selectedRol"
            :permissions="availablePermissions"
            @close="closeModal"
        />
    </div>
</template>
