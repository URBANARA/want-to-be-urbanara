var argv = require('yargs').argv;
var path = require('path');
var webpackConfig = require('./webpack.config.test');

module.exports = function(config) {
  config.set({
    browsers: ['PhantomJS'],
    singleRun: !argv.watch,
    frameworks: ['mocha','chai'],
    reporters: ['spec'],
    files: [
      'node_modules/babel-polyfill/dist/polyfill.js',
      './node_modules/phantomjs-polyfill/bind-polyfill.js',
      './test/test.bundle.js'
    ],
    plugins: [
      'karma-coverage',
      'karma-mocha',
      'karma-chai',
      'karma-webpack',
      'karma-phantomjs-launcher',
      'karma-spec-reporter',
      'karma-sourcemap-loader',
      'karma-babel-preprocessor'
    ],
    preprocessors: {
      'test/test.bundle.js': ['webpack', 'sourcemap']
    },
    webpack: webpackConfig,
    webpackMiddleware: {
      noInfo: true,
    }
  });
}
