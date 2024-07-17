import { ref, watch } from "vue";

const colorScheme = ref(localStorage.getItem("colorScheme") || "light");

export const useColorScheme = () => {

    const toggleColorScheme = () => {
        colorScheme.value = colorScheme.value === "light" ? "dark" : "light";
        localStorage.setItem("colorScheme", colorScheme.value);
    };

    watch(colorScheme, () => {
        const element = document.querySelector("html");
        if (colorScheme.value === "dark") {
            element!.classList.add("my-app-dark");
        } else {
            element!.classList.remove("my-app-dark");
        }
    }, {
        immediate: true,
    });

    return {
        colorScheme,
        toggleColorScheme,
    };
};
