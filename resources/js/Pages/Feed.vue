<template>
    <Head title="Feed"/>
    <SymphonyLayout :isLogin="canLogin">
        <template #trendingUsers>
            <div v-for="trendingUser in trendingUsers" :key="trendingUser.id"
                 class="flex w-full flex-row mb-4 items-center gap-4 justify-between">
                <div class="flex flex-row items-center gap-4 w-3/4">
                    <img :src="trendingUser.profile_photo_url" alt="user profile image" class="w-12 h-12 rounded">
                    <div class="flex-col flex">
                        <Tooltip>
                            <template #button>
                                <UserInfo :name="trendingUser.name" :username="trendingUser.username"
                                          class="overflow-hidden w-32"
                                          :userId="trendingUser.id"
                                />
                            </template>
                            <template #content>
                                <UserInfo :name="trendingUser.name" :username="trendingUser.username"
                                          :userId="trendingUser.id"
                                />
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
            <PostForm></PostForm>
        </template>
        <div v-for="(post, index) in posts" v-if="posts.length > 0" :key="post.id">
            <Post
                :connectLine="false"
                :createdAt="post.created_at"
                :post="post"
                :is-last="index === posts.length - 1"
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
                            <Icon :class="[ post.isLiked ? 'text-secondary-500' : 'text-gray-300']" class="w-5 h-5 transition hover:scale-110 hover:rotate-6 ease-in-out"
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
                                    <img :src="$page.props.auth.user.profile_photo_url" class="w-12 h-12 rounded" alt="user profile image">
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
            <div class="flex flex-col items-center justify-center w-full h-full py-20">
                <Icon class="w-48 h-48 text-gray-500" icon="line-md:alert-circle-twotone-loop"/>
                <h1 class="text-2xl text-symph-200 font-bold">Aucun post trouvé</h1>
            </div>
        </div>
    </SymphonyLayout>
</template>

<script setup>
import {Head, useForm, Link} from '@inertiajs/vue3';
import SymphonyLayout from "@/Layouts/SymphonyLayout.vue";
import {ref} from "vue";
import {Icon} from "@iconify/vue";
import Post from "@/Components/Symphony/Post/Post.vue";
import MainModal from "@/Components/Symphony/Modal/MainModal.vue";
import PostForm from "@/Components/Symphony/Post/PostForm.vue";
import {useClipboard} from "@vueuse/core";
import CounterMessage from "@/Components/Symphony/CounterMessage.vue";
import ShareButton from "@/Components/Symphony/Button/ShareButton.vue";
import UserInfo from "@/Components/Symphony/Post/UserInfo.vue";
import UserCommentInfo from "@/Components/Symphony/UserCommentInfo.vue";
import Tooltip from "@/Components/Symphony/Tooltip.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    posts: Array,
    trendingUsers: Array,
    follower: Number,
    following: Number,
});

const like = ref(false);

const formComment = useForm({
    content: "",
    post_id: null,
});

const formFollow = useForm({
    following_id: null,
});

const source = ref('')
const {text, copy, copied, isSupported} = useClipboard({source})

const submitComment = (postId) => {
    formComment.post_id = postId;
    formComment.post(route('comments.store'), {
        preserveScroll: true,
        onSuccess: () => {
            formComment.reset('content');
        },
        onError: (e) => {
        }
    });
};

// Fonction pour suivre/désabonner avec formulaire
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

</script>


<style>
</style>
