<script setup>
import {Icon} from '@iconify/vue';
import {ref} from "vue";

const searchInput = ref('');

</script>

<template>
    <div class="relative">
        <div class="relative">
            <Icon class="h-full w-5 ml-1 absolute inset-y-0 left-0 text-secondary z-50"
                  icon="lets-icons:search-alt-fill"/>
            <input v-model="searchInput" class="rounded-full h-8 text-gray-500 z-0 pl-7 text-sm" placeholder="Enter text..."
                   type="search">
        </div>
        <!-- dropdown -->
        <div class="absolute bg-white shadow w-full mt-1 rounded-md z-50 p-2">
            <div v-for="i in 4">hello</div>
        </div>
    </div>
</template>

<style scoped>

</style>
