<script setup xmlns="http://www.w3.org/1999/html">

import SymphonyLayout from "@/Layouts/SymphonyLayout.vue";
import {Link, useForm} from "@inertiajs/vue3";
import {Icon} from "@iconify/vue";
import Post from "@/Components/Symphony/Post/Post.vue";
import {ref} from "vue";
import MainModal from "@/Components/Symphony/Modal/MainModal.vue";
import {useClipboard} from "@vueuse/core";
import ShareButton from "@/Components/Symphony/Button/ShareButton.vue";
import CounterMessage from "@/Components/Symphony/CounterMessage.vue";
import UserInfo from "@/Components/Symphony/Post/UserInfo.vue";
import UserCommentInfo from "@/Components/Symphony/UserCommentInfo.vue";
import Tooltip from "@/Components/Symphony/Tooltip.vue";

defineProps({
    posts: Object,
    user: Object,
    nbPosts: Number,
    likedPosts: Object,
    followers: Object,
    followings: Object,
    trendingUsers: Array,
});

const source = ref('')
const {text, copy, copied, isSupported} = useClipboard({source})

const formComment = useForm({
    content: "",
    post_id: null,
});

const formFollow = useForm({
    following_id: null,
});
const submitComment = (postId) => {
    formComment.post_id = postId;
    formComment.post(route('comments.store'), {
        preserveScroll: true,
        onSuccess: () => {
            formComment.reset('content');
        }
    });
};

const dateFormater = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const showFilter = ref('post');

