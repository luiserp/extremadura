<template>
    <div class="card flex justify-center flex-col">
        <h3 class="text-xl font-semibold mb-4 text-center">{{ title }}</h3>

        <Chart type="pie" :data="chartData" :options="chartOptions" class="w-full md:w-[24rem]"/>
    </div>
</template>

<script setup>
import Chart from "primevue/chart";
import { ref, onMounted } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    labels: {
        type: Array,
        required: true
    },
    data: {
        type: Array,
        required: true
    }
});

onMounted(() => {
    chartData.value = setChartData();
    chartOptions.value = setChartOptions();
});

const chartData = ref();
const chartOptions = ref();

const setChartData = () => {
    const documentStyle = getComputedStyle(document.body);

    return {
        labels: props.labels,
        datasets: [
            {
                data: props.data,
                backgroundColor: [documentStyle.getPropertyValue('--p-cyan-500'), documentStyle.getPropertyValue('--p-orange-500'), documentStyle.getPropertyValue('--p-gray-500')],
                hoverBackgroundColor: [documentStyle.getPropertyValue('--p-cyan-400'), documentStyle.getPropertyValue('--p-orange-400'), documentStyle.getPropertyValue('--p-gray-400')]
            }
        ]
    };
};

const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--p-text-color');

    return {
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    color: textColor
                }
            }
        }
    };
};
</script>
