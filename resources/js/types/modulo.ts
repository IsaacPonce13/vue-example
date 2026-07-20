export type EstadoModulo = 'borrador' | 'programada' | 'publicado' | 'archivado';

export interface TipoModulo {
    id: number;
    nombre: string;
}

export interface CategoriaModulo {
    id: number;
    nombre: string;
}

export interface Modulo {
    id: number;
    nombre: string;
    descripcion: string;
    contenido: string | null;
    estado: EstadoModulo;
    detalle_type: string;
    detalle_id: number;
    id_categoria: number;
    fecha_alta: string;
    fecha_baja: string | null;
    fecha_pub_programada: string | null;
    tipo_modulo?: TipoModulo | null;
    categoria?: CategoriaModulo | null;
}

// Forma por defecto que devuelve LengthAwarePaginator::toArray() en Laravel.
// Es la que normalmente se pasa tal cual como prop de Inertia.
export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface Paginator<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: PaginationLink[];
}