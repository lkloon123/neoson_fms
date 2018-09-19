let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .extract([
        'jquery', 'vue', 'admin-lte', 'axios', 'datatables.net', 'datatables.net-bs',
        'datatables.net-responsive-bs', 'epic-spinners', 'lodash', 'moment', 'sweetalert2',
        'v-click-outside', 'vee-validate', 'vue-awesome-notifications', 'vue-js-modal',
        'vue-multiselect', 'vue-plugin-load-script', 'vue-recaptcha', 'vue-router',
        'vuescroll', 'vuex', 'vue-smooth-dnd', 'vue-js-toggle-button', 'file-size',
        'vue-clipboard2', 'vue-picture-input', 'datatable-sorting-datetime-moment',
        'vue-chartjs', 'chart.js'
    ])
    .autoload({
        'jquery': ['jQuery', 'jquery', '$']
    })
    .sass('resources/assets/sass/vendor.scss', './public/css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .copyDirectory('resources/assets/images', 'public/images')
    .webpackConfig({
        output: {
            chunkFilename: 'js/chunks/[name].[chunkhash].js',
        },
    })
    .disableNotifications();

if (mix.inProduction()) {
    mix.version();
} else {
    mix.webpackConfig({devtool: "source-map"})
        .sourceMaps();
}
