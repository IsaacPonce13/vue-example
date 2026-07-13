<!--
  MapaUbicacion.vue
  Componente para mostrar la ubicación de un participante o negocio.
  Incluye un mapa de Google Maps embebido y un banner con la dirección.
  Acepta tanto objetos con coordenadas como strings simples de dirección.
-->
<template>
    <section class="mapa-ubicacion">
        <div class="main-container">
            <!-- Título de la sección con icono -->
            <h2 class="text-lg font-semibold text-gray-700">
                Ubicación de la dependencia
            </h2>

            <div class="mapa-container">
                <!-- Contenedor del mapa de Google Maps embebido -->
                <div class="mapa-wrapper">
                    <iframe
                        :src="mapaUrl"
                        width="100%"
                        height="400"
                        style="border: 0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="mapa-iframe"
                    ></iframe>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, defineProps, onMounted } from 'vue';
import { MapPin } from 'lucide-vue-next';

// Props del componente: acepta ubicación como objeto o string
const props = defineProps({
    ubicacion: {
        type: [Object, String],
        required: true,
        default: () => ({
            direccion: ubicacion.direccion,
            coordenadas: {
                lat: ubicacion.latitud,
                lng: ubicacion.longitud,
            },
        }),
    },
});

onMounted(() => {
    console.log('Ubicación recibida:', props.ubicacion);
});

// Add validation function
const validarCoordenadas = (ubicacion) => {
    const lat = Number(ubicacion.latitud);
    const lng = Number(ubicacion.longitud);

    console.log('coordenadas validadas:', { lat, lng });
    return {
        isValid: !isNaN(lat) && !isNaN(lng),
        lat,
        lng,
    };
};

// Computed para normalizar los datos de ubicación
// Si recibe un string, lo convierte a objeto con coordenadas por defecto de Colima
// Si recibe un objeto, lo usa tal como está
const ubicacionData = computed(() => {
    if (typeof props.ubicacion === 'string') {
        return {
            direccion: props.ubicacion, // Usa el string directamente como dirección
            coordenadas: { lat: 19.0915, lng: -104.3145 }, // Coordenadas de Colima
        };
    }

    // Si es un objeto, valida y usa sus coordenadas
    const coords = validarCoordenadas(props.ubicacion);
    return {
        direccion: props.ubicacion.direccion,
        coordenadas: coords.isValid
            ? { lat: coords.lat, lng: coords.lng }
            : { lat: 19.0915, lng: -104.3145 }, // Fallback a Colima
    };
});

// Computed que genera la URL del mapa embebido de Google Maps
// Utiliza las coordenadas para centrar el mapa y colocar un marcador
const mapaUrl = computed(() => {
    const { lat, lng } = ubicacionData.value.coordenadas;
    const zoom = 15;
    return `https://maps.google.com/maps?q=${lat},${lng}&z=${zoom}&output=embed`;
});
</script>

<style scoped>
.ubicacion-titulo {
    font-family: 'Londrina Solid', cursive;
    font-size: 2.5rem;
    font-weight: bold;
    color: #2d4a2b;
    margin-bottom: 40px;
    display: flex;
    align-items: center;
    gap: 12px;
    letter-spacing: 0.05em;
}

.ubicacion-icon {
    width: 36px;
    height: 36px;
    color: #38a169;
}

.mapa-container {
    border-radius: 10px;
    overflow: hidden;
}

.mapa-wrapper {
    position: relative;
    width: 100%;
    height: 400px;
    overflow: hidden;
}

.mapa-iframe {
    width: 100%;
    height: 100%;
    border: none;
    border-radius: 10px 10px 0 0;
}

.ubicacion-info {
    padding: 24px 32px;
    background: #2d4a2b;
    font-family: 'Londrina Solid', cursive;
    letter-spacing: 0.05em;
    border-radius: 0 0 10px 10px;
}

.direccion {
    display: flex;
    align-items: center;
    gap: 12px;
}

.direccion-icon {
    width: 24px;
    height: 24px;
    color: #d6bd94;
    flex-shrink: 0;
}

.direccion-texto {
    font-size: 1.1rem;
    font-weight: 600;
    color: #d6bd94;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .ubicacion-titulo {
        font-size: 2rem;
        text-align: center;
        justify-content: center;
    }

    .mapa-wrapper {
        height: 300px;
    }

    .ubicacion-info {
        padding: 20px 24px;
    }

    .direccion {
        justify-content: center;
        text-align: center;
    }

    .direccion-texto {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .mapa-wrapper {
        height: 250px;
    }

    .ubicacion-titulo {
        font-size: 1.75rem;
    }

    .ubicacion-icon {
        width: 28px;
        height: 28px;
    }
}
</style>
