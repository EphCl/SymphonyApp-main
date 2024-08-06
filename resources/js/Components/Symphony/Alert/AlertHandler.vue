<script setup>
import {computed, watch} from "vue";
import {usePage} from '@inertiajs/vue3';
import useAlerts from "../../../store/useAlerts.js";

const alert = computed(() => usePage().props.flash.alert);
const {addAlert, alerts} = useAlerts();

watch(alert, (newVal) => {
    if (newVal) {
        addAlert(newVal);
    }
});
</script>

<template>
    <div class="fixed z-50 top-10 right-2">
        <transition-group
            enter-active-class="transition ease-out duration-400"
            enter-from-class="transform translate-x-full scale-95"
            enter-to-class="transform translate-x-0	 scale-100"
            leave-active-class="transition ease-in duration-800"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
            name="fade"
        >
            <div v-for="(alert, key) in alerts" :key="key"
                 :class="{
                'border-red-800 bg-red-900': alert.type === 'error',
                'border-green-800 bg-green-900': alert.type === 'success',
                'border-blue-800 bg-blue-900': alert.type === 'info',
             }"
                 class="flex flex-col shadow items-start p-4 mb-4 text-sm text-symph-100 border rounded-lg">
                <div class="flex flex-row items-center">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor"
                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span>{{ alert.message }}</span>
                </div>
            </div>
        </transition-group>
    </div>
</template>

<style scoped>

</style>
