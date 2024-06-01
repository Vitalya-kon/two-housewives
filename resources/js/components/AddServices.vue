<script setup>
import { ref, reactive } from "vue";
import axios from "axios";
import { notify } from "@kyvg/vue3-notification";

const services = ref([]);
const image = ref(null);
const editing = ref(false);
const editingId = ref(null);
const isLoading = ref(true); // Состояние загрузки
const activeTab = ref('services')

let errors = reactive({
  from_price: "",
  to_price: "",
  from_last_price: "",
  to_last_price: "",
});
let service = reactive({
  service: "",
  description: "",
  from_price: 0,
  to_price: 0,
  from_last_price: 0,
  to_last_price: 0,
});


const stopEditing = () => {
  editing.value = false;
  editingId.value = null;

  service.service = "";
  service.description = "";
  service.from_price = 0;
  service.to_price = 0;
  service.from_last_price = 0;
  service.to_last_price = 0;

  image.value = null;
};
const onFileChange = (e) => {
  image.value = e.target.files[0];

};

const getServices = async () => {
    isLoading.value = true; // установите в true перед загрузкой
    const response = await axios.get("/api/service_cleaning");
    services.value = response.data;
    isLoading.value = false; // установите в false после загрузки
};

const addService = async () => {
  let formData = new FormData();
  formData.append("image", image.value);
  formData.append("service", service.service);
  formData.append("description", service.description);
  formData.append("from_price", service.from_price);
  formData.append("to_price", service.to_price);
  formData.append("from_last_price", service.from_last_price);
  formData.append("to_last_price", service.to_last_price);

  const response = await axios.post("/api/service_cleaning", formData, {
    headers: {
      "Content-Type": "multipart/form-data",
    },
  });

    notify({
        title: "Добавление",
        text: "Услуга успешно добавлена",
        type: "success",
    });

  services.value.push(response.data);
  service.service = "";
  service.description = "";
  service.from_price = 0;
  service.to_price = 0;
  service.from_last_price = 0;
  service.to_last_price = 0;
  image.value = null;
};

const editService = async (id) => {
  let formData = new FormData();
  formData.append("_method", "PUT");
  if (image.value != null) {
    formData.append("image", image.value);
  }
  formData.append("service", service.service);
  formData.append("description", service.description);
  formData.append("from_price", service.from_price);
  formData.append("to_price", service.to_price);
  formData.append("from_last_price", service.from_last_price);
  formData.append("to_last_price", service.to_last_price);
  const response = await axios.post(`/api/service_cleaning/${id}`, formData, {
    headers: {
      "Content-Type": "multipart/form-data",
    },
  });
  services.value = services.value.map((service) =>
    service.id === id ? response.data : service
  );

  notify({
        title: "Редактирование",
        text: "Услуга успешно отредактирована",
        type: "warn",
    });

  service.service = "";
  service.description = "";
  service.from_price = 0;
  service.to_price = 0;
  service.from_last_price = 0;
  service.to_last_price = 0;
  image.value = null;
};

const deleteService = async (id) => {
  try {
    const response = await axios.delete(`/api/service_cleaning/${id}`);
    if (response.status === 200) {
      console.log("Элемент успешно удален");
      notify({
            title: "Удаление",
            text: "Услуга успешно удалена",
            type: "error",
        });
      getServices();
    } else {
      console.log("Произошла ошибка при удалении элемента");
    }
  } catch (error) {
    console.error(error);
  }
};

