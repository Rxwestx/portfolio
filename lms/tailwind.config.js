import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                blade: {
                    dark: "#55A603",
                    main: "#9AD914",
                    soft: "#E2F266",
                    pale: "#E9F2A0",
                    neon: "#F2F0D5",
                },
            },
        },
    },
    safelist: [
        "bg-green-100",
        "bg-green-500",
        "bg-blade-dark",
        "bg-blade-main",
        "bg-blade-soft",
        "bg-blade-pale",
        "bg-blade-neon",
        "focus:ring-blade-dark",
        "focus:border-blade-dark",
    ],

    plugins: [forms],
};
