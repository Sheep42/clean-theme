var gulp        = require('gulp'),
    browserSync = require('browser-sync'),
    sass        = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps  = require('gulp-sourcemaps'),
    plumber     = require('gulp-plumber'),
    notify      = require('gulp-notify'),
    minify      = require('gulp-minify');
    babel       = require('gulp-babel');

// Title used for system notifications
var notifyInfo = {
    title: 'Gulp'
};

// Error notification settings for plumber
var plumberErrorHandler = { errorHandler: notify.onError({
        title: notifyInfo.title,
        icon: notifyInfo.icon,
        message: "Error: <%= error.message %>"
    })
};

/**
 * @task styles
 * compile files from scss using
 */
gulp.task('styles', function () {
    return gulp.src('./assets/css/scss/style.scss')
    .pipe(plumber(plumberErrorHandler))
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write('./assets/css/maps'))
    .pipe(gulp.dest('.'))
    .pipe(browserSync.reload({stream:true}));
});

gulp.task('minify-js', function() { 
    return gulp.src(['./assets/js/src/**/*.js', '!./assets/js/src/**/*.min.js'])
    .pipe(plumber())
    .pipe(babel({
        presets: ['@babel/env']
    }))
    .pipe(minify({
        ext: {
            src : '.js',
            min : '.min.js'
        },
        noSource: true,
        ignoreFiles : ['.min.js']
    }))
    .pipe(gulp.dest('./assets/js/build'));
});

gulp.task('watch', function () {
    browserSync.init({
        files: ['template-parts/**/*.php', '*.php'],
        proxy: "clean-theme.local",
        snippetOptions: {
          whitelist: ['/wp-admin/admin-ajax.php'],
          blacklist: ['/wp-admin/**']
        }
    });
    
    gulp.watch(['./assets/css/scss/**/*.scss'], gulp.series( 'styles' )).on('change', browserSync.reload);
    gulp.watch(['./assets/js/src/**/*.js'], gulp.series( 'minify-js' )).on('change', browserSync.reload);
});

gulp.task('default', gulp.parallel( 'styles', 'minify-js', 'watch' ) );
