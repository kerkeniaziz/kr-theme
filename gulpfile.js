/**
 * KR Theme Gulp Configuration
 * Compiles SCSS to CSS with autoprefixing and minification
 *
 * @package KR_Theme
 * @since 1.4.0
 */

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');

// Paths
const paths = {
    scss: {
        src: './assets/scss/**/*.scss',
        dest: './assets/css/'
    }
};

/**
 * Error handler
 */
const handleError = function(error) {
    notify.onError({
        title: 'Gulp Error',
        message: '<%= error.message %>',
        sound: 'beep'
    })(error);
    this.emit('end');
};

/**
 * Compile SCSS to CSS with development options
 */
function compileSass() {
    return gulp.src(paths.scss.src)
        .pipe(plumber(handleError))
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            cascade: false,
            grid: true
        }))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest(paths.scss.dest))
        .pipe(notify({
            message: 'SCSS compiled successfully!',
            onLast: true
        }));
}

/**
 * Compile SCSS to minified CSS for production
 */
function minifySass() {
    return gulp.src(paths.scss.src)
        .pipe(plumber(handleError))
        .pipe(sass({
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            cascade: false,
            grid: true
        }))
        .pipe(cleanCSS({
            compatibility: 'ie8'
        }))
        .pipe(gulp.dest(paths.scss.dest))
        .pipe(notify({
            message: 'SCSS minified successfully!',
            onLast: true
        }));
}

/**
 * Watch SCSS files for changes
 */
function watchSass() {
    gulp.watch(paths.scss.src, compileSass);
}

/**
 * Development build
 */
const dev = gulp.parallel(compileSass, watchSass);

/**
 * Production build
 */
const build = minifySass;

// Gulp tasks
gulp.task('compile-sass', compileSass);
gulp.task('minify-sass', minifySass);
gulp.task('watch', watchSass);
gulp.task('dev', dev);
gulp.task('build', build);

// Default task
gulp.task('default', dev);
