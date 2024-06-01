<script setup>
    import { onMounted, toRefs } from "vue";
    import { initFlowbite } from 'flowbite'
    import { Dropdown, Tooltip, Menu, vTooltip } from 'floating-vue'
    import AOS from "aos";

    const props = defineProps({
        id: Number,
        service: String,
        url_image: String,
        description: String,
        from_price: Number,
        to_price: Number,
        from_last_price: Number,
        to_last_price: Number
    })

    const { service, url_image, description, from_price, last_price, from_last_price, to_last_price } = toRefs(props)

    onMounted(() => {
        AOS.init();
        initFlowbite();
    })
</script>
<template>
    <div :id="'tooltip-light_' + id"  role="tooltip" class="absolute z-50 w-96 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip font-montserrat whitespace-pre-line">
        {{ description }}
    </div>
    <div class="relative mx-auto w-full" data-aos="fade-up">
      <div

        class="relative inline-block duration-300 ease-in-out transition-transform transform hover:-translate-y-2 w-full"
      >
        <div class="shadow p-4 rounded-lg bg-white">
          <div class="flex justify-center relative rounded-lg overflow-hidden h-80">
            <div
              class="transition-transform duration-500 transform ease-in-out hover:scale-110 w-full"
            >
              <div class="absolute inset-0 bg-gray-500 ">
                <img :src="url_image" alt="" class="h-full w-full object-cover" />
              </div>
            </div>
          </div>

          <div class="mt-4">
            <h2 class="font-montserrat font-bold text-lg md:text-2xl text-gray-800 line-clamp-2">
              {{ service }}
            </h2>

            <p :data-tooltip-target="'tooltip-light_' + id" data-tooltip-placement="top" class="cursor-pointer mt-2 font-montserrat text-sm text-gray-800 lg:line-clamp-3 whitespace-pre-line z-50">
              {{ description }}
            </p>



          </div>

          <div class="grid grid-cols-2 mt-8">


            <div class="">
              <p class="inline-block font-semibold text-primary whitespace-nowrap leading-tight rounded-xl">
                <span class="text-lg font-montserrat font-semibold">{{ to_price != 0 ?  from_price : 'от ' + from_price}}</span>
                <span class="text-lg font-montserrat font-semibold">  {{ to_price != 0 ? ' - ' + to_price : '' }} руб.</span>
              </p>
            </div>
          </div>
          <div class="mt-3 flex flex-col">
                <span class="text-xs font-montserrat text-yellow-500">* В стоимость услуги не включен трансфер</span>
                <a class="text-sm mt-1 font-montserrat text-blue-800 underline" href="/documents/Usloviya.odt" target="_blank">Узнать условия</a>
            </div>
          <div class="mt-4 flex justify-end ">
            <a href="#order_services_section" class="grow lg:grow-0">
                <button class="font-montserrat inline-block bg-gradient-to-r from-teal-500 to-teal-700 hover:from-teal-600 hover:to-teal-800 text-white font-bold py-2 px-6 rounded-full  transform transition-all duration-500 ease-in-out hover:scale-110 hover:brightness-110 hover:animate-pulse active:animate-bounce w-full lg:w-auto">
                    Заказать
                </button>
            </a>

          </div>

        </div>
      </div>
    </div>

</template>
