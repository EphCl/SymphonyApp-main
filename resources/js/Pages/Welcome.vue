<script setup>
import {Link} from '@inertiajs/vue3';
import Logo from '/public/Logo.png'
</script>

<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-symph-900">
        <div class="max-w-md w-full p-6 bg-symph-700 shadow rounded-lg shadow-md">
            <img :src="Logo" alt="Logo" class="mx-auto mb-8" style="width: 100px;">
            <Link :href="route('login')">
                <p class="text-center w-full border-2 border-secondary-400 rounded-md hover:bg-symph-900 text-secondary-500 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mb-4">
                    Se connecter
                </p>
            </Link>
            <Link :href="route('register')">
                <p class="w-full bg-secondary-500 text-md border border-secondary-400 rounded-md hover:bg-secondary-400 text-white font-bold py-2 px-4 text-center">
                    Créer un compte</p>
            </Link>
        </div>
    </div>
</template>
