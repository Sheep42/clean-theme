const   gulp        = require('gulp'),
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
 *  compile scripts
 *  
 *  @param  array   src_files   The source files to compile   
 *  @param  string  prefix      The prefix to be appended to the .min.js file  
 *  @param  string  dest        The destination directory ( inside of ./assets/js/build ) 
 *  
 */
function build_scripts( src_files, prefix, dest ) {
    return gulp.src( src_files )
            .pipe(plumber())
            .pipe(sourcemaps.init())
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
            .pipe(concat( prefix + '.min.js' ))
            .pipe(sourcemaps.write( '../maps' ))
            .pipe(gulp.dest( './assets/js/build/' + dest ));
}

function styles() {
    return gulp.src('./assets/css/scss/style.scss')
                .pipe(plumber(plumberErrorHandler))
                .pipe(sourcemaps.init())
                .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
                .pipe(autoprefixer())
                .pipe(sourcemaps.write('./assets/css/maps'))
                .pipe(gulp.dest('.'))
                .pipe(browserSync.reload({stream:true}));
}

function admin_js() { 
    return build_scripts( [ './assets/js/src/admin/**/*.js' ], 'admin', 'admin' );
}

function theme_js() { 
    return build_scripts( ['./assets/js/src/theme/**/*.js', './assets/js/src/vendor/**/*.js'], 'main', 'theme' );
}

function watch() {
    browserSync.init({
        files: ['template-parts/**/*.php', '*.php'],
        proxy: "clean-theme.local",
        snippetOptions: {
          whitelist: ['/wp-admin/admin-ajax.php'],
          blacklist: ['/wp-admin/**']
        }
    });
    
    gulp.watch(['./assets/css/scss/**/*.scss'], gulp.series( styles )).on('change', browserSync.reload);
    gulp.watch(['./assets/js/src/**/*.js'], gulp.parallel( theme_js, admin_js )).on('change', browserSync.reload);
}

exports.default = gulp.series( gulp.parallel( styles, theme_js, admin_js ), watch );
