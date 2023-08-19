<script setup>
import { defineProps, ref } from "vue";
const props = defineProps({
    height: "100px",
    width: "100px",
    class: null,
});
const sizing = {
    logoHeight: ref(props.height),
    logoWidth: ref(props.width),
    logoClass: ref(props.class),
};
</script>

<template>
    <svg
        :class="sizing.logoClass.value"
        :width="sizing.logoWidth.value"
        :height="sizing.logoHeight.value"
        viewBox="0 0 166 165"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <g clip-path="url(#clip0_336_55)">
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M82.8348 0.164757C128.354 0.164757 165.252 37.0631 165.252 82.5823C165.252 128.102 128.354 165 82.8348 165C37.3156 165 0.417236 128.102 0.417236 82.5823C0.417236 37.0631 37.3156 0.164757 82.8348 0.164757ZM82.8348 15.923C119.651 15.923 149.494 45.7664 149.494 82.5823C149.494 119.398 119.651 149.242 82.8348 149.242C46.0189 149.242 16.1755 119.398 16.1755 82.5823C16.1755 45.7664 46.0189 15.923 82.8348 15.923Z"
            />
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M114.895 33.9642C130.662 44.3818 141.063 62.2664 141.063 82.5823C141.063 114.742 114.994 140.81 82.835 140.81C50.6756 140.81 24.6069 114.742 24.6069 82.5823C24.6069 62.2664 35.008 44.3818 50.7745 33.9642L59.2883 47.3653C47.9394 54.9642 40.4723 67.9038 40.4723 82.5823C40.4723 105.981 59.4366 124.945 82.835 124.945C106.233 124.945 125.198 105.981 125.198 82.5823C125.198 67.9038 117.731 54.9642 106.382 47.3653L114.895 33.9642Z"
            />
            <path d="M90.7718 22.6648H74.8982V97.7389H90.7718V22.6648Z" />
        </g>
        <defs>
            <clipPath id="clip0_336_55">
                <rect
                    width="164.835"
                    height="164.835"
                    transform="translate(0.417969 0.164795)"
                />
            </clipPath>
        </defs>
    </svg>
</template>
