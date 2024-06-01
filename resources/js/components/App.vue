<script setup>
import { onMounted } from "vue";
import AOS from "aos";
import axios from "axios";

import Header from "./Header.vue";
import Footer from "./Footer.vue";

onMounted(() => {
    AOS.init();
    axios.defaults.withCredentials = true;
})
</script>

<template>
    <div>
        <Header :key="$route.fullPath" />
        <router-view></router-view>
        <Footer />
        <notifications
            position="top right"
            width="20vw"/>
    </div>

</template>
<style scoped>

</style>


