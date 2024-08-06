<script setup>
import SymphonyLayout from "@/Layouts/SymphonyLayout.vue";
import {Link, useForm} from "@inertiajs/vue3";
import Post from "@/Components/Symphony/Post/Post.vue";
import {Icon} from "@iconify/vue";
import {ref} from "vue";
import MainModal from "@/Components/Symphony/Modal/MainModal.vue";
import {useClipboard} from '@vueuse/core'
import ShareButton from "@/Components/Symphony/Button/ShareButton.vue";
import CounterMessage from "@/Components/Symphony/CounterMessage.vue";
import UserInfo from "@/Components/Symphony/Post/UserInfo.vue";
import UserCommentInfo from "@/Components/Symphony/UserCommentInfo.vue";
import Tooltip from "@/Components/Symphony/Tooltip.vue";

defineProps({
    post: Object,
    trendingUsers: Array,
});

const like = ref(false);

const source = ref('')
const {text, copy, copied, isSupported} = useClipboard({source})


const formComment = useForm({
    content: "",
    post_id: null,
});

const formReply = useForm({
    content: "",
    parent_id: null,
    post_id: null,
});

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


const submitCommentReply = (commentId, postId) => {
    formReply.parent_id = commentId;
    formReply.post_id = postId;
    formReply.post(route('comments.reply'), {
        preserveScroll: true,
        onSuccess: () => {
            formReply.reset('content');
        }
    });
};

const submitComment = (postId) => {
    formComment.post_id = postId;
    formComment.post(route('comments.store'), {
        preserveScroll: true,
        onSuccess: () => {
            formComment.reset('content');
        }
    });
};
</script>

