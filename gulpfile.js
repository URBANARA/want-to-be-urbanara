const fs = require('fs');
const minimist = require('minimist');
const gulp = require('gulp');
const babel = require('gulp-babel');
const eslint = require('gulp-eslint');
const gutil = require('gulp-util');
const sequence = require('gulp-sequence');

require('babel-core/register');

gulp.task('get-money', function(done) {
  sequence('build', 'loot')(done);
})

gulp.task('lint', function () {
  return gulp.src(['**/*.js','!node_modules/**', '!build/**'])
  .pipe(eslint())
  .pipe(eslint.format())
  .pipe(eslint.failAfterError());
});

gulp.task('build', function () {
  return gulp.src('src/**/*.js')
  .pipe(babel({ presets: ['es2015'] }))
  .pipe(gulp.dest('build'));
});

gulp.task('loot', function () {
  gutil.log(gutil.colors.green('Starting withdrawal'));
  const params = _getParams();

  if (!_fileExists('./build/main.js')) {
    gutil.log(gutil.colors.red('Error:'), gutil.colors.red('Files were not compiled'));
    return;
  }

  if(!params.amount){
    gutil.log(gutil.colors.red('Error: --amount param is required'));
    return;
  }

  return require('./build/main').default(params);
});


function _getParams () {
  const params = minimist(process.argv.slice(2));
  delete params._;

  return params;
}


function _fileExists (path) {
  return fs.existsSync(path, function (exists) {
    return exists;
  });
}
