var path = require('path');
var HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    entry: ['./src/CashMachine.js', './src/app.js' ],
    output: {
        path: path.join(__dirname, 'dist'),
        filename: "bundle.js"
    },
    plugins: [new HtmlWebpackPlugin({
      template: 'public/index.html'
    })],
    module: {
      loaders: [
        { test: /\.js$/, exclude: /node_modules/, loader: "babel-loader"}
      ]
    }
};
