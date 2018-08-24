//gulpfile.js

var gulp = require('gulp');
var sass = require('gulp-sass');

//style paths
var sassFiles = 'public/scss/*.scss',
    cssDest = 'public/css/';

gulp.task('default', function () {
    gulp.src(sassFiles)
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(cssDest));
});

gulp.task('watch', function () {
    gulp.watch(sassFiles, ['default']);
});