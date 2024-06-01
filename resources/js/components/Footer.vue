<script setup>
    import { ref, onMounted } from 'vue';

    import imgLogo from '/public/images/logo/Logo4.png';


    const currentYear = ref(null);

    onMounted(() => {
      currentYear.value = new Date().getFullYear();
    });
</script>
<template>
    <footer class="bg-white dark:bg-gray-900 pt-3 lg:pt-10">
        <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
            <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="https://flowbite.com/" class="flex items-center">
                    <img :src="imgLogo" class="h-8 me-3" alt="Logo" />
                </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3 mt-10 lg:mt-0">
                <div class="font-montserrat">
                    <h2 class="mb-6 text-sm font-bold text-gray-900 uppercase dark:text-white">Цены</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="/documents/price.ods" target="_blank" class="hover:underline">Прайс услуг</a>
                        </li>
                    </ul>
                </div>
                <div class="font-montserrat">
                    <h2 class="mb-6 text-sm font-bold text-gray-900 uppercase dark:text-white">Условия</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="/documents/Usloviya.odt" target="_blank" class="hover:underline">Оплата и трансфер</a>
                        </li>
                    </ul>
                </div>


            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ currentYear == 2024 ? currentYear : '2024 - ' + currentYear  }} <a href="/" class="hover:underline"> "Две хозяюшки"</a>
            </span>

        </div>
        </div>
    </footer>
</template>
