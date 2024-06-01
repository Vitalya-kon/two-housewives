<script setup>
import { ref, reactive, onMounted } from "vue";
import { initFlowbite } from 'flowbite'
import { notify } from "@kyvg/vue3-notification";
import axios from "axios";

const activeTab = ref('gallery')
const image = ref(null);
const galleries = ref([]);
const isLoading = ref(true); // Состояние загрузки
const error = ref(null);
const description = "Формат изображения: jpg, jpeg, png, svg, webp. Размер изображения не должен превышать 12МБ.";

const onFileChange = (e) => {
  image.value = e.target.files[0];
};

const getGalleries = async () => {
    isLoading.value = true; // установите в true перед загрузкой
    const response = await axios.get("/api/galleries");
    galleries.value = response.data;
    isLoading.value = false; // установите в false после загрузки
};

const deleteGallery = async (id) => {
  try {
    const response = await axios.delete(`/api/galleries/${id}`);
    if (response.status === 200) {
      console.log("Элемент успешно удален");
      notify({
        title: "Удаление",
        text: "Удаление изображения успешно",
        type: "error",
    });
      getGalleries();
    } else {
      console.log("Произошла ошибка при удалении элемента");
    }
  } catch (error) {
    console.error(error);
  }
};

const addService = async () => {
  let formData = new FormData();
  formData.append("image", image.value);

  try {
    const response = await axios.post("/api/galleries", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    notify({
      title: "Добавление",
      text: "Добавление изображения успешно",
      type: "success",
    });

    galleries.value.push(response.data);
    image.value = null;
    error.value = null;
  } catch (err) {

    console.log(err.response.data.errors );
    if (err.response && err.response.data && err.response.data.errors && err.response.data.errors.image) {
        error.value = err.response.data.errors.image.join(', ');
    } else {
        error.value = 'Произошла неизвестная ошибка';
    }
  }
};

onMounted(() => {
    getGalleries();
    initFlowbite();
})


</script>
<template>
    <div class="bg-transparent min-h-screen ">

        <div class="bg-slate-200 min-h-screen">
            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex justify-center flex-wrap -mb-px">
                    <li class="me-2">
                        <router-link to="/service/create"
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        :class="{ 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500': activeTab === 'services' }"
                        @click="activeTab = 'services'">Услуги</router-link>
                    </li>
                    <li class="me-2">
                        <router-link to="/gallary/create"
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        :class="{ 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500': activeTab === 'gallery' }"
                        @click="activeTab = 'gallery'">Галерея</router-link>
                    </li>
                </ul>
            </div>

            <div class="container-lg lg:container mx-auto pt-10">
                <form
                @submit.prevent="addService"
                class="max-w-xl mx-auto bg-white p-6 rounded shadow"
                id="form_service"
                >
                <h2 class="font-montserrat font-bold text-lg pb-4">Добавить изображение</h2>


                <p class="font-montserrat text-lg pb-2">Изображение для галлереи</p>
                <div id="tooltip-light_file"  role="tooltip" class="absolute z-50 w-96 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip font-montserrat whitespace-pre-line">
                    {{ description }}
                </div>
                <p class="text-red-500 text-xs font-montserrat pb-1" v-if="error">*{{ error }}</p>
                <label class="mb-4 w-full" data-tooltip-target="tooltip-light_file" data-tooltip-placement="top">
                    <input @change="onFileChange"  class="block w-full text-sm text-gray-400 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
                </label>


                <button
                    type="submit"
                    class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:bg-blue-300 cursor-not-allowed"
                >
                Сохранить
                </button>
                </form>
            </div>
            <div class="pb-44">

                <!-- Прелоадер -->
                <div v-if="isLoading" class="mt-10 h-30vh flex justify-center">
                    <div id="page">
                            <div id="container">
                                <div id="ring"></div>
                                <div id="ring"></div>
                                <div id="ring"></div>
                                <div id="ring"></div>
                                <div id="h3">Загрузка</div>
                            </div>
                    </div>
                </div>
                <div v-else
                class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-5 container-lg lg:container"
            >
                <div v-for="gallery in galleries" :key="gallery.id" class="mt-10">
                    <div class="relative mx-auto w-full" v-auto-animate>
                        <div
                        class="shadow p-4 rounded-lg bg-white relative inline-block duration-300 ease-in-out transition-transform transform hover:-translate-y-2 w-full"
                        >
                            <div
                            class="flex justify-center relative rounded-lg overflow-hidden h-80"
                            >
                                <div
                                    class="transition-transform duration-500 transform ease-in-out hover:scale-110 w-full"
                                >
                                    <div class="absolute inset-0 bg-gray-500">
                                        <img
                                            :src="gallery.url_image"
                                            alt=""
                                            class="h-full w-full object-cover"
                                        />
                                    </div>

                                </div>

                            </div>
                            <div class="mt-4">
                                <button
                                class="inline-flex items-center px-4 py-2 bg-red-600 transition ease-in-out delay-75 hover:bg-red-700 text-white text-sm font-medium rounded-md hover:-translate-y-1 hover:scale-110"
                                @click="deleteGallery(gallery.id)"
                                >
                                <svg
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    class="h-5 w-5 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                    stroke-width="2"
                                    stroke-linejoin="round"
                                    stroke-linecap="round"
                                    ></path>
                                </svg>

                                Удалить
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>



    </div>
</template>
<style scoped>
#page {
  display: flex;
  justify-content: center;
  align-items: center;
}

#container {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

#h3 {
  color: rgb(82, 79, 79);
}

#ring {
  width: 190px;
  height: 190px;
  border: 1px solid transparent;
  border-radius: 50%;
  position: absolute;
}

#ring:nth-child(1) {
  border-bottom: 8px solid rgb(240, 42, 230);
  animation: rotate1 2s linear infinite;
}

@keyframes rotate1 {
  from {
    transform: rotateX(50deg) rotateZ(110deg);
  }

  to {
    transform: rotateX(50deg) rotateZ(470deg);
  }
}

#ring:nth-child(2) {
  border-bottom: 8px solid rgb(240, 19, 67);
  animation: rotate2 2s linear infinite;
}

@keyframes rotate2 {
  from {
    transform: rotateX(20deg) rotateY(50deg) rotateZ(20deg);
  }

  to {
    transform: rotateX(20deg) rotateY(50deg) rotateZ(380deg);
  }
}

#ring:nth-child(3) {
  border-bottom: 8px solid rgb(3, 170, 170);
  animation: rotate3 2s linear infinite;
}

@keyframes rotate3 {
  from {
    transform: rotateX(40deg) rotateY(130deg) rotateZ(450deg);
  }

  to {
    transform: rotateX(40deg) rotateY(130deg) rotateZ(90deg);
  }
}

#ring:nth-child(4) {
  border-bottom: 8px solid rgb(207, 135, 1);
  animation: rotate4 2s linear infinite;
}

@keyframes rotate4 {
  from {
    transform: rotateX(70deg) rotateZ(270deg);
  }

  to {
    transform: rotateX(70deg) rotateZ(630deg);
  }
}
/* Improving visualization in light mode */
</style>
