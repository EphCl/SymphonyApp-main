<script setup>

import {Icon} from "@iconify/vue";
import {useClipboard} from "@vueuse/core";
import {ref} from "vue";
import useAlerts from "@/store/useAlerts.js";

const source = ref('')
const {text, copy, copied, isSupported} = useClipboard({source})
const {addAlert, alerts} = useAlerts();

const props = defineProps({
    copyText: String,
});
const copyText = (text) => {
    copy(text);
    //add alert
    addAlert({message: 'Copié dans le presse-papier', type: 'info'});
}
</script>

<template>
    <button class="text-gray-300" @click="copyText(props.copyText)">
        <Icon class="w-5 h-5" icon="solar:share-line-duotone"/>
    </button>
</template>

<style scoped>

</style>
