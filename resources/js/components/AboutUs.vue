<script setup>
    import AboutUsImage from '/public/images/AboutUs.jpg';
</script>
<template>
    <section class=" bg-white pb-20 lg:pb-44 font-poppins dark:bg-gray-800 " id="about_us_section">
        <div class=" max-w-6xl mx-auto   md:px-6">
            <div class="max-w-xl mx-auto pt-16 lg:pt-36">
                <div class="text-center ">
                    <div class="relative flex flex-col items-center">
                        <div
                            class="font-montserrat absolute hidden md:block -top-14 left-0 text-[120px] text-gray-400 font-bold opacity-10">
                            О нас
                        </div>
                        <h1 class="text-teal-500 text-3xl lg:text-5xl font-montserrat font-bold  dark:text-white">
                            О нас
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
            <div class="flex flex-wrap mt-12 lg:mt-20" data-aos="fade-up">
                <div class="w-full px-4 mb-10 lg:w-1/2 lg:mb-0">
                    <img :src="AboutUsImage" alt="О нас"
                        class="relative z-40 object-cover w-full ">
                </div>
                <div class="w-full px-4 mb-10 lg:w-1/2 lg:mb-0 ">
                    <h2
                        class=" font-montserrat py-3 pl-2 mb-4 text-2xl font-bold text-gray-700 border-l-4 border-blue-500 dark:border-blue-400 dark:text-gray-300">
                        Клининговые услуги <br> "Две хозяюшки"
                    </h2>
                    <p class="font-montserrat mb-4 text-base leading-7 text-gray-500 dark:text-gray-400">
                        Наша миссия - обеспечить вам чистоту и комфорт, которые вы заслуживаете. Мы предлагаем высококачественные услуги по хичиистке диванов, подушек и т.д.
                    </p>
                    <ul class="mb-10">
                        <li class="font-montserrat flex items-start gap-2  mb-4 text-base text-gray-600 dark:text-gray-400">
                            <span class="mt-1 text-blue-500 dark:text-blue-400 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="w-5 h-5 bi bi-patch-check-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                </svg>

                            </span>
                            <span><strong>Персонализированный подход:</strong> Мы учитываем все ваши потребности и предпочтения, чтобы предоставить вам наилучший сервис.</span>
                        </li>
                        <li class="font-montserrat flex items-start gap-2  mb-4 text-base text-gray-600 dark:text-gray-400">
                            <span class="mt-1 text-blue-500 dark:text-blue-400 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="w-5 h-5 bi bi-patch-check-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                </svg>

                            </span>
                            <span><strong>Высокое качество:</strong> Мы гордимся тем, что предлагаем высококачественные услуги по химчистке, обеспечивая безупречную чистоту.</span>
                        </li>
                        <li class="font-montserrat flex items-start gap-2  mb-4 text-base text-gray-600 dark:text-gray-400">
                            <span class="mt-1 text-blue-500 dark:text-blue-400 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="w-5 h-5 bi bi-patch-check-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                </svg>

                            </span>
                            <span><strong>Персонализированный подход:</strong> Мы учитываем все ваши потребности и предпочтения, чтобы предоставить вам наилучший сервис.</span>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
    </section>
</template>
