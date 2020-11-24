const defaultTheme = require("tailwindcss/defaultTheme");
const plugin = require("tailwindcss/plugin");

module.exports = {
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true
    },
    purge: false,
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
    variants: {
        accessibility: ["responsive", "focus"],
        alignContent: ["responsive"],
        alignItems: ["responsive"],
        alignSelf: ["responsive"],
        appearance: [],
        backgroundColor: ["hover", "focus"],
        backgroundOpacity: [],
        backgroundPosition: [],
        backgroundRepeat: [],
        backgroundSize: [],
        borderColor: ["hover", "focus"],
        borderOpacity: [],
        borderRadius: [],
        borderStyle: [],
        borderWidth: [],
        boxShadow: [],
        container: ["responsive"],
        cursor: [],
        display: ["responsive"],
        divideColor: [],
        divideWidth: [],
        fill: [],
        flex: ["responsive"],
        flexDirection: ["responsive"],
        flexGrow: ["responsive"],
        flexShrink: ["responsive"],
        flexWrap: ["responsive"],
        fontFamily: [],
        fontSmoothing: [],
        fontSize: ["responsive"],
        fontStyle: ["responsive"],
        fontWeight: ["responsive", "hover", "focus"],
        height: ["responsive"],
        inset: ["responsive"],
        justifyContent: ["responsive"],
        letterSpacing: [],
        lineHeight: ["responsive"],
        listStylePosition: [],
        listStyleType: [],
        margin: ["responsive"],
        maxHeight: ["responsive"],
        maxWidth: ["responsive"],
        minHeight: ["responsive"],
        minWidth: ["responsive"],
        opacity: ["disabled"],
        order: ["responsive"],
        outline: ["focus"],
        overflow: ["responsive"],
        padding: ["responsive"],
        placeholderColor: ["focus"],
        placeholderOpacity: ["focus"],
        pointerEvents: ["disabled"],
        position: ["responsive"],
        space: ["responsive"],
        textAlign: ["responsive"],
        textColor: ["hover", "focus"],
        textDecoration: ["hover", "focus"],
        textTransform: [],
        visibility: ["responsive"],
        whitespace: [],
        width: ["responsive"],
        wordBreak: ["responsive"],
        zIndex: [],
        transform: [],
        transformOrigin: [],
        scale: ["hover", "focus"],
        rotate: ["hover", "focus"],
        translate: ["hover", "focus"],
        transitionProperty: ["responsive"],
        transitionTimingFunction: ["responsive"],
        transitionDuration: ["responsive"],
        transitionDelay: ["responsive"],
        animation: [],
        verticalAlign: ["responsive"]
    },
    corePlugins: {
        backgroundAttachment: false,
        backgroundClip: false,
        backgroundImage: false,
        borderCollapse: false,
        boxSizing: false,
        clear: false,
        divideOpacity: false,
        divideStyle: false,
        float: false,
        gap: false,
        gradientColorStops: false,
        gridAutoFlow: false,
        gridTemplateColumns: false,
        gridColumn: false,
        gridColumnStart: false,
        gridColumnEnd: false,
        gridTemplateRows: false,
        gridRow: false,
        gridRowStart: false,
        gridRowEnd: false,
        objectFit: false,
        objectPosition: false,
        overscrollBehavior: false,
        resize: false,
        skew: false,
        stroke: false,
        strokeWidth: false,
        tableLayout: false,
        textOpacity: false,
        userSelect: false
    },
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
