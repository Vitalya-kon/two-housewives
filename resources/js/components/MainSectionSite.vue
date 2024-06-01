<script setup>
import { onMounted } from "vue";
import AOS from "aos";

import MainSection from "./MainSection.vue";
import ServicesSection from "./ServicesSection.vue";
import OrderServicesSection from "./OrderServicesSection.vue";
import GalarySection from "./GalarySection.vue";
import AboutUs from "./AboutUs.vue";
import Contacts from "./Contacts.vue";



onMounted(() => {
    AOS.init();
})
</script>

<template>
    <div>
        <main-section />
        <services-section />
        <order-services-section />
        <galary-section />
        <about-us />
        <contacts />
    </div>

</template>


