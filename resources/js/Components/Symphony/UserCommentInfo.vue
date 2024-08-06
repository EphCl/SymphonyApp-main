<script setup>
const props = defineProps({
    name: String,
    username: String,
    profile_src: String,
    content: String,
    created_at: String,
});

const formatDateDifference = (createdAt) => {
    const createdDate = new Date(createdAt);
    const currentDate = new Date();

    const timeDifference = currentDate.getTime() - createdDate.getTime();
    const secondsDifference = Math.floor(timeDifference / 1000);
    const minutesDifference = Math.floor(secondsDifference / 60);
    const hoursDifference = Math.floor(minutesDifference / 60);
    const daysDifference = Math.floor(hoursDifference / 24);

    if (daysDifference >= 7) {
        return formatDateString(createdDate);
    } else if (daysDifference >= 1) {
        return `${daysDifference} d`;
    } else if (hoursDifference > 0) {
        return `${hoursDifference} h`;
    } else if (minutesDifference > 0) {
        return `${minutesDifference} m`;
    } else {
        return `${secondsDifference} s`;
    }
};

const formatDateString = (date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1; // Month is zero-based
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
};

</script>

<template>
    <div class="flex flex-row items-start gap-4 relative z-0">
        <div class="flex-none">
            <img :src="props.profile_src" class="min-w-12 z-50 h-12 rounded">
            <div class="bg-symph-400 absolute inset-y-0 left-6 h-full top-6 w-0.5 -z-50"></div>
        </div>
        <div class="flex-col flex-1 flex w-px gap-2 pb-3">
            <div class="flex flex-row gap-4 items-center">
                <div class="flex flex-col gap-1">
                    <h1 class="text-gray-400 truncate text-nowrap">{{ props.name }}</h1>
                    <span class="text-gray-500 text-sm">@{{ props.username }}</span>
                </div>
                <div class="text-symph-400 text-sm flex flex-row gap-2">
                    <span>⸱</span>
                    <span>{{ formatDateDifference(created_at) }}</span>
                </div>
            </div>
            <p class="text-symph-100 break-words">{{ props.content }}</p>
            <div class="text-symph-300 italic text-sm">En réponse à <span
                class="text-secondary">@{{ props.username }}</span></div>
        </div>
    </div>
</template>

<style scoped>

</style>