const ManageShowFilter = (filter) => {
    showFilter.value = filter;
};


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
            <div>
                <div
                    class="w-full bg-symph-700 flex gap-8 border-b pb-8 border-symph-500 sm:flex-row flex-col rounded-t-2xl border-x border-t px-8 pt-8">
                    <img alt="user profile image" :src="user.profile_photo_url"
                         class="shadow-symph-500 aspect-square self-center sm:min-w-48 min-w-20 max-w-48 h-max rounded">
                    <div class="justify-between w-full flex flex-col text-gray-500 mr-8">
                        <div class="flex flex-col">
                            <div class="flex flex-row gap-5 items-center justify-between">
                                <div class="">
                                    <p class="font-bold text-lg">{{ user.name }}</p>
                                    <p class="text-sm">@{{ user.username }}</p>
                                </div>
                                <div v-if="user.id !== $page.props.auth.user.id">
                                    <form v-if="user.isFollowed" @submit.prevent="toggleUnFollow(user)">
                                        <button class="bg-red-900/70 hover:bg-red-900/40 text-symph-100 border border-red-500 rounded-lg p-2"
                                                type="submit">
                                            <Icon class="text-2xl" icon="line-md:person-off-twotone"></Icon>
                                        </button>
                                    </form>
                                    <form v-else @submit.prevent="toggleFollowing(user)">
                                        <button class="bg-secondary-900/70 hover:bg-secondary-900/40 text-symph-100 border border-secondary rounded-lg p-2"
                                                type="submit">
                                            <Icon class="text-2xl" icon="line-md:person-add-twotone"></Icon>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="pt-6 break-all ">
                                <div class="text-sm">{{ user.description }}</div>
                            </div>
                        </div>
                        <div class="flex sm:flex-row gap-2 flex-col sm:gap-10 gap-2 items-center-5 pt-6">
                            <div class="flex flex-row items-center gap-2">
                                <Icon class="w-6 h-6" icon="material-symbols-light:post-add"/>
                                <p class="text-sm font-light text-gray-700">{{ nbPosts }} Posts</p>
                            </div>
                            <div class="flex flex-row gap-2 items-center">
                                <Icon class="min-w-6 h-6" icon="iconoir:calendar"/>
                                <p class="text-sm font-light text-gray-700">A rejoint <span
                                    class="font-bold text-secondary">Symphony</span> le {{
                                        dateFormater(user.created_at)
                                    }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex text-symph-400 bg-symph-700 flex-row justify-around items-center rounded-b-2xl border-symph-500 border-x border-b">
                    <button :class="showFilter === 'post' ? 'text-secondary' : ''" class="hover:bg-gray-900 rounded-bl-2xl font-black border-r border-gray-900 text-center basis-1/2 h-full p-5"
                            @click="ManageShowFilter('post')">
                        <div class="flex flex-row gap-2 items-center justify-center">
                            <Icon class="w-6 h-6" icon="material-symbols-light:post-outline-rounded"/>
                            <h1 class="text-md hidden sm:block font-bold">Posts</h1>
                        </div>
                    </button>
                    <button :class="showFilter === 'like' ? 'text-secondary' : ''" class="hover:bg-gray-900 font-black border-r border-gray-900 text-center basis-1/2 h-full p-5"
                            @click="ManageShowFilter('like')">
                        <div class="flex flex-row gap-2 items-center justify-center">
                            <Icon class="w-6 h-6" icon="icon-park-twotone:like"/>
                            <h1 class="text-md hidden sm:block font-bold">J'aime</h1>
                        </div>
                    </button>
                    <button :class="showFilter === 'followers' ? 'text-secondary' : ''"
                            class="hover:bg-gray-900 font-black border-r border-gray-900 text-center basis-1/2 h-full p-5"
                            @click="ManageShowFilter('followers')">
                        <div class="flex flex-row gap-2 items-center justify-center">
                            <Icon class="w-6 h-6" icon="solar:user-circle-bold-duotone"/>
                            <h1 class="text-md hidden sm:block font-bold">Followers</h1>
                        </div>
                    </button>
                    <button :class="showFilter === 'followings' ? 'text-secondary' : ''"
                            class="hover:bg-gray-900 rounded-br-2xl font-black text-center basis-1/2 h-full p-5"
                            @click="ManageShowFilter('followings')">
                        <div class="flex flex-row gap-2 items-center justify-center">
                            <Icon class="w-6 h-6" icon="solar:user-circle-bold-duotone"/>
                            <h1 class="text-md hidden sm:block font-bold">Followings</h1>
                        </div>
                    </button>
                </div>
            </div>
        </template>
        <div v-if="showFilter === 'post'">
            <div v-for="(post, index) in posts" v-if="nbPosts !== 0" :key="post.id">
                <Post
                    :is-last="index === posts.length - 1"
                    :connectLine="false"
                    :createdAt="post.created_at"
                    :post="post"
                    :src="post.user.profile_photo_url"
                    :user-id="post.user.id">
                    <template #likeButton>
                        <Link :href="route('posts.show', {id: post.id})">
                            <div class="flex flex-row gap-2 items-center text-gray-300 hover:text-secondary">
                                <Icon class="w-5 h-5" icon="icon-park-twotone:more-three"/>
                                <h1 class="text-md font-bold w-max">voir plus</h1>
                            </div>
                        </Link>
                        <div class="flex flex-row gap-2 items-center">
                            <Link :href="post.isLiked ? route('posts.unlike', { post: post }) : route('posts.like', { post: post })"
                                  method="post">
                                <Icon :class="[ post.isLiked ? 'text-secondary-500' : 'text-gray-300']"
                                      class="w-5 h-5 transition hover:scale-110 hover:rotate-6 ease-in-out"
                                      icon="uil:heart"/>
                            </Link>
                            <h1 class="text-md text-symph-200 font-bold">{{ post.nbLikes }}</h1>
                        </div>
                        <div class="flex flex-row gap-2 items-center">
                            <MainModal @submit="submitComment(post.id)">
                                <template #button>
                                    <Icon class="w-5 h-5 transition hover:scale-110 ease-in-out text-gray-300"
                                          icon="uil:comment"/>
                                </template>
                                <template #modalTitle>
                                    Ajouter un commentaire
                                </template>
                                <template #content>
                                    <div class="flex flex-col gap-2">
                                        <UserCommentInfo :content="post.content" :created_at="post.created_at"
                                                         :name="post.user.name" :profile_src="post.user.profile_photo_url"
                                                         :username="post.user.username"/>
                                    </div>
                                    <div class="flex flex-row items-start gap-4 mt-8">
                                        <img alt="user profile image" :src="$page.props.auth.user.profile_photo_url" class="w-12 h-12 rounded">
                                        <div class="w-full">
                                            <textarea v-model="formComment.content" class="w-full text-symph-200 h-48 rounded-lg bg-symph-800 border-symph-500 resize-none" maxlength="255"
                                                      placeholder="Ecrit ton commentaire"
                                                      required></textarea>
                                            <CounterMessage :max-characters="255"
                                                            :message="formComment.content" class="text-symph-100 w-full text-end"/>
                                        </div>
                                    </div>
                                    <button
                                        class="bg-secondary/20 hover:bg-secondary/40 border border-secondary text-white rounded-md px-4 py-2 mt-3">
                                        Envoyer
                                    </button>
                                </template>
                            </MainModal>
                            <h1 class="text-md text-symph-200 font-bold">{{ post.nbComments }}</h1>
                        </div>
                        <!-- Share button -->
                        <div class="flex flex-row gap-2 items-center">
                            <ShareButton :copy-text="route('posts.show', {id: post.id})"></ShareButton>
                        </div>
                    </template>
                </Post>
            </div>
            <div v-else>
                <div class="flex flex-col text-symph-300 items-center justify-center py-20">
                    <Icon class="w-48 h-48" icon="line-md:cancel-twotone"/>
                    <h1 class="text-3xl text-center font-bold">Aucun post pour le moment</h1>
                </div>
            </div>
        </div>
        <div v-else-if="showFilter === 'like'">
            <div v-for="(post, index) in likedPosts" v-if="likedPosts.length !== 0 && likedPosts" :key="post.id">
                <Post
                    :is-last="index === likedPosts.length - 1"
                    :connectLine="false"
                    :createdAt="post.created_at"
                    :post="post"
                    :src="post.user.profile_photo_url"
                    :user-id="post.user.id">
                    <template #likeButton>
                        <Link :href="route('posts.show', {id: post.id})">
                            <div class="flex flex-row gap-2 items-center text-gray-300 hover:text-secondary">
                                <Icon class="w-5 h-5" icon="icon-park-twotone:more-three"/>
                                <h1 class="text-md font-bold w-max">voir plus</h1>
                            </div>
                        </Link>
                        <div class="flex flex-row gap-2 items-center">
                            <Link :href="post.isLiked ? route('posts.unlike', { post: post }) : route('posts.like', { post: post })"
                                  method="post">
                                <Icon :class="[ post.isLiked ? 'text-secondary-500' : 'text-gray-300']"
                                      class="w-5 h-5 transition hover:scale-110 hover:rotate-6 ease-in-out"
                                      icon="uil:heart"/>
                            </Link>
                            <h1 class="text-md text-symph-200 font-bold">{{ post.nbLikes }}</h1>
                        </div>
                        <div class="flex flex-row gap-2 items-center">
                            <MainModal @submit="submitComment(post.id)">
                                <template #button>
                                    <Icon class="w-5 h-5 transition hover:scale-110 ease-in-out text-gray-300"
                                          icon="uil:comment"/>
                                </template>
                                <template #modalTitle>
                                    Ajouter un commentaire
                                </template>
                                <template #content>
                                    <div class="flex flex-col gap-2">
                                        <UserCommentInfo :content="post.content" :created_at="post.created_at"
                                                         :name="post.user.name" :profile_src="post.user.profile_photo_url"
                                                         :username="post.user.username"/>
                                    </div>
                                    <div class="flex flex-row items-start gap-4 mt-8">
                                        <img alt="user profile image" :src="$page.props.auth.user.profile_photo_url" class="w-12 h-12 rounded">
                                        <div class="w-full">
                                            <textarea v-model="formComment.content" class="w-full text-symph-200 h-48 rounded-lg bg-symph-800 border-symph-500 resize-none" maxlength="255"
                                                      placeholder="Ecrit ton commentaire"
                                                      required></textarea>
                                            <CounterMessage :max-characters="255"
                                                            :message="formComment.content" class="text-symph-100 w-full text-end"/>
                                        </div>
                                    </div>
                                    <button
                                        class="bg-secondary/20 hover:bg-secondary/40 border border-secondary text-white rounded-md px-4 py-2 mt-3">
                                        Envoyer
                                    </button>
                                </template>
                            </MainModal>
                            <h1 class="text-md text-symph-200 font-bold">{{ post.nbComments }}</h1>
                        </div>
                        <!-- Share button -->
                        <div class="flex flex-row gap-2 items-center">
                            <ShareButton :copy-text="route('posts.show', {id: post.id})"></ShareButton>
                        </div>
                    </template>
                </Post>
            </div>
            <div v-else>
                <div class="flex flex-col text-symph-300 items-center justify-center py-20">
                    <Icon class="w-48 h-48" icon="line-md:person-off-twotone-loop"/>
                    <h1 class="text-3xl text-center font-bold">Aucun post liké pour le moment</h1>
                </div>
            </div>
        </div>
        <div v-else-if="showFilter === 'followers'" class="flex-col flex gap-2">
            <div v-if="followers.length !== 0" class="w-full">
                <div v-for="user in followers" class="hover:bg-symph-600 py-3 px-8">
                    <Link :href="route('profileUser.show', {id: user.id})">
                        <div class="flex flex-row gap-4 items-center">
                            <img alt="user profile image" :src="user.profile_photo_url" class="aspect-square rounded h-10">
                            <div class="flex flex-col">
                                <h1 class="text-gray-600 truncate text-nowrap">{{ user.name }}</h1>
                                <p class="text-gray-500 text-sm">@{{ user.username }}</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
            <div v-else class="flex flex-col items-center py-20">
                <Icon class="w-48 h-48 text-gray-500" icon="line-md:alert-circle-twotone-loop"/>
                <h1 class="text-gray-600 text-3xl text-center font-bold truncate text-nowrap">Aucun résultat</h1>
            </div>
        </div>
        <div v-else-if="showFilter === 'followings'" class="flex-col flex gap-2">
            <div v-if="followings.length !== 0" class="w-full">
                <div v-for="user in followings" class="hover:bg-symph-600 py-3 px-8">
                    <Link :href="route('profileUser.show', {id: user.id})">
                        <div class="flex flex-row gap-4 items-center">
                            <img alt="user profile image" :src="user.profile_photo_url" class="aspect-square rounded h-10">
                            <div class="flex flex-col">
                                <h1 class="text-gray-600 truncate text-nowrap">{{ user.name }}</h1>
                                <p class="text-gray-500 text-sm">@{{ user.username }}</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
            <div v-else class="flex flex-col items-center py-20">
                <Icon class="w-48 h-48 text-gray-500" icon="line-md:alert-circle-twotone-loop"/>
                <h1 class="text-gray-600 text-3xl text-center font-bold truncate text-nowrap">Aucun résultat</h1>
            </div>
        </div>
    </SymphonyLayout>

</template>

<style scoped>

</style>
