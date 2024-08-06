<script setup>

import SymphonyLayout from "@/Layouts/SymphonyLayout.vue";
import UserInfo from "@/Components/Symphony/Post/UserInfo.vue";
import {Icon} from "@iconify/vue";
import Tooltip from "@/Components/Symphony/Tooltip.vue";
import {useForm} from "@inertiajs/vue3";

defineProps({
    notifications: Array,
    trendingUsers: Array
})

const formFollow = useForm({
    following_id: null,
});

// Fonction pour suivre/désabonner avec formulaire
const toggleFollowing = (trendingUser) => {
    formFollow.following_id = trendingUser.id;
    formFollow.post(route('user.follow'), {
        preserveScroll: true,
        onSuccess: () => {
        }
    })
};

const toggleUnFollow = (trendingUser) => {
    formFollow.following_id = trendingUser.id;
    formFollow.delete(route('user.unfollow', {user: trendingUser.id}), {
        preserveScroll: true,
        onSuccess: () => {
        }
    })
};

</script>

<template>
    <SymphonyLayout>
        <template #trendingUsers>
            <div v-for="trendingUser in trendingUsers" :key="trendingUser.id"
                 class="flex w-full flex-row mb-4 items-center gap-4 justify-between">
                <div class="flex flex-row items-center gap-4 w-3/4">
                    <img alt="user profile image" :src="trendingUser.profile_photo_url" class="w-12 h-12 rounded">
                    <div class="flex-col flex">
                        <Tooltip>
                            <template #button>
                                <UserInfo :name="trendingUser.name" :username="trendingUser.username"
                                          :user-id="trendingUser.id"
                                          class="overflow-hidden w-32"/>
                            </template>
                            <template #content>
                                <UserInfo :name="trendingUser.name" :username="trendingUser.username" :user-id="trendingUser.id"/>
                            </template>
                        </Tooltip>
                    </div>
                </div>
                <div class="flex flex-row items-center gap-4">
                    <!-- Bouton qui change en fonction de l'état de suivi -->
                    <form
                        @submit.prevent="trendingUser.isFollowed ? toggleUnFollow(trendingUser) : toggleFollowing(trendingUser)">
                        <button class="bg-symph-500 text-white rounded-full p-1 aspect-square">
                            <Icon v-if="trendingUser.isFollowed"
                                  class="w-6 h-6" icon="material-symbols:check-indeterminate-small-rounded"/>
                            <Icon v-else class="w-6 h-6" icon="jam:plus"/>
                        </button>
                    </form>
                </div>
            </div>
        </template>
        <div v-for="(notification, index) in notifications" v-if="notifications.length > 0"
             class="flex flex-col gap-4">
            <div class="flex flex-row gap-2 p-4" :class="index === notifications.length - 1 ? '' : 'border-b border-symph-500'">
                <img :src="notification.data.user.profile_photo_url" alt="img" class="h-12 rounded-lg">
                <div class="">
                    <UserInfo :name="notification.data.user.name" :userId="notification.data.user.id"
                              :username="notification.data.user.username"/>
                    <p v-if="notification.data.post" class="text-symph-100 py-2">{{
                            notification.data.post
                        }}</p>
                    <p class="text-gray-500">{{ notification.data.message }}</p>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="flex flex-col items-center justify-center w-full h-full py-20">
                <Icon class="w-48 h-48 text-gray-500" icon="line-md:alert-circle-twotone-loop"/>
                <h1 class="text-2xl text-symph-200 font-bold">Aucunes Notifications</h1>
            </div>
        </div>
    </SymphonyLayout>
</template>

<style scoped>

</style>
