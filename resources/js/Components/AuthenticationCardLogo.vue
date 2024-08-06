<script setup>
import { Link } from '@inertiajs/vue3';
import Logo from '/public/Logo.png'
</script>

<template>
    <Link :href="'/'">
        <img :src="Logo" alt="Logo" class="w-24" />
    </Link>
</template>
