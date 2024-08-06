<script setup>

import {ref} from "vue";

const showTooltip = ref(false)

const open = () => {
    showTooltip.value = true
}
const close = () => {
    showTooltip.value = false
}

</script>

<template>
    <div class="relative">
        <div @mouseenter="open" @mouseleave="close">
            <slot name="button"></slot>
        </div>
        <transition
            enter-active-class="ease-out duration-200"
            enter-from-class="opacity-0 -translate-x-4"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100 translate-x-0"
            leave-to-class="opacity-0 -translate-x-4"
        >
            <div v-if="showTooltip"
                 class="bg-symph-600 shadow-xl border border-symph-500 rounded-lg px-4 py-2 absolute -bottom-20 -left-4 z-50">
                <slot name="content"></slot>
            </div>
        </transition>
    </div>
</template>

<style scoped>

</style>
