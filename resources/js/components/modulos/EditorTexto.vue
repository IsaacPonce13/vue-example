<template>
    <div class="main-container">
        <div class="editor-container editor-container_classic-editor">
            <div class="editor-container__editor">
                <ckeditor
                    v-if="editor && config"
                    v-model="content"
                    :editor="editor"
                    :config="config"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';

import {
    ClassicEditor,
    Autosave,
    Essentials,
    GeneralHtmlSupport,
    HtmlComment,
    HtmlEmbed,
    Paragraph,
    ShowBlocks,
    SourceEditing,
    Heading,
    Bold,
    Italic,
    Underline,
    Link,
    List,
    BlockQuote,
} from 'ckeditor5';

import translations from 'ckeditor5/translations/es.js';

import 'ckeditor5/ckeditor5.css';

const props = defineProps({
    modelValue: { type: String, default: '' },
    placeholder: {
        type: String,
        default: 'Escribe o pegá el contenido del módulo…',
    },
});
const emit = defineEmits(['update:modelValue']);

const content = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});

const isLayoutReady = ref(false);
const editor = ClassicEditor;

const config = computed(() => {
    if (!isLayoutReady.value) {
        return null;
    }

    return {
        toolbar: {
            items: [
                'undo',
                'redo',
                '|',
                'heading',
                '|',
                'bold',
                'italic',
                'underline',
                'link',
                'blockQuote',
                'bulletedList',
                'numberedList',
                '|',
                'sourceEditing',
                'showBlocks',
                'htmlEmbed',
            ],
            shouldNotGroupWhenFull: false,
        },
        plugins: [
            Autosave,
            Essentials,
            GeneralHtmlSupport,
            HtmlComment,
            HtmlEmbed,
            Paragraph,
            ShowBlocks,
            SourceEditing,
            Heading,
            Bold,
            Italic,
            Underline,
            Link,
            List,
            BlockQuote,
        ],
        licenseKey: 'GPL',
        htmlSupport: {
            allow: [
                {
                    name: /^.*$/,
                    styles: true,
                    attributes: true,
                    classes: true,
                },
            ],
        },
        placeholder: props.placeholder,
        language: 'es',
        translations: [translations],
    };
});

onMounted(() => {
    isLayoutReady.value = true;
});
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&display=swap');

:root {
    --ck-content-font-family: 'Lato';
}

.main-container {
    font-family: var(--ck-content-font-family);
    width: 100%;
}

.editor-container__editor {
    width: 100%;
}
</style>
