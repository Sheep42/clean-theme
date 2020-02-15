var gulp        = require('gulp'),
    browserSync = require('browser-sync'),
    sass        = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps  = require('gulp-sourcemaps'),
    plumber     = require('gulp-plumber'),
    notify      = require('gulp-notify'),
    minify      = require('gulp-minify');
    babel       = require('gulp-babel');
    concat      = require('gulp-concat');

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

gulp.task('admin-js', function() { 
    return gulp.src(['./assets/js/src/admin/**/*.js'])
                .pipe(plumber())
                .pipe(babel({
                    presets: ['@babel/env'],
                    ignore: ['**/*.min.js']
                }))
                .pipe(minify({
                    ext: {
                        src : '.js',
                        min : '.min.js'
                    },
                    noSource: true,
                    ignoreFiles : ['**/*.min.js']
                }))
                .pipe(concat('admin.min.js'))
                .pipe(gulp.dest('./assets/js/build/admin'));
});

gulp.task('theme-js', function() { 
    return gulp.src(['./assets/js/src/theme/**/*.js', './assets/js/src/vendor/**/*.js'])
                .pipe(plumber())
                .pipe(babel({
                    presets: ['@babel/env'],
                    ignore: ['**/*.min.js']
                }))
                .pipe(minify({
                    ext: {
                        src : '.js',
                        min : '.min.js'
                    },
                    noSource: true,
                    ignoreFiles : ['**/*.min.js']
                }))
                .pipe(concat('main.min.js'))
                .pipe(gulp.dest('./assets/js/build/theme'));
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
    gulp.watch(['./assets/js/src/**/*.js'], gulp.parallel( 'theme-js', 'admin-js' )).on('change', browserSync.reload);
});

gulp.task('default', gulp.parallel( 'styles', 'theme-js', 'admin-js', 'watch' ) );
