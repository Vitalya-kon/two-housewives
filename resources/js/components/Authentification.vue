<script setup>
import { ref } from "vue";
import axios from "axios";
import { notify } from "@kyvg/vue3-notification";
import { useRouter } from "vue-router";

import imgLogo from "/public/images/logo/Logo4.png";
// Объявление реактивных данных
let email = ref("");
let password = ref("");
let remember = ref(false);
let errors = ref({});

const router = useRouter();

// Методы

const submitForm = async () => {
  errors.value = {}; // Очистка старых ошибок
  try {
    const response = await axios.post("/api/custom-login", {
      email: email.value,
      password: password.value,
      remember: remember.value,
    });
    // console.log(response.data.error);
    if (response.data.error) {
      throw new Error(response.data.error);
    }
    // Обработка успешного входа здесь
    console.log(response.data);
    router.push(response.data.redirect);
    if (response.data) {
      localStorage.setItem("auth", "true");
    }
    notify({
      title: "Вход",
      text: "Вы вошли в систему",
      type: "success",
    });
  } catch (error) {
    console.log(error);
    // if (error.response && error.response.data.error) {
      errors.value = error.Error;
    // }
    // if (error.response && error.response.data.redirect) {
    //   router.push(error.response.data.redirect);
      notify({
        title: "Вход",
        text: error.message,
        type: "error",
      });
    // }
  }
};
</script>
<template>
  <div
    class="relative flex flex-col justify-center min-h-screen overflow-hidden"
  >
    <div
      class="w-4/5 lg:w-full p-6 m-auto bg-white rounded shadow-lg ring-2 ring-purple-800/50 lg:max-w-md"
    >
      <div class="flex justify-center">
        <img width="200" height="40" :src="imgLogo" alt="лого" />
      </div>
      <form class="mt-6" @submit.prevent="submitForm">
        <div>
          <label for="email" class="block text-sm text-gray-800">Email</label>
          <input
            type="email"
            v-model="email"
            required
            class="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40"
          />
        </div>
        <!-- <div v-if="errors" class="text-danger">{{ errors }}</div> -->
        <div class="mt-4">
          <div>
            <label for="password" class="block text-sm text-gray-800"
              >Пароль</label
            >
            <input
              type="password"
              v-model="password"
              required
              class="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40"
            />
          </div>
          <!-- <div v-if="errors" class="text-danger">
            {{ errors }}
          </div> -->
          <!-- <a href="#" class="text-xs text-gray-600 hover:underline">Forget Password?</a> -->
          <div class="mt-6">
            <button
              type="submit"
              class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-purple-700 rounded-md hover:bg-purple-600 focus:outline-none focus:bg-purple-600"
            >
              Войти
            </button>
          </div>
        </div>
      </form>

      <p class="mt-8 text-xs font-light text-center text-gray-700">
        Нет аккаунта?
        <router-link
          to="/signup"
          class="font-montserrat font-medium text-purple-600 hover:underline"
        >
          Регистрация
        </router-link>
      </p>
    </div>
  </div>
</template>
