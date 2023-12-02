import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: "#2B2D42",
                    dark: "#1D1F2F",
                    light: "#3C3F58",
                },
                secondary: {
                    DEFAULT: "#8D99AE",
                    dark: "#6F7D9B",
                    light: "#AEB6BF",
                },
                accent: {
                    DEFAULT: "#EF233C",
                    dark: "#D90429",
                    light: "#FF2E63",
                },
                background: {
                    DEFAULT: "#93D2DF",
                    dark: "#8DB7BF",
                    light: "#9AEEFF",
                },
            },
        },
    },

    /* COLOR PALETTE PRIMARY
    #9AEEFF
    154, 238, 255
    #97E0EF
    151, 224, 239
    #93D2DF
    147, 210, 223
    #90C5CF
    144, 197, 207

    DARK
    #8DB7BF
    141, 183, 191
    #89A9AF
    137, 169, 175
    #869B9F
    134, 155, 159
    #838D8F
    131, 141, 143
    */

    plugins: [forms],
};
