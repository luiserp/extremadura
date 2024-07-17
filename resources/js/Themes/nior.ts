import { definePreset } from "@primevue/themes";
import Aura from "@primevue/themes/aura";

export default definePreset(Aura, {
    semantic: {
        primary: {
            50: "{gray.50}",
            100: "{gray.100}",
            200: "{gray.200}",
            300: "{gray.300}",
            400: "{gray.400}",
            500: "{gray.500}",
            600: "{gray.600}",
            700: "{gray.700}",
            800: "{gray.800}",
            900: "{gray.900}",
            950: "{gray.950}",
        },
        colorScheme: {
            light: {
                primary: {
                    color: "{gray.950}",
                    inverseColor: "#ffffff",
                    hoverColor: "{gray.900}",
                    activeColor: "{gray.800}",
                },
                highlight: {
                    background: "{gray.950}",
                    focusBackground: "{gray.700}",
                    color: "#ffffff",
                    focusColor: "#ffffff",
                },
                border: {
                    color: "{gray.300}",
                },
                layout: {
                    background: "{gray.50}",
                    text: "{gray.900}",
                    border: "{gray.300}",

                    navigation: {
                        background: "{gray.50}",
                        text: "{gray.900}",
                    },

                    container: {
                        background: "#ffffff",
                        text: "{gray.900}",
                    },
                },
            },
            dark: {
                content: {
                    background: "{gray.800}",
                    hoverBackground: "{gray.700}",
                    borderColor: "{gray.700}",
                    color: "{text.color}",
                    hoverColor: "{text.hover.color}",
                },
                primary: {
                    color: "{gray.50}",
                    inverseColor: "{gray.950}",
                    hoverColor: "{gray.100}",
                    activeColor: "{gray.200}",
                },
                highlight: {
                    background: "{gray.800}",
                    focusBackground: "{gray.800}",
                    color: "{gray.800}",
                    focusColor: "{gray.800}",
                },
                border: {
                    color: "{gray.300}",
                },
                layout: {
                    background: "{gray.700}",
                    text: "{gray.50}",

                    navigation: {
                        background: "{gray.800}",
                        text: "{gray.50}",
                    },

                    container: {
                        background: "{gray.800}",
                        text: "{gray.50}",
                    },
                },
            },
        },
    },
});
