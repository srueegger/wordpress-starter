const path = require('path');
// Including our UglifyJS
const UglifyJSPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  mode: 'production', /* 'development / production'  <-- development nur zur Fehlersuche nutzen */
  entry: {
     admin: './dev-assets/js/admin.js',
     public: './dev-assets/js/public.js',
  },
  plugins: [
    // Adding our UglifyJS plugin
    new UglifyJSPlugin(),
    new MiniCssExtractPlugin({
      filename: "../css/[name].min.css"
    })
  ],
  output: {
    filename: '[name].min.js',
    path: path.resolve(__dirname, 'dist-assets/js')
  },
  externals: {
    jquery: 'jQuery'
  },
  module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /(node_modules|bower_components)/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['babel-preset-env']
            }
          }
        },
        // CSS Loader Rules
        {
          test: /\.(css|sass|scss)$/,
          use: [
              MiniCssExtractPlugin.loader,
              {
                  loader: 'css-loader',
                  options: {
                      importLoaders: 2,
                      sourceMap: true
                  }
              },
              {
                  loader: 'sass-loader',
                  options: {
                      sourceMap: true
                  }
              }
          ]
        }
      ]
    }
};