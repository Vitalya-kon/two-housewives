<script setup>
    import { onMounted } from "vue";
    import AOS from "aos";

    onMounted(() => {
        AOS.init();
    })
</script>
<template>
    <section class="container-lg lg:container mx-auto  flex items-end">
        <div class="" data-aos="fade-up">
            <h1 class="text-3xl lg:text-5xl font-montserrat text-white font-semibold flex flex-col gap-1 lg:gap-3 mb-10 ">
                <span>
                    Клининговые услуги
                </span>
                <span class="text-teal-500">
                    "Две хозяюшки"
                </span>
            </h1>
            <h3 class=" mt-10 table-cell">
                <span class="text-sm lg:text-xl text-white font-montserrat">Мы работаем в <strong >г. Копейск, г. Челябинск, г. Коркино.</strong></span>
                <br>
                <span class="text-sm lg:text-xl text-white font-montserrat"> В нашей компании можно сделать заявку на оказание клининговых услуг : </span>
                <span class="text-sm lg:text-xl text-white font-montserrat">химчистка диванов и другой мягкой мебели, матрасов, подушек, обработка паром.</span>
                <span class="text-sm lg:text-xl text-white font-montserrat"> Мы используем только <strong>качественную, профессиональную химию</strong> и только <strong>профессиональное оборудование Karcher.</strong></span>
            </h3>
            <a href="#order_services_section">
                <button class="mt-10 cursor-pointer transition-all bg-green-500 text-white px-6    py-2 rounded-lg
                        border-green-600
                        border-b-[4px] hover:brightness-110 hover:-translate-y-[1px] hover:border-b-[6px]
                        active:border-b-[2px] active:brightness-90 active:translate-y-[2px]">
                        Заказать услуги
                </button>
            </a>
        </div>
    </section>

</template>

<style scoped>
h3{
    width: 900px;
}
section{
    height: 80vh;
}
@media (min-height: 640px) {
    section {
        height: 80vh;
    }
}

@media (min-height: 800px) {
    section {
        height: 60vh;
    }
}
</style>
