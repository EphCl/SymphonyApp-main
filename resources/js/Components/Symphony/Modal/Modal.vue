<template>
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">Add comment</p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg @click="$emit('close')" class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path
                                d="M18 1.46L16.54 0 9 7.54 1.46 0 0 1.46 7.54 9 0 16.54 1.46 18 9 10.46 16.54 18 18 16.54 10.46 9 18 1.46z" />
                        </svg>
                    </div>
                </div>

                <!-- Content de la modal -->
                <slot name="content">
                </slot>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>


<style scoped>
.modal-overlay {
    z-index: 10;
}

.modal-container {
    z-index: 11;
}
</style>
