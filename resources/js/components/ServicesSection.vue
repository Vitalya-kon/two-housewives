<script setup>
    import { ref, computed, onMounted } from 'vue'
    import axios from 'axios'
    import { initFlowbite } from 'flowbite'

    import CardServices from './CardServices.vue';


    const originalServices = ref([]) // исходные данные
    const services = ref([])
    const inputSearch = ref(''); // инициализация значения ввода
    const visibleCards = ref(6); // Показывать только 6 карточек (2 ряда по 3 карточки)

    const visibleServices = computed(() => {
      return services.value.slice(0, visibleCards.value);
    });

    const getServices = async () => {
      const response = await axios.get('/api/service_cleaning')
      originalServices.value = response.data // сохраняем исходные данные
      services.value = response.data // и отображаемые данные
    }

    onMounted(() => {
        initFlowbite();
    })

    getServices()

    const getSearch = () => {
        services.value = originalServices.value.filter(card => card.service.toLowerCase().includes(inputSearch.value.toLowerCase()));
    }
</script>
<template>
    <section class="bg-slate-100 mt-44 pb-20 lg:pb-44" id="services_section">
        <div class="container-lg lg:container mx-auto">
            <div class="max-w-xl mx-auto pt-16 lg:pt-36">
                <div class="text-center ">
                    <div class="relative flex flex-col items-center">
                        <div
                            class="font-montserrat absolute hidden md:block -top-14 left-0 text-[120px] text-gray-400 font-bold opacity-10">
                            Услуги
                        </div>
                        <h1 class="text-teal-500 text-3xl lg:text-5xl font-montserrat font-bold  dark:text-white">
                            Услуги
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
            <div class="lg:px-4" data-aos="fade-up">
                <div
                    class="bg-gradient-to-br from-sky-400 via-sky-400 to-violet-400 p-2 lg:p-4  rounded-2xl w-full text-white flex items-center justify-between max-w-2xl mx-auto mt-20">
                    <div class="flex flex-col gap-6">
                        <div class="">
                            <span class="text-gray-200 text-xl lg:text-4xl font-montserrat text-white font-semibold">10% всем на все услуги</span>
                        </div>

                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-gray-100" viewBox="0 0 15 15">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M4.5 0A2.5 2.5 0 0 0 2 2.5v.286c0 .448.133.865.362 1.214H1.5A1.5 1.5 0 0 0 0 5.5v1A1.5 1.5 0 0 0 1.5 8H7V4h1v4h5.5A1.5 1.5 0 0 0 15 6.5v-1A1.5 1.5 0 0 0 13.5 4h-.862c.229-.349.362-.766.362-1.214V2.5A2.5 2.5 0 0 0 10.5 0c-1.273 0-2.388.68-3 1.696A3.498 3.498 0 0 0 4.5 0ZM8 4h2.786C11.456 4 12 3.456 12 2.786V2.5A1.5 1.5 0 0 0 10.5 1A2.5 2.5 0 0 0 8 3.5V4ZM7 4H4.214C3.544 4 3 3.456 3 2.786V2.5A1.5 1.5 0 0 1 4.5 1A2.5 2.5 0 0 1 7 3.5V4Z"
                                clip-rule="evenodd"></path>
                            <path fill="currentColor" d="M7 9H1v3.5A2.5 2.5 0 0 0 3.5 15H7V9Zm1 6h3.5a2.5 2.5 0 0 0 2.5-2.5V9H8v6Z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mt-20 flex justify-end" data-aos="fade-up">
                <div class="flex items-center lg:w-60 md:w-full">
                    <div class="relative w-full">
                        <input v-model="inputSearch" @input="getSearch" type="text" id="voice-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Поиск" required />
                        <svg class="absolute top-2 right-3 w-4 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-5 pt-10 lg:pt-20">
                <div v-for="service in visibleServices" :key="service.id">
                    <CardServices
                        :id="service.id"
                        :service="service.service"
                        :url_image="service.url_image"
                        :description="service.description"
                        :from_price="service.from_price"
                        :to_price="service.to_price"
                        :from_last_price="service.from_last_price"
                        :to_last_price="service.to_last_price"
                    />
                </div>
            </div>
            <div class="flex justify-center mt-10">
                <button v-if="visibleCards < services.length" @click="visibleCards += 6" class="mt-4 px-4 py-2 bg-teal-400 text-white rounded hover:bg-teal-600">
                    Показать еще
                </button>
            </div>
        </div>
    </section>
</template>
