<script setup>
    import axios from "axios";
    import { useRouter } from 'vue-router'
    import { ref, onMounted, onBeforeUnmount } from 'vue';

    import HeaderInfo from './HeaderInfo.vue';

    import imgCleaning from '/public/images/1626352567_50-kartinkin-com-p-bitovaya-khimiya-fon-krasivo-60.jpg';
    import imgUser from '/public/images/logo/pngwing.com (11).png';
    import imgLogo from '/public/images/logo/Logo2.png';
    import { notify } from "@kyvg/vue3-notification";


    const isOpen = ref(false);

    const authCheck = ref(false);
    const isMobile = ref(window.innerWidth <= 768);
    const isBurgerOpen = ref(false);

    const name = ref('');
    const email = ref('');
    const role = ref('');

    const router = useRouter()


    if (localStorage.getItem('auth')) {
        authCheck.value = localStorage.getItem('auth');
    }else{
        authCheck.value = false;
    }

    const getUser = async () => {
        try {
            const response = await axios.get('/api/user');

            if (response.data.message != 'Unauthenticated.') {
                name.value = response.data.name;
                email.value = response.data.email;
                role.value = response.data.role;
            } else {
                localStorage.removeItem('auth');
            }
        } catch (error) {
            console.log(error);
            if (error.response && error.response.status === 401) {
                localStorage.removeItem('auth');
            }
        }
    }

    const logout = async () => {
        try {
            const response = await axios.get('/api/logout');

            authCheck.value = false;
            localStorage.removeItem('auth');
            router.push(response.data.redirect);
            notify({
                title: "Выход",
                text: "Вы вышли из системы",
                type: "warn",
            });
        } catch (error) {
            console.error(error);
        }
    }

    window.addEventListener('resize', () => {
        isMobile.value = window.innerWidth <= 768;
    });
    // Создаем реактивное значение для смещения изображения
    const offsetY = ref(0);

    // Функция для обработки события прокрутки
    const handleScroll = () => {
    // Обновляем смещение изображения в зависимости от положения прокрутки
    offsetY.value = window.pageYOffset * 0.5;
    };

    // Добавляем обработчик события прокрутки при монтировании компонента
    onMounted(() => {
        window.addEventListener('scroll', handleScroll);

    });
    // Удаляем обработчик события прокрутки перед удалением компонента
    onBeforeUnmount(() => {
        window.removeEventListener('scroll', handleScroll);
    });
    getUser();
</script>

