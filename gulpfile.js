var gulp = require('gulp');
var stylus = require('gulp-stylus');
var autoprefixer = require('gulp-autoprefixer');
var notify = require('gulp-notify');
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var concat = require('gulp-concat');


gulp.task('default', ['stylus', 'js'], function() {
    gulp.watch('src/stylus/**/*.styl', ['stylus']);
    gulp.watch('src/js/**/*.js', ['js']);
});


gulp.task('stylus', function() {
    gulp.src('src/stylus/*.styl')
    .pipe(stylus({
        'include css': true,
        'compress': true
    }))
    .pipe(autoprefixer('last 15 version'))
    .on('error', function(err) { console.log(err.message); })
    .pipe(gulp.dest('./css/'));
});


gulp.task('js', function() {
  gulp.src('src/js/**/*.js')
  .pipe(jshint())
  .pipe(jshint.reporter('default'))
  .pipe(uglify())
  .pipe(gulp.dest('./js/'));
});