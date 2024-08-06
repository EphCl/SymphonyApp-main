<script setup>
import {computed} from "vue";

const props = defineProps({
    notifications: Number,
})

const manageNumberNotification = computed(() => {
    if (props.notifications > 99) {
        return '99+'
    }else {
        return props.notifications
    }
})

const notificationClass = computed(() => {
    if (props.notifications < 10) {
        return 'px-1.5 aspect-square -right-0.5 -top-2'
    }else {
        if (props.notifications > 99) {
            return 'p-0.5 px-1 -right-3 -top-2'
        }
        return 'p-0.5 px-1 -right-1.5 -top-2'
    }
})

</script>

<template>
    <div
        :class="[notificationClass]"
        class="absolute text-xs w-max min-w-2 flex items-center shadow-secondary shadow-xl bg-secondary rounded-full">
        {{ manageNumberNotification }}
    </div>
</template>

<style scoped>
</style>
