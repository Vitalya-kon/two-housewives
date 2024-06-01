<script setup>
    import { onMounted, ref, computed } from "vue";
    import axios from 'axios'
    import { initFlowbite } from 'flowbite'
    import AOS from "aos";


    const images = ref([]);
    const visibleCards = ref(8); // Показывать только 8 карточек (2 ряда по 4 карточки)

    const visibleServices = computed(() => {
      return images.value.slice(0, visibleCards.value);
    });

    const getServices = async () => {
      const response = await axios.get('/api/galleries')
      images.value = response.data.map(item => item.url_image);
    }

    getServices()

    onMounted(() => {
        AOS.init();
        initFlowbite();
    })
</script>

<template>
    <section class="bg-slate-100">
        <div class="container-lg lg:container  pb-20">

            <section class="flex items-center py-16 lg:py-36  dark:bg-gray-800 font-poppins" id="galery_section">
                <div class=" lg:container lg:p-4 mx-auto">
                    <div class="max-w-xl mx-auto ">
                        <div class="text-center ">
                            <div class="relative flex flex-col items-center">
                                <div
                                    class="font-montserrat absolute hidden md:block -top-14 left-0 text-[120px] text-gray-400 font-bold opacity-10">

                                    Галлерея
                                </div>
                                <h1 class="text-teal-500 text-3xl lg:text-5xl font-montserrat font-bold dark:text-white">
                                    Галлерея
                                    <!-- <span class="text-teal-500"> контакты </span> -->
                                </h1>
                                <div class="flex w-24 mt-1 mb-10 overflow-hidden rounded">
                                    <div class="flex-1 h-2 bg-teal-200">
                                    </div>
                                    <div class="flex-1 h-2 bg-teal-400">
                                    </div>
                                    <div class="flex-1 h-2 bg-teal-600">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-2 grid-cols-1 mt-12 lg:mt-24 lg:grid-cols-4 md:grid-cols-2 ">
                        <div v-for="(image, index) in visibleServices" :key="index"  class="relative overflow-hidden shadow-lg group rounded-lg" data-aos="zoom-in-up">
                            <img :src="image"
                                class="group-hover:origin-center group-hover:scale-105 transition inset-0 object-cover object-center  duration-500 w-full h-[350px]"
                                alt="">
                            <div class="absolute inset-0 z-0 group-hover:bg-black opacity-30"></div>
                            <div class="absolute hidden p-4 text-center content left-4 bottom-4 right-4 group-hover:block">
                                <a href="#" class="mb-2 text-2xl font-semibold text-gray-200 dark:text-white ">
                                </a>
                                <h2 class="mb-0 text-sm font-light text-gray-300 dark:text-gray-300 ">
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button v-if="visibleCards < images.length" @click="visibleCards += 6" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Показать еще
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </section>
</template>