<template>
    <div class="relative">
        <HeaderInfo />
        <header class="p-6 ">
            <div class="lg:container">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold underline">
                        <router-link to="/" class="font-montserrat texe-base font-medium hover:border-b-2 border-yellow-300">
                            <img :src="imgLogo" alt="logo" class="w-40">
                        </router-link>
                    </h1>
                    <nav >
                        <ul class="flex gap-10" v-if="!isMobile">
                            <li><a href="#services_section" v-auto-animate class="font-montserrat text-base font-medium hover:border-b-2 border-yellow-300">Услуги</a></li>
                            <li><a href="#galery_section" v-auto-animate class="font-montserrat text-base font-medium hover:border-b-2 border-yellow-300">Галерея</a></li>
                            <li><a href="#contacts" v-auto-animate class="font-montserrat texe-base font-medium hover:border-b-2 border-yellow-300">Контакты</a></li>
                            <li><a href="#about_us_section" v-auto-animate class="font-montserrat texe-base font-medium hover:border-b-2 border-yellow-300">О нас</a></li>

                            <li v-if="!authCheck">
                                <router-link to="/auth" class="">
                                    <svg width="30" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20.1633 4.09295L15.0612 2.17072C14.1429 1.86721 13.2245 1.96838 12.5102 2.47423C12.2041 2.67657 12 2.87891 11.7959 3.08125H7.91837C6.38776 3.08125 5.06122 4.39646 5.06122 5.91401V6.9257C5.06122 7.33038 5.36735 7.73506 5.87755 7.73506C6.38776 7.73506 6.69388 7.33038 6.69388 6.9257V5.91401C6.69388 5.20582 7.30612 4.69997 7.91837 4.69997H11.2857V19.3696H7.91837C7.20408 19.3696 6.69388 18.7626 6.69388 18.1555V17.1439C6.69388 16.7392 6.38776 16.3345 5.87755 16.3345C5.36735 16.3345 5.06122 16.638 5.06122 17.0427V18.0544C5.06122 19.5719 6.28572 20.8871 7.91837 20.8871H11.7959C12 21.0895 12.2041 21.393 12.4082 21.4942C12.9184 21.7977 13.4286 22 14.0408 22C14.3469 22 14.7551 21.8988 15.0612 21.7977L20.1633 19.8754C21.2857 19.4708 22 18.4591 22 17.245V6.62219C22 5.50933 21.1837 4.39646 20.1633 4.09295Z" fill="#ffffff"></path> <path d="M6.38776 13.5017C6.08163 13.8052 6.08163 14.3111 6.38776 14.6146C6.4898 14.7158 6.69388 14.8169 6.89796 14.8169C7.10204 14.8169 7.30612 14.7158 7.40816 14.6146L9.44898 12.5912C9.55102 12.49 9.55102 12.3889 9.65306 12.3889C9.65306 12.2877 9.7551 12.1865 9.7551 12.0854C9.7551 11.9842 9.7551 11.883 9.65306 11.7819C9.65306 11.6807 9.55102 11.5795 9.44898 11.5795L7.40816 9.55612C7.10204 9.25261 6.59184 9.25261 6.28571 9.55612C5.97959 9.85963 5.97959 10.3655 6.28571 10.669L7 11.3772H2.81633C2.40816 11.3772 2 11.6807 2 12.1865C2 12.6924 2.30612 12.9959 2.81633 12.9959H7.10204L6.38776 13.5017Z" fill="#ffffff"></path> </g></svg>
                                </router-link>
                            </li>
                            <li v-else>
                                    <div class="flex justify-center">

                                            <!-- Dropdown toggle button -->
                                            <div @click="isOpen = !isOpen" class="cursor-pointer select-none">
                                                <svg width="30" height="25" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#38ffc3" stroke="#38ffc3"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M512 661.3c-117.6 0-213.3-95.7-213.3-213.3S394.4 234.7 512 234.7 725.3 330.4 725.3 448 629.6 661.3 512 661.3z m0-341.3c-70.6 0-128 57.4-128 128s57.4 128 128 128 128-57.4 128-128-57.4-128-128-128z" fill="#38ffc3"></path><path d="M837 862.9c-15.7 0-30.8-8.7-38.2-23.7C744.3 729.5 634.4 661.3 512 661.3s-232.3 68.1-286.8 177.9c-10.5 21.1-36.1 29.7-57.2 19.2s-29.7-36.1-19.2-57.2C217.8 662.3 357 576 512 576s294.2 86.3 363.2 225.2c10.5 21.1 1.9 46.7-19.2 57.2-6.1 3-12.6 4.5-19 4.5z" fill="#38ffc3"></path><path d="M512 1002.7c-270.6 0-490.7-220.1-490.7-490.7S241.4 21.3 512 21.3s490.7 220.1 490.7 490.7-220.1 490.7-490.7 490.7z m0-896c-223.5 0-405.3 181.8-405.3 405.3S288.5 917.3 512 917.3 917.3 735.5 917.3 512 735.5 106.7 512 106.7z" fill="#38ffc3"></path></g></svg>
                                            </div>
                                            <!-- Dropdown menu -->
                                            <div v-if="isOpen" class="absolute top-14  right-20 z-20 w-64 py-2 mt-2 overflow-hidden bg-white rounded-md shadow-xl dark:bg-gray-800">
                                                <a href="#" class="flex items-center p-3 -mt-2 text-sm text-gray-600 transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                                    <img class="flex-shrink-0 object-cover mx-1 rounded-full w-9 h-9" :src="imgUser" alt="jane avatar">
                                                    <div class="mx-1">
                                                        <h1 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ name }}</h1>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ email }}</p>
                                                    </div>
                                                </a>
                                                <router-link to="/service/create" v-if="role === 'admin'" @click="isOpen = !isOpen" class="cursor-pointer block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">

                                                        Админка

                                                </router-link>

                                                <hr class="border-gray-200 dark:border-gray-700 ">
                                                <span @click = "logout" class="cursor-pointer block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-red-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                                    Выход
                                                </span>
                                            </div>

                                    </div>
                            </li>

                        </ul>
                        <!-- <div > -->
                            <input type="checkbox" id="checkbox" v-else @click="isBurgerOpen = !isBurgerOpen">
                            <label for="checkbox" class="toggle flex lg:hidden">
                                <div class="bars" id="bar1"></div>
                                <div class="bars" id="bar2"></div>
                                <div class="bars" id="bar3"></div>
                            </label>
                        <!-- </div> -->
                    </nav>
                </div>
            </div>
        </header>
        <div class="absolute w-full h-screen -top-5 right-0 -z-10 blur lg:blur-none ">
            <img :src="imgCleaning" alt="cleaning" :style="{ transform: `translateY(${offsetY}px)` }" class="absolute object-cover w-full h-full" >
        </div>
        <div v-if="isBurgerOpen" class="fixed z-10">
            <div class="w-full  fixed top-20 overflow-auto  burger_menu open" v-auto-animate>

                <ul class="flex flex-col gap-3 pt-4 text-white font-montserrat justify-center items-center">
                    <li @click="isBurgerOpen = !isBurgerOpen"><a href="#services_section" v-auto-animate class="font-montserrat text-base font-medium hover:border-b-2 border-yellow-300">Услуги</a></li>
                    <li @click="isBurgerOpen = !isBurgerOpen"><a href="#galery_section" v-auto-animate class="font-montserrat text-base font-medium hover:border-b-2 border-yellow-300">Галерея</a></li>
                    <li @click="isBurgerOpen = !isBurgerOpen"><a href="#contacts" v-auto-animate class="font-montserrat texe-base font-medium hover:border-b-2 border-yellow-300">Контакты</a></li>
                    <li @click="isBurgerOpen = !isBurgerOpen"><a href="#about_us_section" v-auto-animate class="font-montserrat texe-base font-medium hover:border-b-2 border-yellow-300">О нас</a></li>

                    <li @click="isBurgerOpen = !isBurgerOpen" v-if="!authCheck">
                        <router-link to="/auth" class="">
                            <button class="px-6 py-2 mb-4 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                                Войти
                            </button>
                        </router-link>
                    </li>

                    <li v-if="authCheck && role === 'admin'" @click="isBurgerOpen = !isBurgerOpen"><router-link to="/service/create" class="font-montserrat texe-base font-medium hover:border-b-2 border-yellow-300">Админка</router-link></li>

                </ul>

                <div v-if="authCheck" class="mt-7">
                    <span class="flex items-center justify-center text-center p-3 -mt-2 text-sm text-gray-600 transition-colors duration-200 transform  ">
                        <div class="mx-1">
                            <h1 class="text-sm  text-gray-200 dark:text-gray-200">{{ name }}</h1>
                            <p class="text-sm text-gray-200 dark:text-gray-400">{{ email }}</p>
                        </div>
                    </span>
                    <div class="flex justify-center mb-4">
                        <button @click = "logout"  class="px-6 py-2  font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-red-400 rounded-lg hover:bg-red-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                            Выйти
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    header {
        background-color: rgb(87, 164, 136);
        backdrop-filter: blur(10px)
    }
   @media screen and (max-width: 1024px) {
       header{
        padding: 10px;
       }
   }
  
    header nav>ul>li>a{
        color: white;
        padding: 27px 0;
    }
    header nav>ul>li>a:hover{
        color: yellow;
        transition: color .2s;
    }



    /* Show the burger menu when it's open */

    .burger_menu{
        background-color: rgb(87, 164, 136);
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease; /* Apply transition for smooth sliding animation */
        transform: translateY(100%); /* Start with the menu hidden off-screen */
    }
    .burger_menu.open {
        transform: translateY(0);
    }

    #checkbox {
    display: none;
    }

    .toggle {
        position: relative;
        width: 40px;
        height: 40px;
        cursor: pointer;
        /* display: flex; */
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition-duration: .3s;
    }

    .bars {
        width: 100%;
        height: 4px;
        background-color: rgb(228, 236, 225);
        border-radius: 5px;
        transition-duration: .3s;
    }

    #checkbox:checked + .toggle .bars {
        margin-left: 13px;
    }

    #checkbox:checked + .toggle #bar2 {
        transform: rotate(135deg);
        margin-left: 0;
        transform-origin: center;
        transition-duration: .3s;
    }

    #checkbox:checked + .toggle #bar1 {
        transform: rotate(45deg);
        transition-duration: .3s;
        transform-origin: left center;
    }

    #checkbox:checked + .toggle #bar3 {
        transform: rotate(-45deg);
        transition-duration: .3s;
        transform-origin: left center;
    }
</style>
