var siteName = 'brand-nspca';
var user = 'davidstanley';

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const concat = require('gulp-concat');
const terser = require('gulp-terser');
const browserSync = require('browser-sync').create();
const plumber = require("gulp-plumber");
const webpack = require("webpack-stream");

// compile scss into css

function style(){
  //1. where is my scss
  return gulp.src(
    './src/scss/main.scss'
    )

  //2. pass that file through the sass compiler
  .pipe(sass())

  //3. Autoprefixer
  .pipe(autoprefixer())

  //4. Clean and minify CSS
  // .pipe(cleanCSS({compatibility: 'ie8'}))

  //5. Where do I save the compiled css
  .pipe(gulp.dest('./dist/css/'))

  //6. Stream changes to all browsers
  .pipe(browserSync.stream());
}

//BrowserSync

function watch() {
  browserSync.init({
    proxy: 'https://' + siteName + '.test',
    host: siteName + '.test',
    open: 'external',
    port: 8000,
    https: {
        key:
            '/Users/' +
            user +
            '/.config/valet/Certificates/' +
            siteName +
            '.test.key',
        cert:
            '/Users/' +
            user +
            '/.config/valet/Certificates/' +
            siteName +
            '.test.crt'
    }
  });
  gulp.watch('./src/**/*.scss', style);
  gulp.watch('/*.php').on('change', browserSync.reload);
  gulp.watch('/page-templates/*.php').on('change', browserSync.reload);
  gulp.watch('./src/*.js').on('change', browserSync.reload);
}


//Combine JS

function combineScripts (){
  //.1 Find JS files
  return gulp.src([
    './src/js/all.js'
    ])

  .pipe(plumber())

  //2. Clean
  .pipe(concat('all.min.js'))
  .pipe(webpack( require('./webpack.config.js') ))
  .pipe(terser(({
    keep_fnames: true,
    mangle: false
  })))
  //3. Dest
  .pipe(gulp.dest('./dist/js/')); 
  
}




exports.style = style;
exports.watch = watch;
exports.combineScripts = combineScripts;


exports.default = gulp.series(style, combineScripts);




