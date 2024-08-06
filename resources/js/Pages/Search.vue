<script setup>

import SymphonyLayout from "@/Layouts/SymphonyLayout.vue";

import {ref, watch} from "vue";
import {Link, router, useForm} from "@inertiajs/vue3";
import {Icon} from "@iconify/vue";
import Tooltip from "@/Components/Symphony/Tooltip.vue";
import UserInfo from "@/Components/Symphony/Post/UserInfo.vue";

defineProps({
    searchResults: Object,
    trendingUsers: Array,
    follower: Number,
    following: Number,
});

const search = ref("");
const isLoading = ref(false); // Loading state

const formFollow = useForm({
    following_id: null,
});

const toggleFollowing = async (trendingUser) => {
    formFollow.following_id = trendingUser.id;
    formFollow.post(route('user.follow'), {
        preserveScroll: true,
        onSuccess: () => {
        }
    })
};

const toggleUnFollow = async (trendingUser) => {
    formFollow.following_id = trendingUser.id;
    formFollow.delete(route('user.unfollow', {user: trendingUser.id}), {
        preserveScroll: true,
        onSuccess: () => {
        }
    })
};


watch(search, async (value) => {
    isLoading.value = true; // Set loading state to true when fetching starts
    try {
        await router.get(route('search.index'), {
            search: search.value,
        }, {
            preserveState: true,
        });
    } finally {
        isLoading.value = false; // Set loading state to false when fetching ends
    }
});

</script>

<template>
    <SymphonyLayout>
        <template #trendingUsers>
            <div v-for="trendingUser in trendingUsers" :key="trendingUser.id"
                 class="flex w-full flex-row mb-4 items-center gap-4 justify-between">
                <div class="flex flex-row items-center gap-4 w-3/4">
                    <img :src="trendingUser.profile_photo_url" class="w-12 h-12 rounded">
                    <div class="flex-col flex">
                        <Tooltip>
                            <template #button>
                                <UserInfo :name="trendingUser.name" :username="trendingUser.username" :user-id="trendingUser.id"
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
        <template #postForm>
            <input id="search" v-model="search"
                   class="bg-symph-800 rounded-full focus:ring-secondary text-gray-500 py-3 px-6 shadow border border-symph-500 focus:border-0 w-full"
                   placeholder="Rechercher un utilisateur" type="search">
        </template>
        <div class="flex flex-col w-full">
            <div class="flex flex-col items-center">
                <div v-if="searchResults !== null"
                     class=" shadow w-full rounded-xl max-h-[70vh] h-max overflow-y-scroll">
                    <div v-for="search in searchResults" class="hover:bg-symph-600 py-3 px-8">
                        <Link :href="route('profileUser.show', {id: search.id})">
                            <div class="flex flex-row gap-4 items-center">
                                <img :src="search.profile_photo_url" class="aspect-square rounded h-10">
                                <div class="flex flex-col">
                                    <h1 class="text-gray-600 truncate text-nowrap">{{ search.name }}</h1>
                                    <p class="text-gray-500 text-sm">@{{ search.username }}</p>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
                <div v-else class="flex flex-col items-center py-20">
                    <Icon class="w-48 h-48 text-gray-500" icon="line-md:alert-circle-twotone-loop"/>
                    <h1 class="text-gray-600 text-3xl font-bold truncate text-nowrap">Aucun résultat</h1>
                </div>
            </div>
        </div>
    </SymphonyLayout>
</template>

<style scoped>
#search::-webkit-search-cancel-button {
    -webkit-appearance: none;
    height: 1em;
    width: 1em;
    background-image: url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="white"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>');
    background-size: contain;
    cursor: pointer;
}
</style>
