<script setup>

import {Link} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    name: String,
    username: String,
    userId: {
        type: Number,
        required: false
    }
})

const linkToProfile = computed(() => {
    return props.userId ? route('profileUser.show', {id: props.userId}) : '';
})

</script>

<template>
    <div class="flex flex-row gap-1 flex-wrap">
        <Link :href="linkToProfile">
            <p class="text-gray-100 font-bold text-nowrap hover:underline">{{ name }}</p>
        </Link>
        <Link :href="linkToProfile">
            <p class="text-symph-400">@{{ username }}</p>
        </Link>
    </div>
</template>

<style scoped>

</style>