const startEditing = (serviceData) => {
  editing.value = true;
  editingId.value = serviceData.id;
  Object.assign(service, serviceData); // Update properties of the 'service' object
  console.log(service);
};
const validateFields = () => {
  let isValid = true;

  // Проверка поля from_price
  console.log(service.from_price.toString().length);
  if (service.from_price.toString().length > 8) {
    errors.from_price =
      "Поле должно быть заполнено и не должно содержать более 8 символов";
    isValid = false;
  } else {
    errors.from_price = "";
  }

  // Проверка поля to_price
  if (service.to_price.toString().length > 8) {
    errors.to_price =
      "Поле должно быть заполнено и не должно содержать более 8 символов";
    isValid = false;
  } else {
    errors.to_price = "";
  }

  // Проверка поля from_last_price
  if (service.from_last_price.toString().length > 8) {
    errors.from_last_price =
      "Поле должно быть заполнено и не должно содержать более 8 символов";
    isValid = false;
  } else {
    errors.from_last_price = "";
  }

  // Проверка поля to_last_price
  if (service.to_last_price.toString().length > 8) {
    errors.to_last_price =
      "Поле должно быть заполнено и не должно содержать более 8 символов";
    isValid = false;
  } else {
    errors.to_last_price = "";
  }
  console.log(isValid);
  return isValid;
};
const saveService = async () => {
  if (validateFields()) {
    if (editing.value) {
      await editService(editingId.value);
      await getServices();
    } else {
      await addService();
      await getServices();
    }
    stopEditing();
  }
};

getServices();
</script>

