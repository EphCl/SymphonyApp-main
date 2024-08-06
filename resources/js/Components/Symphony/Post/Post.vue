<script setup>

import {Link} from "@inertiajs/vue3";
import {computed} from "vue";
import UserInfo from "@/Components/Symphony/Post/UserInfo.vue";
import FormatDatePost from "@/Components/Symphony/Post/FormatDatePost.vue";
import PlayerAudio from "@/Components/Symphony/PlayerAudio.vue";

const props = defineProps({
    line: {
        type: Boolean,
        required: false,
        default: false
    },
    border: {
        type: Boolean,
        required: false,
        default: true
    },
    post: Object,
    connectLine: {
        type: Boolean,
        required: false,
        default: true
    },
    createdAt: String,
    src: String,
    userId: {
        type: Number,
        required: false
    },
    isLast: {
        type: Boolean,
        required: false,
        default: false
    }
});

const borderClass = computed(() => {
    return (props.border && !props.isLast) ? 'border-b border-symph-500' : ''
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
    <div :class="borderClass"
         class="z-0 h-full p-5 flex sm:flex-row flex-col w-full sm:justify-between justify-center gap-4">
        <div class="flex flex-row">
            <Link :href="userId ? route('profileUser.show', {id: userId}): route().current()"
                  class="mr-3 z-0 flex-none relative h-max">
                <img alt="user profile image" :src="src" class="w-max aspect-square h-12 rounded">
            </Link>
            <div class="flex flex-col">
                <div class="flex flex-row items-start gap-2">
                    <UserInfo
                        :name="post.user.name"
                        :userId="post.user.id"
                        :username="post.user.username"
                    />
                    <FormatDatePost :createdAt="createdAt" class=""/>
                </div>
                <p class="text-symph-100">{{ post.content }}</p>
                <div class="flex-row flex items-end text-sm sm:gap-8 gap-4 h-8">
                    <slot name="likeButton"></slot>
                </div>
            </div>
        </div>
        <div v-if="post.song" class="md:pr-20 w-max pr-0">
            <PlayerAudio :song="post.song"></PlayerAudio>
        </div>
    </div>
</template>

<style scoped>

</style>
