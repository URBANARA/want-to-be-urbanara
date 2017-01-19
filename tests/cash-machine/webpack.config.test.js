var webpack = require('webpack');
var path = require('path');

var config = {
  devtool: 'inline-source-map',
  resolve: {
    alias: {
        'sinon': 'sinon/pkg/sinon'
    },
    root: [
      path.resolve(__dirname, './src')
    ],
    extensions: ['', '.js', '.json', '.jsx']
  },
  externals: {
    'cheerio': 'window',
    'react/lib/ExecutionEnvironment': true,
    'react/lib/ReactContext': true,
    'react/addons': true
  },
  node: {
    fs: "empty"
  },
  module: {
    noParse: [
        /node_modules\/sinon\//,
    ],
    preLoaders: [
     {
       test: /\.js?$/,
       exclude: [
         /node_modules/,
         /test/
       ],
       loader: 'babel-loader'
     },
   ],
    loaders: [
      {
        exclude: /node_modules/,
        test: /\.js?$/,
        loader: 'babel-loader',
      }
    ]
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify('test')
    })
  ]
};

module.exports = config;
