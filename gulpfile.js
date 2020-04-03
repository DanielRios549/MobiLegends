//Gulp tasks for sass

var gulp = require('gulp');
var sass = require('gulp-sass');
var maps = require('gulp-sourcemaps');

var current = 'admin';

//Run this task before the commit and mainly, before the push

function prodTask () {
    return gulp.src(current + '/css/sass/style.scss')
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(gulp.dest(current + '/css/'));
}

//Compile only style file with the same name, the imports will be added on file compilled
//Sass outputs: expanded, compact, compressed

function sassTask () {
    return gulp.src(current + '/css/sass/style.scss')
    .pipe(maps.init())
    .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
    .pipe(maps.write())
    .pipe(gulp.dest(current + '/css/'));
}

//Watch all files including all that are imported, than complile using 'sass' task

function watchTask () {
    gulp.watch(current + '/css/sass/**/*.scss', sassTask);
}

//Add the tasks to Gulp

exports.prod = prodTask;
exports.sass = sassTask;
exports.watch = watchTask;