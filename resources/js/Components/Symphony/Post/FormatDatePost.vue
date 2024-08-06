<script setup>

import {computed} from "vue";

const props = defineProps({
    createdAt: String,
});

const formatDateDiffrence = computed(() => {
    const createdDate = new Date(props.createdAt);
    const currentDate = new Date();

    const timeDifference = currentDate.getTime() - createdDate.getTime();
    const secondsDifference = Math.floor(timeDifference / 1000);
    const minutesDifference = Math.floor(secondsDifference / 60);
    const hoursDifference = Math.floor(minutesDifference / 60);
    const daysDifference = Math.floor(hoursDifference / 24);

    if (daysDifference >= 7) {
        return formatDateString(createdDate);
    } else if (daysDifference >= 1) {
        return `${daysDifference} j`;
    } else if (hoursDifference > 0) {
        return `${hoursDifference} h`;
    } else if (minutesDifference > 0) {
        return `${minutesDifference} m`;
    } else {
        return `${secondsDifference} s`;
    }
});

const formatDateString = (date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1; // Month is zero-based
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
};
</script>

<template>
    <div class="text-symph-400 flex flex-row gap-2">
        <span>⸱</span>
        <span class="text-nowrap">{{ formatDateDiffrence }}</span>
    </div>
</template>

<style scoped>

</style>
