<script setup>

import {ref} from "vue";

const showModal = ref(false)

const emit = defineEmits(['submit', 'open'])
const openModal = () => {
    emit('open')
    showModal.value = true
}
const closeModal = () => {
    showModal.value = false
}

const handleSubmit = () => {
    emit('submit')
    closeModal()
}

</script>

<template>
    <div>
        <div class="flex items-center justify-center">
            <button type="button" @click="openModal">
                <slot name="button"></slot>
            </button>
        </div>
      <transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
      >
        <div v-if="showModal" class="fixed flex justify-center items-center inset-0 bg-black/50 z-50">
            <div class="bg-symph-900 sm:w-1/2 w-full mx-2 h-max rounded-lg">
                <div class="flex flex-row justify-between px-8 py-6 bg-symph-700 rounded-t-lg text-symph-400 shadow-lg">
                    <div>
                        <h1 class="font-semibold text-lg">
                            <slot name="modalTitle"></slot>
                        </h1>
                    </div>
                    <button @click="closeModal">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                    <div class="py-8">
                        <form @submit.prevent="handleSubmit">
                            <div class="flex flex-col gap-2 px-8">
                                <slot name="content"></slot>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
      </transition>
    </div>
</template>

<style scoped>

</style>
