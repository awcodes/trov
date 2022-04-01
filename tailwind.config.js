const colors = require("tailwindcss/colors");

module.exports = {
    content: [
        "./resources/views/**/*.blade.php",
        "./src/**/*.php",
        "../../vendor/filament/**/*.blade.php",
    ],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                gray: colors.slate,
                danger: colors.rose,
                primary: colors.cyan,
                success: colors.emerald,
                warning: colors.orange,
            },
        },
        borderRadius: {
            none: "0px",
            sm: "0.125rem",
            DEFAULT: "0.125rem",
            md: "0.25rem",
            lg: "0.375rem",
            xl: "0.625rem",
            "2xl": ".875rem",
            "3xl": "1.3755rem",
            full: "9999px",
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
