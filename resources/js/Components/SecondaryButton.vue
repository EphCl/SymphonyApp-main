<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex bg-symph-500 items-center px-4 py-2 border border-symph-400 rounded-md font-semibold text-xs text-gray-400 uppercase tracking-widest shadow-sm hover:bg-symph-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
