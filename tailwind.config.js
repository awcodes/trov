const defaultTheme = require("tailwindcss/defaultTheme");
const plugin = require("tailwindcss/plugin");

module.exports = {
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true
    },
    purge: ["./resources/views/**/*.php"],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Ubuntu", ...defaultTheme.fontFamily.sans]
            }
        },
        customForms: theme => ({
            default: {
                "input, textarea, select, checkbox, radio": {
                    borderColor: theme("colors.gray.400")
                }
            }
        })
    },
    variants: {},
    plugins: [
        require("@tailwindcss/custom-forms"),
        plugin(function({ addBase, theme }) {
            const baseStyles = {
                a: {
                    color: "#007bff"
                },
                "a:hover, a:focus": {
                    color: "#0056b3",
                    textDecoration: "underline"
                },
                "a.danger": {
                    color: theme("colors.red.500")
                },
                "a.danger:hover, a.danger:focus": {
                    color: theme("colors.red.400"),
                    textDecoration: "underline"
                }
            };

            addBase(baseStyles);
        })
    ]
};
