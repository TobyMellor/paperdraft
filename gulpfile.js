var gulp      = require('gulp'),
    plumber   = require('gulp-plumber'),
    rename    = require('gulp-rename'),
    uglify    = require('gulp-uglify'),
    concat    = require('gulp-concat');

gulp.task('scripts', function() {
    gulp.src(['resources/assets/js/pages/dashboard/**/*.js'])
        .pipe(plumber())
        .pipe(rename({
            suffix: '.min'
        }))
        // .pipe(uglify())
        .pipe(concat('dashboard.min.js'))
        .pipe(gulp.dest('./public/assets/js/PaperDraft/'));
});

gulp.task('watch', function() {
    gulp.watch('resources/assets/js/pages/dashboard/**/*.js', ['scripts']);
});

gulp.task('default', ['scripts', 'watch']);
