<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    connectLine: {
        type: Boolean,
        required: false,
        default: true
    },
    src: String,
    date: String,
    userId: {
        type: Number,
        required: false
    }
});
</script>

<template>
    <div class="relative flex flex-row items-center p-4 shadow pb-4 gap-4">
        <div v-if="connectLine"
             class="absolute -left-5 -top-3 w-5 h-full border-b-2 border-symph-400 rounded-bl-xl border-l-2"></div>
        <!-- Informations sur l'utilisateur -->
        <Link :href="userId ? route('profileUser.show', {id: userId}): route().current()">
            <img :src="props.src" class="w-12 h-12 rounded">
        </Link>
        <div class="flex-col flex">
            <Link :href="userId ? route('profileUser.show', {id: userId}): route().current()">
                <h1 class="text-gray-400 truncate text-nowrap hover:underline">
                    <slot name="name"></slot>
                </h1>
            </Link>
            <Link :href="userId ? route('profileUser.show', {id: userId}): route().current()">
              <span class="text-gray-500 text-sm">
                  <slot name="at"></slot>
              </span>
            </Link>
        </div>
        <div class="text-symph-400 text-sm flex flex-row gap-2">
            <span>⸱</span>
            <span>{{ date }}</span>
        </div>
    </div>
</template>

<style scoped>

</style>
