const colors = require("tailwindcss/colors");

module.exports = {
  content: ["./resources/views/**/*.blade.php", "./src/**/*.php"],
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
  },
  corePlugins: {
    preflight: false,
  },
  plugins: [require("@tailwindcss/forms"), require("@tailwindcss/typography")],
};
