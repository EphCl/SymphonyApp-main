<script setup>

import {computed} from "vue";

const props = defineProps({
    show: Boolean | String,
    type: String,
})

const alertType = computed(() => {
    if (props.type === 'info') {
        return 'border-blue-800 bg-blue-900';
    } else {
        return 'border-red-800 bg-red-900';
    }
})
</script>

<template>
    <transition
        enter-active-class="transition ease-out duration-400"
        enter-from-class="transform translate-x-full scale-95"
        enter-to-class="transform translate-x-0	 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="transform opacity-100 scale-100"
        leave-to-class="transform opacity-0 scale-95"
        name="fade"
    >
        <div v-if="show"
             :class="[alertType]"
             class="absolute shadow top-20 right-2 flex items-center p-4 mb-4 text-sm text-symph-100 border rounded-lg"
             role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor"
                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <slot></slot>
            </div>
        </div>
    </transition>
</template>

<style scoped>

</style>
