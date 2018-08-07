// =============================================================================
// gulpfile.js
// =============================================================================

var gulp          = require('gulp'),
    rename        = require('gulp-rename'),
    postcss       = require('gulp-postcss'),
    plumber       = require('gulp-plumber'),
    stylus        = require('gulp-stylus'),
    sourcemaps    = require('gulp-sourcemaps'),
    cleancss      = require('gulp-clean-css'),
    concat        = require('gulp-concat'),
    uglify        = require('gulp-uglify'),
    util          = require('gulp-util'),
    imagemin      = require('gulp-imagemin'),
    jshint        = require('gulp-jshint'),
    notify        = require('gulp-notify'),
    axis          = require('axis'),
    rupture       = require('rupture'),
    autoprefixer  = require('autoprefixer'),
    lost          = require('lost'),
    del           = require('del'),
    path          = require('path'),
    browserSync   = require('browser-sync').create(),
    reload        = browserSync.reload;

// ---------------------------------------------------------------------- Config

var config = require('./config');
var production = !!util.env.production;

// ------------------------------------------------------------ Helper Functions

// Handle errors
function notifyOnError(err) {
  notify.onError({
    title: 'Error',
    message: "Error: <%= error.message %>"
  })(err);
  this.emit('end');
}

// Use plumber automatically
gulp.plumbedSrc = function () {
  return gulp.src.apply(gulp, arguments)
    .pipe(plumber({ errorHandler: notifyOnError }));
};

// ------------------------------------------------------------------ Gulp Tasks

// Clean the build directory
gulp.task('clean', () => {
  return del([config.root.dest]);
});

// Optimize Images
gulp.task('images', () => {
  return gulp.plumbedSrc(config.images.src, {since: gulp.lastRun('images')})
    .pipe(imagemin({ optimizationLevel: 3,
      progressive: true,
      interlaced: true }))
    .pipe(gulp.dest(config.images.dest))
    .pipe(notify({ title: 'Images', message: 'Images task complete' }));
});

gulp.task('fonts', () => {
  return gulp.plumbedSrc(config.fonts.src, {since: gulp.lastRun('fonts')})
    .pipe(gulp.dest(config.fonts.dest))
    .pipe(notify({ title: 'Fonts', message: 'Fonts task complete' }));
});

// Compile Stylus
gulp.task('styles', () => {
  return gulp.plumbedSrc(config.css.src)
    .pipe(!production ? sourcemaps.init() : util.noop())
    .pipe(stylus({use: [axis(), rupture()]}))
    .pipe(postcss([
      lost(),
      autoprefixer({ browsers: ['last 2 versions']})
    ]))
    .pipe(!production ? sourcemaps.write() : util.noop())
    .pipe(production ? cleancss() : util.noop())
    .pipe(rename('main.css'))
    .pipe(gulp.dest(config.css.dest))
    .pipe(notify({ title: 'Styles', message: 'Styles task complete' }))
    .pipe(browserSync.stream());
});

// Lint JavaScript
gulp.task('jshint', () => {
  return gulp.src(config.js.src, {since: gulp.lastRun('jshint')})
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('jshint-stylish'))
    // Un-comment to fail on errors and warnings
    // .pipe(jshint.reporter('fail'))
    .pipe(notify({ title: 'JSHint', message: 'JSHint Passed' }));
});

// Concatenate and minify JavaScript
gulp.task('js:concat', () => {
  return gulp.plumbedSrc(config.js.src)
    .pipe(concat('app.js'))
    .pipe(production ? uglify() : util.noop())
    .pipe(gulp.dest(config.js.dest))
    .pipe(notify({ title: 'Scripts', message: 'Scripts task complete' }));
});

// ----------------------------------------------------------------- Build Tasks

// Build everything
gulp.task('build', production ?
                   gulp.series('clean', gulp.parallel('styles',
                                                      'js:concat',
                                                      'images',
                                                      'fonts')) :
                   gulp.series('clean', gulp.parallel('styles',
                                                      gulp.series('jshint',
                                                                  'js:concat'),
                                                      'images',
                                                      'fonts')));

// Watch the src directories for changes and rebuild
gulp.task('watch', () => {
  gulp.watch(config.css.all, gulp.series('styles'));
  gulp.watch(config.js.src, gulp.series('js:concat'));
  gulp.watch(config.images.src, gulp.series('images'));
  gulp.watch(config.fonts.src, gulp.series('fonts'));
});

// Run BrowserSync through local server
gulp.task('serve', () => {
  browserSync.init({
    proxy: config.devurl,
    notify: {
      styles: {
        top: 'auto',
        bottom: '0',
        borderRadius: '0'
      }
    }
  });
  gulp.watch(config.css.all, gulp.series('styles'));
  gulp.watch(config.js.src, gulp.series('jshint', 'js:concat')).on('change', reload);
  gulp.watch(config.images.src, gulp.series('images')).on('change', reload);
  gulp.watch(config.fonts.src, gulp.series('fonts')).on('change', reload);

  // Reload page on PHP change
  gulp.watch("./**/*.php").on('change', reload);
});

// ----------------------------------------------------------- Default Gulp Task
gulp.task('default', gulp.series('build', 'serve'));
