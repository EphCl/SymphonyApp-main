<script setup>
import {defineProps, ref, watch} from "vue";

const props = defineProps({
    message: {
        type: String,
        default: ''
    },
    maxCharacters: Number,
});

const nbrCharacters = ref(0);

watch(() => props.message, () => {
    nbrCharacters.value = props.message.length;
});
</script>

<template>
    <p class="text-sm text-nowrap">{{ nbrCharacters }} / {{ maxCharacters }}</p>
</template>

<style scoped>

</style>
