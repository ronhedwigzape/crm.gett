<template>
    <AppLayout title="Home">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                You're logged in, {{ $page.props.auth.user.name }}!
            </h2>
        </template>
        <div class="image-container">
            <img src="/city-3142651_1920.jpg" alt="Eiffel Tower" class="full-image" />
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<style scoped>
.image-container {
    width: 100%;
    height: 100vh;
    overflow: hidden;
    position: relative;
}

.full-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
}
</style>
