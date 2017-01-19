var webpack = require('webpack');
var path = require('path');
var APP_DIR = path.resolve(__dirname, 'src');

var config = {
  entry: ['babel-polyfill', APP_DIR + '/main.js'],
  resolve: {
    alias: {
        'sinon': 'sinon/pkg/sinon'
    },
    root: [
      path.resolve(__dirname, './src/app')
    ],
    extensions: ['', '.js', '.json', '.jsx', '.scss']
  },
  externals: {
    'cheerio': 'window',
  },
  output: {
    library: 'mangoReactions',
    libraryTarget: 'umd',
    path: path.resolve(__dirname, 'public'),
    publicPath: 'public',
    filename: 'bundle.js'
  },
  module : {
    noParse: [
        /node_modules\/sinon\//,
    ],
    loaders : [
      {
        test : /\.jsx?/,
        include : APP_DIR,
        loader : 'babel-loader'
      }
    ]
  },
  devServer: {
    inline: true
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify('development')
    })
  ]
};

module.exports = config;
