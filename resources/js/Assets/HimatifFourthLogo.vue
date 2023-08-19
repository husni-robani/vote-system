<script setup>
import {defineProps, ref} from "vue";

const props = defineProps({
  height: {
    default: "100"
  },
  width: {
    default: "100"
  },
  class: {
    default: ""
  },
});

const sizing = {
  logoHeight: ref(props.height),
  logoWidth: ref(props.width),
  logoClass: ref(props.class),
};
</script>
<template>
  <svg :height="props.height" :width="props.width" fill="none" viewBox="0 0 165 165" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_336_45)">
      <path clip-rule="evenodd"
            d="M82.4176 0.164795C127.937 0.164795 164.835 37.0631 164.835 82.5824C164.835 128.102 127.937 165 82.4176 165C36.8983 165 0 128.102 0 82.5824C0 37.0631 36.8983 0.164795 82.4176 0.164795ZM82.4176 15.923C119.234 15.923 149.077 45.7664 149.077 82.5824C149.077 119.398 119.234 149.242 82.4176 149.242C45.6016 149.242 15.7582 119.398 15.7582 82.5824C15.7582 45.7664 45.6016 15.923 82.4176 15.923Z"
            fill="black"
            fill-rule="evenodd"/>
      <path clip-rule="evenodd"
            d="M114.478 33.9642C130.244 44.3818 140.646 62.2664 140.646 82.5824C140.646 114.742 114.577 140.81 82.4175 140.81C50.2581 140.81 24.1895 114.742 24.1895 82.5824C24.1895 62.2664 34.5906 44.3818 50.357 33.9642L58.8708 47.3653C47.5219 54.9642 40.0548 67.9038 40.0548 82.5824C40.0548 105.981 59.0191 124.945 82.4175 124.945C105.816 124.945 124.78 105.981 124.78 82.5824C124.78 67.9038 117.313 54.9642 105.964 47.3653L114.478 33.9642Z"
            fill="black"
            fill-rule="evenodd"/>
      <path d="M90.3546 22.6648H74.481V97.739H90.3546V22.6648Z" fill="black"/>
    </g>
    <defs>
      <clipPath id="clip0_336_45">
        <rect fill="white" height="164.835" transform="translate(0 0.164795)" width="164.835"/>
      </clipPath>
    </defs>
  </svg>

</template>
