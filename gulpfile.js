var gulp = require('gulp');
var less = require('gulp-less');
var scss = require('gulp-sass');
var uglifycss = require('gulp-uglifycss');
var uglifyjs = require('gulp-uglify');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var del = require('del');

gulp.task('default', ['less', 'js-bs', 'js', 'bs-select', 'scss', 'css']);

gulp.task('less', function(){

    var buildLess = gulp.src([
        'resources/bower_components/bootstrap/less/bootstrap.less',
        'resources/bower_components/bootstrap-select/less/bootstrap-select.less'
    ])
        .pipe(less())
        .pipe(uglifycss())
        //.pipe(concat('bootstrap.css'))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/css'));

    var buildFonts = gulp.src('resources/bower_components/bootstrap/fonts/*')
        .pipe(gulp.dest('public/fonts'));
});

gulp.task('scss', function(){
    return gulp.src('resources/assets/sass/app.scss')
        .pipe(scss())
        .pipe(gulp.dest('public/css'));
});

gulp.task('js-bs', function(){
    return gulp.src('resources/bower_components/bootstrap/js/*.js')
        .pipe(concat('bootstrap.js'))
        .pipe(uglifyjs())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/js'));
});

gulp.task('bs-select', function(){

     return gulp.src('resources/bower_components/bootstrap-select/js/bootstrap-select.js')
        .pipe(uglifyjs())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/js'));
});

gulp.task('js', function(){
    return gulp.src([
        'resources/bower_components/jquery/dist/jquery.min.js',
        'resources/bower_components/fullcalendar/dist/fullcalendar.min.js',
        'resources/bower_components/fullcalendar/dist/locale/ru.js'
    ])
        .pipe(gulp.dest('public/js'));
});

gulp.task('css', function(){
    return gulp.src([
        'resources/bower_components/fullcalendar/dist/fullcalendar.min.css',
        'resources/bower_components/fullcalendar/dist/fullcalendar.print.min.css'
    ])
        .pipe(gulp.dest('public/css'));
});

gulp.task('watch', function(){
   gulp.watch('resources/bower_components/bootstrap/less/*.less', ['less']);
});

gulp.task('clean-js', function(){
    del(['public/js/*', '!public/js/app.js']);
})
