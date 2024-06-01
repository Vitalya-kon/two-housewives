<script setup>
import { reactive, ref, watchEffect  } from 'vue';
import { notify } from "@kyvg/vue3-notification";
import MultiSelect from 'primevue/multiselect';
import InputMask from 'primevue/inputmask';
import InputText from 'primevue/inputtext';
import axios from 'axios'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import ImageSuccess from '/public/images/logo/pngwing.com (12).png'

const date = ref();

const order = ref(false)
const isSubmitted = ref(false);
const errors = ref({
      name: null,
      phone: null,
      description: null
    });
let selectedOptions = ref([]);
let services = reactive([])
let options = ref([])

let orderForm = reactive({
    name: "",
    phone: "",
    description: "",
});

const validateForm = () => {
      errors.value.name = orderForm.name ? null : 'Введите имя';
      errors.value.phone = orderForm.phone ? null : 'Введите ваш телефон';
      errors.value.description = orderForm.description ? null : 'Введите описание заказа';
    };

// watchEffect(validateForm);
const getServices = async () => {
    const response = await axios.get('/api/service_cleaning')
    services.value = response.data
    let serviceValues = services.value.map(serviceObject => serviceObject.service);
    options.value = [...serviceValues.map(serviceValue => ({ name: serviceValue, value: serviceValue })), { name: "Другое", value: "Другое" }];
}

const submitForm = async () => {
    isSubmitted.value = true;
    validateForm();
    if (errors.value.name == null && errors.value.phone == null && errors.value.description == null) {
        const formData = {
            name: orderForm.name,
            phone: orderForm.phone,
            selectedOptions: selectedOptions.value.map(option => option.name),
            description: orderForm.description,
            date: date.value
        }

        try {

            const response = await axios.post('/api/submit-form', formData)
            // Обработка успешной регистрации здесь
            console.log(response.data);
            order.value = true;
            isSubmitted.value = false;

            orderForm.name = "";
            orderForm.phone = "";
            orderForm.description = "";
            selectedOptions.value = [];
            date.value = "";
        } catch (error) {

        }
    }else{
        notify({
            title: "Заказать",
            text: "Заполните все обязательные поля",
            type: "error",
        });
    }

}
getServices().then(() => console.log(options.value));

</script>

