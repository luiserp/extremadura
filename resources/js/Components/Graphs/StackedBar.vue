<template>
    <div class="card">
        <h3 class="text-xl font-semibold mb-4 text-center">{{ title }}</h3>
        <Chart type="bar" :data="chartData" :options="chartOptions" class="h-[30rem]" />
    </div>
</template>

<script setup>
import Chart from 'primevue/chart';
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
    const documentStyle = getComputedStyle(document.documentElement);

    return {
        labels: props.labels,
        datasets: props.data.map((data, index) => {
            return {
                type: 'bar',
                label: data.name,
                backgroundColor: documentStyle.getPropertyValue(`--p-red-${9999 - (index * 500)}`),
                data: data.data
            };
        })
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--p-text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--p-text-muted-color');
    const surfaceBorder = documentStyle.getPropertyValue('--p-content-border-color');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            tooltips: {
                mode: 'index',
                intersect: false
            },
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                stacked: true,
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            },
            y: {
                stacked: true,
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            }
        }
    };
}
</script>
