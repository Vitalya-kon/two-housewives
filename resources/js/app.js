/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import { library } from '@fortawesome/fontawesome-svg-core';
import { faPhone } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import PrimeVue from 'primevue/config';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Notifications from '@kyvg/vue3-notification'
import VueCookies from 'vue3-cookies'
import { VueCookieNext } from 'vue-cookie-next'
import FloatingVue from 'floating-vue'

library.add(faPhone);
// importing AOS css style globally
import 'aos/dist/aos.css'
import 'tailwindcss/tailwind.css'
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import 'floating-vue/dist/style.css'


// Import components
import App from './components/App.vue';
import AddServices from './components/AddServices.vue'
import AddGallary from './components/AddGallary.vue'
import MainSectionSite from './components/MainSectionSite.vue'
import Authentification from './components/Authentification.vue'
import Signup from './components/Signup.vue'

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const router = createRouter({
    history: createWebHistory(),
    routes: [
      {
        path: '/',
        component: MainSectionSite
      },
      {
        path: '/service/create',
        component: AddServices,
        meta: { requiresAuth: true } // устанавливаем метаданные для требуемой аутентификации
      },
      {
        path: '/gallary/create',
        component: AddGallary,
        meta: { requiresAuth: true } // также устанавливаем метаданные для требуемой аутентификации
      },
      {
        path: '/auth',
        component: Authentification
      },
      {
        path: '/signup',
        component: Signup
      }
    ]
  });




  router.beforeEach((to, from, next) => {
    const userIsLoggedIn = !!localStorage.getItem('auth');
    if (to.matched.some(record => record.meta.requiresAuth) && !userIsLoggedIn) {
      next('/auth'); // перенаправляем на страницу аутентификации, если не выполнен вход
    } else {
      next(); // продолжаем нормальное выполнение навигации
    }
  });



const app = createApp(App);
app.use(router);
app.use(autoAnimatePlugin);
app.use(PrimeVue);
app.use(Notifications)
app.use(VueCookies)
app.use(VueCookieNext)
app.use(FloatingVue,{
    themes: {
      123: {
        triggers: ['hover'],
        autoHide: true,
        placement: 'top',
      },
    },
  })

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.component('VueDatePicker', VueDatePicker);
app.component('font-awesome-icon', FontAwesomeIcon)
app.mount('#app');
