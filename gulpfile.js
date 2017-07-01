var gulp = require('gulp');
var less = require('gulp-less');
var uglifycss = require('gulp-uglifycss');
var uglifyjs = require('gulp-uglify');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var del = require('del');

gulp.task('default', function(){
    // 
});

gulp.task('less', function(){
    
    var buildLess = gulp.src('resources/bower_components/bootstrap/less/bootstrap.less')
        .pipe(less())
        .pipe(uglifycss())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/css'));
        
    var buildFonts = gulp.src('resources/bower_components/bootstrap/fonts/*')
        .pipe(gulp.dest('public/fonts'));
});

gulp.task('js', function(){
    return gulp.src('resources/bower_components/bootstrap/js/*.js')
        .pipe(concat('bootstrap.js'))
        .pipe(uglifyjs())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/js'));
});

gulp.task('watch', function(){
   gulp.watch('resources/bower_components/bootstrap/less/*.less', ['less']);
});

gulp.task('clean-js', function(){
    del(['public/js/*', '!public/js/app.js']);
})
