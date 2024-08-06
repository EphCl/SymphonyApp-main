<template>
    <div class="relative">
        <audio id="stream" ref="audioPlayer" preload @timeupdate="updateProgress">
            <source :src="'/storage/' + song.path">
        </audio>
        <div>
            <svg
                height="80"
                style="transform: rotate(-90deg);cursor: pointer;"
                viewBox="0 0 160 160"
                width="80"
            >
                <circle
                    cx="80"
                    cy="80"
                    fill="transparent"
                    r="70"
                    stroke="#e0e0e0"
                    stroke-width="12px"
                ></circle>
                <circle
                    ref="draggable"
                    :stroke-dasharray="circumference"
                    :stroke-dashoffset="circumference * ((100 - percent) / 100) + 'px'"
                    cx="80"
                    cy="80"
                    fill="transparent"
                    r="70"
                    stroke="#FFA000"
                    stroke-linecap="round"
                    stroke-width="12px"
                ></circle>
            </svg>
        </div>
        <button class="play-pause-button" @click.prevent="togglePlayback">
            <Icon v-if="!isPlaying" class="w-6 h-6 text-secondary" icon="carbon:play-filled"/>
            <Icon v-else class="w-6 h-6" icon="carbon:pause-filled"/>
        </button>
    </div>
    <div></div>
</template>

<script setup>
import {defineProps, ref} from 'vue';
import {Icon} from "@iconify/vue";

const props = defineProps({
    song: Object,
});

const audioPlayer = ref(null);
const isPlaying = ref(false);
const circumference = ref(439.6);
const percent = ref(0);
const draggable = ref(null);


const togglePlayback = () => {
    if (audioPlayer.value.paused) {
        audioPlayer.value.play();
        isPlaying.value = true;
    } else {
        audioPlayer.value.pause();
        isPlaying.value = false;
    }
};


const updateProgress = () => {
    const currentTime = audioPlayer.value.currentTime;
    const duration = audioPlayer.value.duration;
    percent.value = (currentTime / duration) * 100;
};
</script>

<style scoped>
.play-pause-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: none;
    border: none;
    cursor: pointer;
    outline: none;
    font-size: 24px;
    color: #FFA000; /* Change color as needed */
}
</style>
