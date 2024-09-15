// webpack.config.js

const TerserPlugin = require("terser-webpack-plugin");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const cssnano = require('cssnano');
const autoprefixer = require('autoprefixer');
const path = require("node:path");
const CopyPlugin = require('copy-webpack-plugin');

module.exports = (env, argv) => {
  return {
    entry: {
      // Global CSS styles
      style: './src/general-scss.js',

      // Common JS used across the Site
      globalScripts: './src/js/global-scripts.js',

      // JS files that handle independent features
      ckEditor: './src/js/ck-editor.js',
      leaflet: './src/js/leaflet.js',
      pinEdition: './src/js/pin-edition.js',
    },
    watch: argv.mode !== 'production',
    watchOptions: {
      ignored: /node_modules/
    },
    output: {
      filename: '[name].js',
      chunkFilename: '[name].js?ver=[chunkhash]',
      publicPath: '/dist/',
      path: path.resolve(__dirname, 'public', 'dist'),
    },
    resolve: {
      extensions: ['*', '.js'],
    },
    mode: argv.mode || 'development',
    performance: {
      hints: false,
    },
    devtool: 'source-map',
    module: {
      rules: [
        {
          test: /\.js$/,
          use: [
            {
              loader: 'babel-loader',
              options: {
                presets: ['@babel/preset-env']
              },
            },
          ],
        },
        {
          test: /\.s?css$/,
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader',
              options: {
                sourceMap: true,
              },
            },
            {
              loader: 'postcss-loader',
              options: {
                postcssOptions: {
                  plugins: [
                    autoprefixer({}),
                    ...(argv.mode === 'production' ? [cssnano({preset: 'default'})] : [])
                  ],
                },
                sourceMap: true,
              },
            },
            {
              loader: 'sass-loader',
              options: {
                sourceMap: true,
                implementation: require("sass"),
                sassOptions: {
                  precision: 10
                }
              },
            },
          ],
        },
        {
          test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
          use: [
            {
              loader: 'file-loader',
              options: {
                name: '[name].[ext]',
                outputPath: 'fonts/'
              }
            }
          ]
        }
      ],
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: '[name].css',
      }),
      new CopyPlugin({
        patterns: [
          { from: 'src/img', to: './' }
        ],
      }),
    ],
    optimization: {
      minimize: argv.mode === 'production',
      minimizer: [new TerserPlugin()],
    },
  };
}