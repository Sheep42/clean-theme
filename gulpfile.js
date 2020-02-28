const   gulp        = require('gulp'),
        browserSync = require('browser-sync'),
        sass        = require('gulp-sass'),
        autoprefixer = require('gulp-autoprefixer'),
        sourcemaps  = require('gulp-sourcemaps'),
        plumber     = require('gulp-plumber'),
        notify      = require('gulp-notify'),
        minify      = require('gulp-minify'),
        babel       = require('gulp-babel'),
        concat      = require('gulp-concat'),
        fs          = require('fs'),
        crypto      = require('crypto'),
        argv        = require('yargs').options({
            'production': {
                default: false,
                type: 'boolean'
            },
            'browser-sync': {
                default: true,
                type: 'boolean'
            } 
        }).argv,
        shasum      = crypto.createHash('sha256');

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
 *     Hash a set of files and return a manifest object
 * 
 *     @param  array    src_files    The files
 *     
 *     @return object   The manifest object
 */
function hash_files( src_files ) {

    let manifest = {};

    for( let i = 0; i < src_files.length; i++ ) {
        let regex = /\\|\//g;
        let file_buffer = fs.readFileSync( __dirname + '/' + src_files[i]);
        let sum = crypto.createHash('sha256');
        let filename = src_files[i].split(regex).pop();
        
        sum.update(file_buffer);

        manifest[filename] = sum.digest('hex');
    }

    return manifest;
}

/**
 * Build a cache version manifest by 
 * hashing assets
 */
function cache_version_update() {
    let cache_version_filename =  __dirname + '/asset_cache_manifest.json';

    manifest = hash_files( ['assets/js/build/theme/main.min.js', 'assets/js/build/admin/admin.min.js', 'style.css'] );

    let asset_manifest_json = JSON.stringify( manifest );

    fs.writeFileSync( cache_version_filename, asset_manifest_json, function(err, data) {
        if (err) {
            console.log('error writing ' + cache_version_filename + ': ' + err);
        }
    });

    return gulp.src( cache_version_filename )
    .pipe( gulp.dest( __dirname ) );
}

/**
 *  compile scripts with sourcemaps
 *  
 *  @param  array   src_files   The source files to compile   
 *  @param  string  prefix      The prefix to be appended to the .min.js file  
 *  @param  string  dest        The destination directory ( inside of ./assets/js/build ) 
 *  
 */
function build_scripts_dev( src_files, prefix, dest ) {
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

/**
 *  compile scripts
 *  
 *  @param  array   src_files   The source files to compile   
 *  @param  string  prefix      The prefix to be appended to the .min.js file  
 *  @param  string  dest        The destination directory ( inside of ./assets/js/build ) 
 *  
 */
function build_scripts( src_files, prefix, dest ) {

    if( false === argv.production )
        return build_scripts_dev( src_files, prefix, dest );

    return gulp.src( src_files )
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
            .pipe(concat( prefix + '.min.js' ))
            .pipe(gulp.dest( './assets/js/build/' + dest ));
}

/**
 * compile styles with sourcemaps
 */
function styles_dev() {
    return gulp.src('./assets/css/scss/style.scss')
            .pipe(plumber(plumberErrorHandler))
            .pipe(sourcemaps.init())
            .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
            .pipe(autoprefixer())
            .pipe(sourcemaps.write('./assets/css/maps'))
            .pipe(gulp.dest('.'))
            .pipe(browserSync.reload({stream:true}));
}

/**
 *  compile styles
 */
function styles() {

    if( false === argv.production )
        return styles_dev();

    return gulp.src('./assets/css/scss/style.scss')
                .pipe(plumber(plumberErrorHandler))
                .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
                .pipe(autoprefixer())
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

    if( true === argv.browserSync ) { 
        browserSync.init({
            files: ['template-parts/**/*.php', '*.php'],
            proxy: "clean-theme.local",
            snippetOptions: {
              whitelist: ['/wp-admin/admin-ajax.php'],
              blacklist: ['/wp-admin/**']
            }
        });
        
        gulp.watch(['./assets/css/scss/**/*.scss'], gulp.series( styles, cache_version_update )).on('change', browserSync.reload);
        gulp.watch(['./assets/js/src/**/*.js'], gulp.series( gulp.parallel( theme_js, admin_js ), cache_version_update )).on('change', browserSync.reload);
    } else {
        gulp.watch(['./assets/css/scss/**/*.scss'], gulp.series( styles, cache_version_update ));
        gulp.watch(['./assets/js/src/**/*.js'], gulp.series( gulp.parallel( theme_js, admin_js ), cache_version_update ));
    }
}

exports.default = gulp.series( gulp.parallel( styles, theme_js, admin_js ), cache_version_update, watch );
exports.build = gulp.series( gulp.parallel( styles, theme_js, admin_js ), cache_version_update );
exports.build_manifest = gulp.series( cache_version_update );