<template>
  <section id="order_services_section" class="pb-20 lg:pb-36">
    <div class="lg:container mx-auto container-lg">
        <div class="max-w-xl mx-auto pt-16 lg:pt-36">
            <div class="text-center ">
                <div class="relative flex flex-col items-center">
                    <div
                        class="font-montserrat absolute hidden md:block -top-14 left-0 text-[120px] text-gray-400 font-bold opacity-10">
                        Заказать
                    </div>
                    <h1 class="text-teal-500 text-3xl lg:text-5xl font-montserrat font-bold  dark:text-white">
                        Заказать
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

        <div class="mt-3 lg:mt-10">
            <h3 class="text-sm lg:text-2xl font-montserrat text-center font-semibold">Оставьте заявку и мы свяжемся с вами в ближайшее время!</h3>
        </div>

      <div class="flex flex-col justify-center items-center gap-8  mt-12 lg:mt-20">
        <div data-aos="fade-up">
            <a href="https://wa.me/79512515269?text=" target="_blank">
                <button
            id="whatsapp"
            class="bg-transparent relative px-4 py-2 overflow-hidden flex items-center gap-3 text-lg font-semibold text-green-600 border border-green-600 rounded-full  transition-colors duration-300 ease-out text-center hover:text-white hover:border-green-600"
          >
            <svg width="40px" height="40px" viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVG_whatsapp" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>Whatsapp-color</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Whatsapp_svg" transform="translate(-700.000000, -360.000000)" fill="#67C15E"> <path d="M723.993033,360 C710.762252,360 700,370.765287 700,383.999801 C700,389.248451 701.692661,394.116025 704.570026,398.066947 L701.579605,406.983798 L710.804449,404.035539 C714.598605,406.546975 719.126434,408 724.006967,408 C737.237748,408 748,397.234315 748,384.000199 C748,370.765685 737.237748,360.000398 724.006967,360.000398 L723.993033,360.000398 L723.993033,360 Z M717.29285,372.190836 C716.827488,371.07628 716.474784,371.034071 715.769774,371.005401 C715.529728,370.991464 715.262214,370.977527 714.96564,370.977527 C714.04845,370.977527 713.089462,371.245514 712.511043,371.838033 C711.806033,372.557577 710.056843,374.23638 710.056843,377.679202 C710.056843,381.122023 712.567571,384.451756 712.905944,384.917648 C713.258648,385.382743 717.800808,392.55031 724.853297,395.471492 C730.368379,397.757149 732.00491,397.545307 733.260074,397.27732 C735.093658,396.882308 737.393002,395.527239 737.971421,393.891043 C738.54984,392.25405 738.54984,390.857171 738.380255,390.560912 C738.211068,390.264652 737.745308,390.095816 737.040298,389.742615 C736.335288,389.389811 732.90737,387.696673 732.25849,387.470894 C731.623543,387.231179 731.017259,387.315995 730.537963,387.99333 C729.860819,388.938653 729.198006,389.89831 728.661785,390.476494 C728.238619,390.928051 727.547144,390.984595 726.969123,390.744481 C726.193254,390.420348 724.021298,389.657798 721.340985,387.273388 C719.267356,385.42535 717.856938,383.125756 717.448104,382.434484 C717.038871,381.729275 717.405907,381.319529 717.729948,380.938852 C718.082653,380.501232 718.421026,380.191036 718.77373,379.781688 C719.126434,379.372738 719.323884,379.160897 719.549599,378.681068 C719.789645,378.215575 719.62006,377.735746 719.450874,377.382942 C719.281687,377.030139 717.871269,373.587317 717.29285,372.190836 Z" id="Whatsapp"> </path> </g> </g> </g></svg>
            <span class="text-sm lg:text-lg font-montserrat">Напишите нам в Whatsapp</span>
          </button>
            </a>

        </div>
        <div data-aos="fade-up">
            <a href="https://t.me/+79512515269" target="_blank">
                <button
                    id="telegram"
                    class="bg-transparent relative px-4 py-2 flex gap-3 items-center text-lg font-semibold text-teal-500 border border-teal-600 rounded-full overflow-hidden transition-colors duration-300 ease-out text-center hover:text-white hover:border-teal-600"
                >
                <svg width="40px" height="40px"  fill="#40B3E0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="m12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12c0-6.627-5.373-12-12-12zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"></path></g></svg>
                    <span class="text-sm lg:text-lg font-montserrat">Напишите нам в Telegram</span>
                </button>
            </a>
        </div>
        <div data-aos="fade-up">
            <a href="https://vk.com/im?media=&sel=-224392080" target="_blank">
                <button
            id="vk"
            class="bg-transparent relative px-4 py-2 flex gap-3  items-center text-lg font-semibold text-blue-600 border border-blue-600 rounded-full overflow-hidden transition-colors duration-300 ease-out text-center hover:text-white hover:border-blue-600"
          >
            <svg width="40px" height="40px" viewBox="0 0 100 100" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#1C64F2"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier">  <g id="Layer_1"></g> <g id="Layer_2"> <g> <g> <path class="st106" d="M97.471,64.602c0,0,0-29.087,0-29.087c0-26.568-6.273-32.889-32.849-32.889 C-0.368,2.209,2.193-0.434,2.629,64.553c0,26.568,6.273,32.889,32.849,32.889h22.059C85.773,97.929,98.181,95.988,97.471,64.602z M79.195,70.282h-6.916c-2.618,0-3.408-2.124-8.101-6.815c-4.1-3.951-5.829-4.445-6.866-4.445c-1.433,0-1.828,0.395-1.828,2.37 v6.222c0,1.679-0.543,2.667-4.94,2.667c-7.311,0-15.362-4.445-21.093-12.642c-8.595-12-10.917-21.087-10.917-22.914 c0-1.037,0.395-1.976,2.371-1.976h6.916c1.778,0,2.42,0.79,3.112,2.617c2.835,9.294,12.546,24.759,12.695,15.852 c0,0,0-10.173,0-10.173c-0.296-4.642-2.766-5.037-2.766-6.716c0-0.741,0.692-1.58,1.778-1.58h10.867 c1.482,0,1.976,0.741,1.976,2.518v13.729c0.188,3.292,2.236,1.997,4.298-0.148c4.989-5.531,8.496-14.124,8.496-14.124 c0.445-1.037,1.235-1.975,3.013-1.975h6.916c2.075,0,2.519,1.037,2.075,2.519c-0.84,4.049-9.287,15.901-9.287,15.951 c-0.741,1.136-1.037,1.729,0,3.062C72.985,56.762,87.493,69.864,79.195,70.282z"></path> </g> </g> </g> </g></svg>
            <span class="text-sm lg:text-lg font-montserrat">Напишите нам в Vk</span>
          </button>
            </a>

        </div>
      </div>

      <div class="text-center font-montserrat text-2xl mt-14">
        или
      </div>

      <div
        class="min-h-screen  py-6 flex flex-col  sm:py-12"
      >
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
          <form
            v-if="!order" @submit.prevent="submitForm" class="relative px-4 py-8 lg:py-10 bg-white  shadow rounded-3xl sm:p-10" data-aos="flip-left">
            <div class="max-w-md mx-auto lg:w-96 w-full">
              <div class="flex items-center justify-center space-x-5">
                <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
                  <h2 class="leading-relaxed font-montserrat text-center">Заполните форму</h2>
                </div>
              </div>
              <div class="divide-y divide-gray-200">
                <div  class="py-8 text-sm lg:text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7 font-montserrat">
                  <div class="flex flex-col ">
                    <label class="leading-loose">Ваше имя*</label>
                    <p v-if="errors.name" class="text-red-500 text-xs font-montserrat pb-1">{{ errors.name }}</p>
                    <InputText type="text" v-model="orderForm.name" placeholder="Имя" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" />
                  </div>

                  <div class="flex flex-col ">
                  </div>
                    <div class="flex flex-col m-0">
                        <label for="phone" class="leading-loose">Ваш телефон*</label>
                        <p v-if="errors.phone" class="text-red-500 text-xs font-montserrat pb-1">{{ errors.phone }}</p>
                        <InputMask placeholder="Телефон" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" id="phone" v-model="orderForm.phone" mask="+7 (999) 999-9999"  />
                    </div>
                  <div class="flex flex-col">
                    <label class="leading-loose">Выберите нужные услуги</label>
                    <MultiSelect v-model="selectedOptions" display="chip" :options="options" optionLabel="name" placeholder="Услуги"
                    :maxSelectedLabels="3" class="w-full md:w-20rem border border-gray-300 rounded-md px-4 font-montserrat text-md" />
                  </div>
                  <div class="flex flex-col">
                      <label class="leading-loose">Опишите характер заказа*</label>
                      <p v-if="errors.description" class="text-red-500 text-xs font-montserrat pb-1">{{ errors.description }}</p>

                      <div class="relative focus-within:text-gray-600 text-gray-400">
                        <textarea v-model="orderForm.description" placeholder="Описание" rows="7" class="pr-2 pl-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"></textarea>
                      </div>
                    </div>
                  <div class="flex items-center space-x-4">
                    <div class="flex flex-col">
                      <label class="leading-loose">Назначьте дату</label>
                      <div class="relative focus-within:text-gray-600 text-gray-400" >
                        <VueDatePicker v-model="date" locale="ru" auto-apply :enable-time-picker="false" class="font-montserrat" placeholder="Выберите дату"></VueDatePicker>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="pt-4 flex items-center space-x-4">
                  <button
                    type="submit"
                    class="bg-blue-500 text-sm lg:text-lg flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none hover:bg-blue-600" >Создать заявку
                  </button>
                </div>
              </div>
            </div>
          </form>
          <div v-else class="relative px-4 py-8 lg:py-10 bg-white  shadow rounded-3xl sm:p-10" data-aos="flip-left">
            <div class="max-w-md mx-auto lg:w-96 w-full ">
                <div class="flex justify-center mt-16 mb-10">
                    <img width="120" height="120" :src="ImageSuccess" alt="success">
                </div>
                <div class="py-24 mb-44">
                    <h2 class="text-center text-3xl text-gray-700 font-montserrat font-bold">Спасибо за заявку!</h2>
                    <p class="text-center text-slate-500 font-montserrat py-6">Мы свяжемся с вами в ближайшее время</p>
                </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<style scoped>
#whatsapp::before,
#telegram::before,
#vk::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  border-radius: 50%;

  left: 0;
  transition: box-shadow 0.5s ease-out;
  z-index: -1;
}
#whatsapp:hover::before,
#telegram:hover::before,
#vk:hover::before {
  box-shadow: inset 0 0 0 10em rgb(40, 144, 241);
}
#whatsapp::before{
    width: 24rem;
    height: 20rem;
}
#telegram::before{
    width: 24rem;
    height: 20rem;
}
#vk::before{
    width: 20rem;
    height: 18rem;
}
#whatsapp:hover::before{
    box-shadow: inset 0 0 0 10em rgb(124, 191, 119);
}
#vk:hover::before{
    box-shadow: inset 0 0 0 10em rgb(38, 79, 191);
}
#telegram:hover::before{
    box-shadow: inset 0 0 0 10em rgb(38, 163, 191);
}

#whatsapp:hover #Whatsapp_svg{
    fill:white;
}
#vk:hover svg{
    fill:white;
}
#telegram:hover svg{
    fill:white;
}
</style>
