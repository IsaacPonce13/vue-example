<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import dependenciasRoutes from '@/routes/admin/dependencias';
import { router } from '@inertiajs/vue3';
import { SquarePen, ToggleRight, ToggleLeft } from 'lucide-vue-next';
// import ModalPassword from '@/components/dependencias/modalPassword.vue';
import Swal from 'sweetalert2';
import { DataTable } from 'datatables.net-vue3';

interface dependencias {
    id: number;
    descripcion: string;
    adscripcion: string;
    shortname: string;
    tipo_dependencia: string;
    email: string;
    active?: boolean;
}

interface Props {
    dependencias: dependencias[];
}

const props = defineProps<Props>();
const dependencias = props.dependencias || [];

const selectedDependencia = ref<dependencias | null>(null);

const cambiarEstado = (id: number, active: number) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Quieres ${active === 1 ? 'activar' : 'desactivar'} este usuario?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#7F2841',
        cancelButtonColor: '#4b4f54',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.put(
                `/admin/dependencias/${id}/estado`,
                { active },
                {
                    preserveScroll: true,
                    preserveState: false, // Esto fuerza la recarga de datos
                    onSuccess: () => {
                        Swal.fire(
                            '¡Hecho!',
                            `El usuario ha sido ${active === 1 ? 'activado' : 'desactivado'}.`,
                            'success',
                        );
                    },
                },
            );
        }
    });
};

const columns = [
    { title: 'Id', data: 'id' },
    { title: 'Descripción', data: 'descripcion', className: 'dt-left' },
    { title: 'Adscripción', data: 'adscripcion', className: 'dt-left' },
    { title: 'Shortname', data: 'shortname', className: 'dt-left' },
    {
        title: 'Tipo de dependencia',
        data: 'tipo_dependencia',
        className: 'dt-left',
    },
    { title: 'Email', data: 'email', className: 'dt-left' },
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
    <Head title="Administrador" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="mb-2 flex items-center justify-between gap-4">
            <h1 class="text-brand-gray text-2xl font-bold">Dependencias</h1>
            <Link
                :href="dependenciasRoutes.create().url"
                as="button"
                id="btnNuevo"
                class="ml-auto cursor-pointer rounded-lg bg-primary px-4 py-2 text-white transition-colors duration-300 hover:bg-secondary"
            >
                Agregar dependencia
            </Link>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-xl">
            <DataTable
                :data="dependencias"
                :columns="columns"
                :options="options"
                class="w-full"
            >
                <template #column-6="{ cellData, rowData }">
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

                        <Link
                            :href="`/admin/dependencias/${rowData.id}/editar`"
                            class="text-yellow-600 transition-colors hover:text-yellow-800"
                            title="Editar usuario"
                        >
                            <SquarePen class="h-5 w-5" />
                        </Link>
                    </div>
                </template>
            </DataTable>
        </div>
    </div>
</template>
