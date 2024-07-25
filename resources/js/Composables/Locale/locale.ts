import { loadLanguageAsync } from "laravel-vue-i18n";
import { onMounted, ref } from "vue";

const language = ref(localStorage.getItem("locale") || "en");

export const useLocale = () => {
    onMounted(() => {
        loadLanguageAsync(language.value);
    });

    const changeLanguage = (lang: string) => {
        language.value = lang;
        loadLanguageAsync(language.value);
        localStorage.setItem("locale", language.value);
        document.cookie = "locale=" + language.value + ";path=/";
    };

    return {
        language,
        changeLanguage,
    };
};
