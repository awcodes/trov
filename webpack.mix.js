const mix = require("laravel-mix");

mix.js("js/trov.js", "resources/js")
    .sass("scss/trov.scss", "resources/css", {}, [require("tailwindcss")])
    .options({
        processCssUrls: false
    })
    .copy(
        [
            "node_modules/@fortawesome/fontawesome-free/js/fontawesome.min.js",
            "node_modules/@fortawesome/fontawesome-free/js/solid.min.js"
        ],
        "resources/js"
    );
