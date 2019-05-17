var gulp        = require('gulp'),
    browserSync = require('browser-sync'),
    sass        = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps  = require('gulp-sourcemaps'),
    plumber     = require('gulp-plumber'),
    notify      = require('gulp-notify'),
    minify      = require('gulp-minify');

/**
 * Launch the Server
 */
gulp.task('browser-sync', ['styles'], function() {
   browserSync.init({
     // Change this to match your local environment
     proxy: "localhost:8080",
     socket: {
         // For local development only use the default Browsersync local URL.
         domain: 'www.clean-theme.loc'
         // For external development (e.g on a mobile or tablet) use an external URL.
         // You will need to update this to whatever BS tells you is the external URL when you run Gulp.
         // domain: '10.0.1.20:3000'
     }
   });
});

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
    return gulp.src(['./assets/js/*.js', '!./assets/js/*.min.js'])
    .pipe(plumber())
    .pipe(minify({
        ext: {
            src : '.js',
            min : '.min.js'
        },
        ignoreFiles : ['.min.js']
    }))
    .pipe(gulp.dest('./assets/js'));
});

gulp.task('watch', function () {
    gulp.watch(['./assets/css/scss/**/*.scss'], ['styles']);
    gulp.watch(['./assets/js/*.js'], ['minify-js']);
});

gulp.task('default', ['styles', 'minify-js', 'watch']);