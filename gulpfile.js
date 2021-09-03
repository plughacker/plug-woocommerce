var gulp      = require('gulp')
,   minifyJS  = require('gulp-minify')
,   minifyCSS = require('gulp-minify-css')
,   debug     = require('gulp-debug')
,   less      = require('gulp-less');

gulp.task('js', function(){
   gulp.src(['src/plugins/woocommerce-plug-payments/assets/js/*.js'])
   .pipe(debug({title:'js'}))
   .pipe(minifyJS({
        ext:{
            src:'-debug.js',
            min:'-min.js'
        }
    }))
   .pipe(gulp.dest('src/plugins/woocommerce-plug-payments/assets/js/min/'));
});

gulp.task('less', function () {
    gulp.src('src/plugins/woocommerce-plug-payments/assets/css/*.less')
    .pipe(debug({title:'less'}))
    .pipe(less())
    .pipe(minifyCSS())
    .pipe(gulp.dest('src/plugins/woocommerce-plug-payments/assets/css/'));
});

gulp.task('watch', function() {
	gulp.watch(['src/plugins/woocommerce-plug-payments/assets/css/*.less'],  { interval: 1000, delay: 1000 },['less']);
	gulp.watch(['src/plugins/woocommerce-plug-payments/assets/js/*.js'],  { interval: 1000, delay: 1000 },['js']);
})

gulp.task('build',['less', 'js']);
gulp.task('develop',  ['build','watch']);