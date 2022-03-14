const mix = require('laravel-mix');

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

mix.setPublicPath("../csp.hepsinisor.com");


mix.combine([
    "../csp.hepsinisor.com/assets/libs/jquery/jquery.min.js",
    "../csp.hepsinisor.com/assets/libs/bootstrap/js/bootstrap.bundle.min.js",
    "../csp.hepsinisor.com/assets/libs/metismenu/metisMenu.min.js",
    "../csp.hepsinisor.com/assets/libs/simplebar/simplebar.min.js",
    //"../csp.hepsinisor.com/assets/libs/axios/axios.min.js",
    "../csp.hepsinisor.com/assets/libs/node-waves/waves.min.js",
    "../csp.hepsinisor.com/assets/js/app.js",
    "../csp.hepsinisor.com/assets/js/custom/bootstrap-validation.js",
    "../csp.hepsinisor.com/assets/js/custom/custom.js",

], '../csp.hepsinisor.com/js/vendors.js');


mix.combine([
    "../csp.hepsinisor.com/assets/libs/datatables.net/js/jquery.dataTables.min.js",
    "../csp.hepsinisor.com/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js",
    "../csp.hepsinisor.com/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js",
    "../csp.hepsinisor.com/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js",
    "../csp.hepsinisor.com/assets/libs/jszip/jszip.min.js",
    "../csp.hepsinisor.com/assets/libs/pdfmake/build/pdfmake.min.js",
    "../csp.hepsinisor.com/assets/libs/pdfmake/build/vfs_fonts.js",
    "../csp.hepsinisor.com/assets/libs/datatables.net-buttons/js/buttons.html5.min.js",
    "../csp.hepsinisor.com/assets/libs/datatables.net-buttons/js/buttons.print.min.js",
    "../csp.hepsinisor.com/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js",
    "../csp.hepsinisor.com/assets/js/pages/datatables.init.js",
], "../csp.hepsinisor.com/js/merged-datatable.js");

mix.combine([
    "../csp.hepsinisor.com/assets/js/custom/bootstrap-validation.js",
    "../csp.hepsinisor.com/assets/js/custom/custom.js"
], "../csp.hepsinisor.com/js/merged-custom.js");


mix.js('resources/js/app.js', '/js')
    .js('resources/js/index.js', '/js/index.js')
    .js(['resources/js/src/alert-meeting.js'], '/js/alert-meeting.js')
    .sass('resources/sass/app.scss', '../csp.hepsinisor.com/css/main.css')
    .disableNotifications()
    .sourceMaps();