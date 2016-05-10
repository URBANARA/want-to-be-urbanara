'use strict';

import gulp from 'gulp';
import plumber from 'gulp-plumber';
import uglify from 'gulp-uglify';
import rollup from 'gulp-rollup';
import rollupConfig from './rollup.config';
import jade from 'gulp-jade';
import sourcemaps from 'gulp-sourcemaps';
import stylus from 'gulp-stylus';
import koutoSwiss from 'kouto-swiss';
import prefixer from 'autoprefixer-stylus';
import jeet from 'jeet';
import rupture from 'rupture';
import gcmq from 'gulp-group-css-media-queries';
import cssnano from 'gulp-cssnano';
import browserSync from 'browser-sync';
import ghPages from 'gulp-gh-pages';

const source = {
  markups: 'app/markups/**/*.jade',
  scripts: 'app/scripts/**/*.js',
  styles: 'app/styles/**/*.styl',
  stylesMain: 'app/styles/**/*.styl'
};

const build = {
  files: '.build/**/*',
  root: '.build/',
  markups: '.build/',
  scripts: '.build/scripts/',
  styles: '.build/styles/'
};

gulp.task('scripts', () => {
  gulp.src(source.scripts)
    .pipe(plumber())
    .pipe(rollup(rollupConfig))
    // .pipe(uglify())
    .pipe(gulp.dest(build.scripts));
});

gulp.task('markups', () => {
  gulp.src(source.markups)
    .pipe(plumber())
    .pipe(jade())
    .pipe(gulp.dest(build.markups));
});

gulp.task('styles', () => {
  gulp.src(source.stylesMain)
    .pipe(sourcemaps.init())
    .pipe(stylus({
      use: [koutoSwiss(), prefixer(), jeet(), rupture()],
      compress: true
    }))
    .pipe(gcmq())
    .pipe(cssnano())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(build.styles));
});

gulp.task('watch', () => {
  gulp.watch(source.markups, ['markups']);
  gulp.watch(source.styles, ['styles']);
  gulp.watch(source.scripts, ['scripts']);
});

gulp.task('server', () => {
  var files = [ build.root ];
  browserSync.init(files, {
    server: {
      baseDir: '.build/'
    },
  });
});

gulp.task('pages', () => {
  gulp.src(build.files)
    .pipe(ghPages());
});

gulp.task('default', ['scripts', 'markups', 'styles', 'watch', 'server']);
gulp.task('deploy', ['scripts', 'markups', 'styles', 'pages']);
