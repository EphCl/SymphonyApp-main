<script setup>
import Logo from "/public/Logo.png";
import {ref} from "vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Dropdown from "@/Components/Dropdown.vue";
import {Link, router} from "@inertiajs/vue3";
import {Icon} from '@iconify/vue';
import Notification from "@/Components/Symphony/Notification.vue";

defineProps({
    isLogin: Boolean,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

</script>

<template>
    <nav class="">
        <div class="flex justify-between items-center h-full px-10">
            <div class="flex flex-row items-center gap-4">
                <Link :href="route('posts.index')" class="flex flex-row items-center gap-2">
                    <img :src="Logo" alt="img" class="h-12 rounded-lg">
                    <h1 class="text-3xl font-bold text-white hover:text-symph-100 hidden sm:block">SYMPHONY</h1>
                </Link>
            </div>
            <div class="flex flex-row items-center gap-4">
                <Link :href="route('notifications.index')" class="relative">
                    <Icon
                        class="text-3xl text-gray-500 hover:text-gray-400 hover:transition hover:scale-110 ease-in-out"
                        icon="mingcute:notification-line"></Icon>
                    <Notification :notifications="$page.props.unreadNotificationsNumber"></Notification>
                </Link>
                <Link :href="route('search.index')">
                    <Icon
                        class="text-2xl text-gray-500 hover:text-gray-400 hover:transition hover:scale-110 ease-in-out"
                        icon="iconamoon:search-duotone"></Icon>
                </Link>
                <div v-if="!$page.props.auth.user"
                     class="border-secondary-500 hover:border-secondary-400 hover:bg-gray-900 border-2 rounded-lg py-1.5 px-2">
                    <a :href="route('login')" class="h-max flex flex-row items-center gap-4">
                        <Icon class="text-2xl text-secondary-200" icon="material-symbols:login"></Icon>
                        <h1 class="text-md font-bold text-secondary-500">Login</h1>
                    </a>
                </div>
                <div v-else>
                    <div class="flex sm:items-center">
                        <div class="relative">
                            <!-- Teams Dropdown -->
                            <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                                                type="button">
                                                {{ $page.props.auth.user.current_team.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" fill="none"
                                                     stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
                                                          stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </span>
                                </template>

                                <template #content>
                                    <div class="w-60">
                                        <!-- Team Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Team
                                        </div>

                                        <!-- Team Settings -->
                                        <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">
                                            Team Settings
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.canCreateTeams"
                                                      :href="route('teams.create')">
                                            Create New Team
                                        </DropdownLink>

                                        <!-- Team Switcher -->
                                        <template v-if="$page.props.auth.user.all_teams.length > 1">
                                            <div class="border-t border-gray-200"/>

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Switch Teams
                                            </div>

                                            <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                <form @submit.prevent="switchToTeam(team)">
                                                    <DropdownLink as="button">
                                                        <div class="flex items-center">
                                                            <svg v-if="team.id == $page.props.auth.user.current_team_id"
                                                                 class="me-2 h-5 w-5 text-green-400" fill="none"
                                                                 stroke="currentColor"
                                                                 stroke-width="1.5" viewBox="0 0 24 24"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                            </svg>

                                                            <div>{{ team.name }}</div>
                                                        </div>
                                                    </DropdownLink>
                                                </form>
                                            </template>
                                        </template>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                                            class="flex text-sm  border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img :alt="$page.props.auth.user.name"
                                             :src="$page.props.auth.user.profile_photo_url"
                                             class="h-8 w-8 rounded-full object-cover">
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                            <button
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                                                type="button">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" fill="none"
                                                     stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19.5 8.25l-7.5 7.5-7.5-7.5" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Paramètre
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Editez le profil
                                    </DropdownLink>

                                    <DropdownLink :href="route('profileUser.show', {id: $page.props.auth.user.id})">
                                        Compte
                                    </DropdownLink>

                                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                                  :href="route('api-tokens.index')">
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-symph-500"/>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Déconnexion
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>

</style>
