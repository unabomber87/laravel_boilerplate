var gulp = require('gulp'),  
    less = require('gulp-less'),
    sass = require('gulp-sass'),
    minify = require('gulp-minify-css'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    notify = require('gulp-notify'),
    growl = require('gulp-notify-growl'),
    phpunit = require('gulp-phpunit'),
    merge = require('merge-stream'),
    copy = require('gulp-copy');    



var paths = {  
    'dev': {
        'less': './resources/assets/less/',
        'css': './resources/assets/css/',
        'js': './resources/assets/js/',
        'vendor': './vendor/bower_components/'
    },
    'production': {
        'css': './public/assets/css/',
        'js': './public/assets/js/',
        'fonts': './public/assets/fonts/'
    }
};

// fonts
gulp.task('copy', function() {
    // font awesome icon
    gulp.src([paths.dev.vendor +'/font-awesome/fonts/*.*'])
        .pipe(copy(paths.production.fonts, { prefix: 4}));

    // bootstrap icon
    gulp.src([paths.dev.vendor +'/bootstrap/fonts/*.*'])
        .pipe(copy(paths.production.fonts, { prefix: 4}));
});


// CSS
gulp.task('css', function() {
  // less file
  var lessStream = gulp.src(paths.dev.less+'app.less')
      .pipe(less())
      .pipe(concat('less-files.less'));

  // css file
  var cssStream = gulp.src([
        // paths.dev.css+'AdminLTE.css',
        paths.dev.css+'*.css'])
      .pipe(sass())
      .pipe(concat('css-files.css'));


  return merge(lessStream, cssStream)
    .pipe(concat('styles.css'))
    .pipe(minify({keepSpecialComments:0}))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(paths.production.css));
});

// JS
gulp.task('js', function(){  
  return gulp.src([
      paths.dev.vendor+'jquery/dist/jquery.js',
      paths.dev.vendor+'bootstrap/dist/js/bootstrap.js',
      paths.dev.vendor+'jquery-slimscroll/jquery.slimscroll.min.js',
      paths.dev.vendor+'fastclick/lib/fastclick.js',
      paths.dev.js+'adminlte.js',
      paths.dev.js+'demo.js'
    ])
    .pipe(concat('app.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(paths.production.js));
});

// watch
gulp.task('watch', function() {  
  gulp.watch(paths.dev.less + '/*.less', ['css']);
  gulp.watch(paths.dev.js + '/*.js', ['js']);
});

// run default task
gulp.task('default', ['copy', 'css', 'js', 'watch']); 