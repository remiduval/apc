const mix = require('laravel-mix');
var fs = require('fs');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// Copy to public
mix.copyDirectory('resources/svg/',						'public/svg');
mix.copyDirectory('resources/favicons',					'public/favicons');
mix.copyDirectory('resources/fonts',					'public/fonts');

// CSS / Stylus
mix.stylus('resources/css/style.styl',					'public/css');
mix.stylus('resources/css/cp.styl',						'public/vendor/app/css');
processAllFiles('styles',		'resources/css/vendor/',	'public/css/vendor/');


// Scripts / JS
processAllFiles('scripts',		'resources/js/site/',		'public/js/');
processAllFiles('scripts',		'resources/js/vendor/',		'public/js/vendor/');


// If production
if (mix.inProduction()) {
	mix.version();
	//mix.purgeCss({ enabled: true }); // remove some css custom properties
} else {
	mix.browserSync({
		proxy: process.env.APP_URL,
		files: [
			'resources/views/**/*.html', 
			'public/**/*.(css|js)', 
		],
		// Option to open in non default OS browser.
		// browser: "firefox",
		notify: false
	});
}

/*
 |--------------------------------------------------------------------------
 | Statamic Control Panel
 |--------------------------------------------------------------------------
 |
 | Feel free to add your own JS or CSS to the Statamic Control Panel.
 | https://statamic.dev/extending/control-panel#adding-css-and-js-assets
 |
 */

// mix.js('resources/js/cp.js', 'public/vendor/app/js')
//    .postCss('resources/css/cp.css', 'public/vendor/app/css', [
//     require('postcss-import'),
//     require('tailwindcss'),
//     require('postcss-nested'),
//     require('postcss-preset-env')({stage: 0})
// ])

function processAllFiles(action, inputFolder, outputFolder) {
	var files = fs.readdirSync(inputFolder);
	for(var i = 0; i < files.length; i++){
		switch (action) {
			case 'scripts':
				mix.scripts(inputFolder + files[i], outputFolder + files[i]);
				break;
			case 'styles':
				mix.styles(inputFolder + files[i], outputFolder + files[i]);
				break;
			case 'stylus':
				mix.styles(inputFolder + files[i], outputFolder + files[i]);
		}
	}
}