<template>
    <SymphonyLayout>
        <template #trendingUsers>
            <div v-for="trendingUser in trendingUsers" :key="trendingUser.id"
                 class="flex w-full flex-row mb-4 items-center gap-4 justify-between">
                <div class="flex flex-row items-center gap-4 w-3/4">
                    <img :src="trendingUser.profile_photo_url" alt="user profile image" class="w-12 h-12 rounded">
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
        <div class="">
            <Post
                :is-last="post.comments === undefined || post.comments.length === 0"
                :connectLine="false"
                :createdAt="post.created_at"
                :post="post"
                :src="post.user.profile_photo_url"
                :user-id="post.user.id"
                class="bg-symph-700">
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
                                    <img :src="$page.props.auth.user.profile_photo_url" alt="user profile image" class="w-12 h-12 rounded">
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
            <div v-for="(comment, index) in post.comments" :key="comment.id"
                 v-if="post.comments"
                 :class="index === post.comments.length - 1 ? '' : 'border-b border-symph-500'"
                 class="flex flex-col w-full items-center relative">
                <div class="w-full">
                    <Post
                        :border="false"
                        :connectLine="false"
                        :createdAt="comment.created_at"
                        :line="true"
                        :post="comment"
                        :src="comment.user.profile_photo_url"
                        :user-id="comment.user.id">
                        <template #likeButton>
                            <div class="flex flex-row gap-2 items-center">
                                <Link :href="comment.isLiked ? route('comments.unlike', { comment: comment }) : route('comments.like', { comment: comment })"
                                      method="post">
                                    <Icon :class="[ comment.isLiked ? 'text-secondary-500' : 'text-gray-300']"
                                          class="w-5 h-5 transition hover:scale-110 hover:rotate-6 ease-in-out"
                                          icon="uil:heart"/>
                                </Link>
                                <h1 class="text-md text-symph-200 font-bold">{{ comment.nbLikes }}</h1>
                            </div>
                            <div class="flex flex-row gap-2 items-center">
                                <MainModal @submit="submitCommentReply(comment.id, post.id)">
                                    <template #button>
                                        <Icon class="w-5 h-5 transition hover:scale-110 ease-in-out text-gray-300"
                                              icon="uil:comment"/>
                                    </template>
                                    <template #modalTitle>
                                        Ajouter un commentaire
                                    </template>
                                    <template #content>
                                        <div class="flex flex-col gap-2">
                                            <UserCommentInfo :content="comment.content" :created_at="comment.created_at"
                                                             :name="comment.user.name"
                                                             :profile_src="comment.user.profile_photo_url"
                                                             :username="comment.user.username"/>
                                        </div>
                                        <div class="flex flex-row items-start gap-4 mt-8">
                                            <img :src="$page.props.auth.user.profile_photo_url"
                                                 alt="user profile image"
                                                 class="w-12 h-12 rounded">
                                            <div class="w-full">
                                                <textarea v-model="formReply.content" class="w-full text-symph-200 h-48 rounded-lg bg-symph-800 border-symph-500 resize-none" maxlength="255"
                                                          placeholder="Ecrit ton commentaire"
                                                          required></textarea>
                                                <CounterMessage :max-characters="255"
                                                                :message="formReply.content" class="text-symph-100 w-full text-end"/>
                                            </div>
                                        </div>
                                        <button
                                            class="bg-secondary/20 hover:bg-secondary/40 border border-secondary text-white rounded-md px-4 py-2 mt-3">
                                            Envoyer
                                        </button>
                                    </template>
                                </MainModal>
                                <h1 class="text-md text-symph-200 font-bold">{{ comment.nbReplies }}</h1>
                            </div>
                            <!-- Share button -->
                            <div class="flex flex-row gap-2 items-center">

                            </div>
                        </template>
                    </Post>
                </div>
                <div v-for="(reply) in comment.reply" :key="reply.id"
                     v-if="comment.reply"
                     class="pl-14  flex w-full items-center relative">
                    <div class="w-full">
                        <Post
                            :border="false"
                            :connectLine="false"
                            :createdAt="reply.created_at"
                            :line="true"
                            :post="reply"
                            :src="reply.user.profile_photo_url"
                            :user-id="reply.user.id">
                            <template #likeButton>
                                <div class="flex flex-row gap-2 items-center">
                                    <Link :href="reply.isLiked ? route('comments.unlike', { comment: reply }) : route('comments.like', { comment: reply })"
                                          method="post">
                                        <Icon :class="[ reply.isLiked ? 'text-secondary-500' : 'text-gray-300']"
                                              class="w-5 h-5 transition hover:scale-110 hover:rotate-6 ease-in-out"
                                              icon="uil:heart"/>
                                    </Link>
                                    <h1 class="text-md text-symph-200 font-bold">{{ reply.nbLikes }}</h1>
                                </div>
                                <div class="flex flex-row gap-2 items-center">
                                    <MainModal @submit="submitCommentReply(comment.id, post.id)">
                                        <template #button>
                                            <Icon class="w-5 h-5 transition hover:scale-110 ease-in-out text-gray-300"
                                                  icon="uil:comment"/>
                                        </template>
                                        <template #modalTitle>
                                            Ajouter un commentaire
                                        </template>
                                        <template #content>
                                            <div class="flex flex-col gap-2">
                                                <UserCommentInfo :content="reply.content" :created_at="reply.created_at"
                                                                 :name="reply.user.name"
                                                                 :profile_src="reply.user.profile_photo_url"
                                                                 :username="reply.user.username"/>
                                            </div>
                                            <div class="flex flex-row items-start gap-4 mt-8">
                                                <img alt="user profile image" :src="$page.props.auth.user.profile_photo_url"
                                                     class="w-12 h-12 rounded">
                                                <div class="w-full">
                                                    <textarea v-model="formReply.content" class="w-full text-symph-200 h-48 rounded-lg bg-symph-800 border-symph-500 resize-none" maxlength="255"
                                                              placeholder="Ecrit ton commentaire"
                                                              required></textarea>
                                                    <CounterMessage :max-characters="255"
                                                                    :message="formReply.content" class="text-symph-100 w-full text-end"/>
                                                </div>
                                            </div>
                                            <button
                                                class="bg-secondary/20 hover:bg-secondary/40 border border-secondary text-white rounded-md px-4 py-2 mt-3">
                                                Envoyer
                                            </button>
                                        </template>
                                    </MainModal>
                                    <h1 class="text-md text-symph-200 font-bold">{{ reply.nbComments }}</h1>
                                </div>
                                <!-- Share button -->
                                <div class="flex flex-row gap-2 items-center">

                                </div>
                            </template>
                        </Post>
                    </div>
                </div>
            </div>
        </div>
    </SymphonyLayout>
</template>
