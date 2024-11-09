<template>
    <img :src="logoSrc" alt="GETT-logo" />
</template>

<script setup>
import { ref, onMounted } from 'vue';

const logoSrc = ref('');

onMounted(() => {
    if (window.currentRoute === 'user') {
        logoSrc.value = '/user/GATEWAY-EXPRESS-TT-LOGO.png';
    } else {
        logoSrc.value = '/GATEWAY-EXPRESS-TT-LOGO.png';
    }
});
</script>
