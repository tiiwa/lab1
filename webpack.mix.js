let mix = require("laravel-mix");

var LiveReloadPlugin = require("webpack-livereload-plugin");
var StylelintPlugin = require("stylelint-webpack-plugin");


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
if (!mix.inProduction()) {
	mix.webpackConfig({
		devtool: "source-map",
		plugins: [
			new LiveReloadPlugin(),
			new StylelintPlugin({
				files: ["./resources/**/*.vue", "./resources/**/*.js",
					"./resources/**/*.css"  , "./resources/**/*.scss" ]
			}),
		]
	}).sourceMaps();
}


mix.options({
	extractVueStyles: true,
	globalVueStyles: "resources/sass/_variables.scss",
})
	.js("resources/js/app.js", "public/js")
	.sass("resources/sass/app.scss", "public/css");