<template>
  <div class="bg-transparent min-h-screen ">

    <div class="bg-slate-200">
        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
            <ul class="flex justify-center flex-wrap -mb-px">
                <li class="me-2">
                    <router-link to="/service/create"
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    :class="{ 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500': activeTab === 'services' }"
                    @click="activeTab = 'services'">Услуги</router-link>
                </li>
                <li class="me-2 ">
                    <router-link to="/gallary/create"
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    :class="{ 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500': activeTab === 'gallery' }"
                    @click="activeTab = 'gallery'">Галерея</router-link>
                </li>
            </ul>
        </div>
        <div class="container-lg lg:container mx-auto pt-10">
        <form
        @submit.prevent="saveService"
        class="max-w-xl mx-auto bg-white p-6 rounded shadow"
        id="form_service"
        >
        <h2 class="font-montserrat font-bold text-lg pb-4">{{ !editing ? "Добавить услугу" : "" }}</h2>
        <div class="flex justify-between items-start pb-6" v-if="editing">
            <div class="font-montserrat font-bold text-lg">
            {{ editing ? "Включен режим редактирования" : "" }}
            </div>
            <div>
            <button
                @click="stopEditing"
                type="button"
                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-400"
            >
                Выйти
            </button>
            </div>
        </div>

        <div
            v-if="errors.message"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
            role="alert"
        >
            <strong class="font-bold">ОШИБКА!</strong>
            <span class="block sm:inline">{{ errors.message }}</span>
        </div>
        <h2 class="font-montserrat font-bold text-lg pb-4" v-if="editing">
            #{{ editingId }}
        </h2>

        <p class="font-montserrat text-lg pb-2">Названиие услуги</p>
        <p class="font-montserrat text-xs" v-if="!editing">*Обязательное поле</p>
        <input
            v-model="service.service"
            placeholder="Введите название услуги"
            class="w-full px-4 py-2 mb-4 border rounded"
        />
        <p class="font-montserrat text-lg pb-2">Изображение услуги</p>
        <p class="font-montserrat text-xs" v-if="!editing">*Обязательное поле</p>
        <label class="mb-4 w-full">
            <input @change="onFileChange" class="block w-full text-sm text-gray-400 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file">
        </label>

        <p class="font-montserrat text-lg pb-2">Описание услуги</p>
        <p class="font-montserrat text-xs" v-if="!editing">*Обязательное поле</p>
        <textarea
            v-model="service.description"
            cols="7"
            placeholder="Описание"
            class="w-full px-4 py-2 mb-4 border rounded"
        ></textarea>
        <p class="font-montserrat text-lg pb-2">Стоимость услуги</p>
        <p class="font-montserrat text-xs" v-if="!editing">*Обязательное поле</p>
        <input
            v-model="service.from_price"
            type="number"
            placeholder="Текущая сумма от"
            class="w-full px-4 py-2 mb-4 border rounded"
        />
        <p class="font-montserrat text-lg pb-2">Стоимость услуги до</p>
        <p class="text-red-500">{{ errors.from_price }}</p>
        <input
            v-model="service.to_price"
            type="number"
            placeholder="Текущая сумма до"
            class="w-full px-4 py-2 mb-4 border rounded"
        />
        <!-- <p class="font-montserrat text-lg pb-2">Стоимость услуги старая цена</p>
        <p class="text-red-500">{{ errors.to_price }}</p>
        <input
            v-model="service.from_last_price"
            type="number"
            placeholder="Прошлая сумма от"
            class="w-full px-4 py-2 mb-4 border rounded"
        />
        <p class="font-montserrat text-lg pb-2">Стоимость услуги старая цена до</p>
        <p class="text-red-500">{{ errors.from_last_price }}</p>
        <input
            v-model="service.to_last_price"
            type="number"
            placeholder="Прошлая сумма до"
            class="w-full px-4 py-2 mb-4 border rounded"
        />
        <p class="text-red-500">{{ errors.from_last_price }}</p> -->
        <button
            type="submit"
            class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:bg-blue-300 cursor-not-allowed"
            :disabled="
            !editing &&
            (service.service === '' ||
                service.description === '' ||
                service.from_price == 0 ||
                service.from_price === '')
            "
        >
            {{ editing ? "Сохранить изменения" : "Добавить услугу" }}
        </button>
        </form>
        </div>
    </div>


    <div class="bg-slate-200 pb-44">
         <!-- Прелоадер -->
         <div v-if="isLoading" class="pt-10 h-30vh flex justify-center">
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
        <div v-for="service in services" :key="service.id" class="mt-10">
          <div class="relative mx-auto w-full" v-auto-animate>
            <div
              class="shadow p-4 rounded-lg bg-white relative inline-block duration-300 ease-in-out transition-transform transform hover:-translate-y-2 w-full"
            >
              <a href="#" class="">
                <div
                  class="flex justify-center relative rounded-lg overflow-hidden h-80"
                >
                  <div
                    class="transition-transform duration-500 transform ease-in-out hover:scale-110 w-full"
                  >
                    <div class="absolute inset-0 bg-gray-500">
                      <img
                        :src="service.url_image"
                        alt=""
                        class="h-full w-full object-cover"
                      />
                    </div>
                  </div>
                </div>

                <div class="mt-4">
                  <h2 class="font-montserrat font-bold text-lg pb-3">
                    #{{ service.id }}
                  </h2>
                  <h2
                    class="font-montserrat font-bold text-lg md:text-2xl text-gray-800"
                  >
                    {{ service.service }}
                  </h2>
                  <p
                    class="mt-2 font-montserrat text-sm text-gray-800 whitespace-pre-line"
                  >
                    {{ service.description }}
                  </p>
                </div>

                <div class="grid grid-cols-2 mt-8">
                  <div class="">
                    <p
                      class="inline-block font-semibold text-primary whitespace-nowrap leading-tight rounded-xl"
                    >
                      <span class="text-lg font-montserrat font-semibold"
                        >{{ service.to_price != 0 ?  service.from_price : 'от ' + service.from_price}}
                      </span>
                      <span class="text-lg font-montserrat font-semibold"
                        >{{ service.to_price != 0 ? ' - ' + service.to_price : '' }} руб.</span
                      >
                    </p>
                    <p
                      class="inline-block font-semibold text-primary whitespace-nowrap leading-tight rounded-xl"
                    >
                      <!-- <span class="text-lg font-montserrat font-semibold"
                        >{{ service.from_last_price }}
                      </span>
                      <span class="text-lg font-montserrat font-semibold"
                        >{{ service.to_last_price }}
                      </span> -->
                    </p>
                  </div>
                </div>
              </a>
              <div class="mt-4 flex justify-between">
                <a
                  href="#form_service"
                  @click="startEditing(service)"
                  v-auto-animate
                >
                  <button
                    class="inline-flex items-center px-4 py-2 bg-blue-600 transition ease-in-out delay-75 hover:bg-blue-700 text-white text-sm font-medium rounded-md hover:-translate-y-1 hover:scale-110"
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

                    Редактировать
                  </button>
                </a>

                <button
                  class="inline-flex items-center px-4 py-2 bg-red-600 transition ease-in-out delay-75 hover:bg-red-700 text-white text-sm font-medium rounded-md hover:-translate-y-1 hover:scale-110"
                  @click="deleteService(service.id)"
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


