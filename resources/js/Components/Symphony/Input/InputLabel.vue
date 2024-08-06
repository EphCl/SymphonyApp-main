<script setup>

const props = defineProps({
    value: String,
})

const model = defineModel()

</script>

<template>
    <div class="flex flex-col gap-0.5">
        <label class="text-symph-400" for="input">{{ value }}</label>
        <input v-model="model" :placeholder="value" class="rounded-md text-gray-400 bg-symph-800 border-symph-400"
               type="text">
    </div>
</template>

<style scoped>

</style>
