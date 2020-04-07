const mix = require('laravel-mix');
const { config } = require('./webpack.mix.config');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


mix

    .setPublicPath('./public/build')
    .webpackConfig(config.webpack)
    .options({
        processCssUrls: false,
        extractVueStyles: true,
        globalVueStyles: 'resources/assets/scss/includes/index.scss',
    })

    // Build Javascript
    .js('resources/assets/js/app.js', 'js')

    // Extract libraries to vendor.js file
    .extract([
        'vue',
    ])

    .copyDirectory('resources/assets/images', 'public/build/images')

    // Build Stylesheets
    .sass('resources/assets/scss/global/index.scss', 'css', config.sass)

    // Build sourcemaps
    .sourceMaps()

    // Start BrowserSync
    .browserSync(config.browserSync);


// Version Files
if (mix.inProduction()) {
    mix.version();
}
