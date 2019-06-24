const path = require('path');
const webpack = require('webpack');
const CKEditorWebpackPlugin = require( '@ckeditor/ckeditor5-dev-webpack-plugin' );
const { styles } = require( '@ckeditor/ckeditor5-dev-utils' );

module.exports = {
  entry: './cms.js',
  output: {
    filename: 'cms.js',
    path: path.resolve(__dirname, '__')
  },
  plugins: [
    new webpack.ProvidePlugin({
      '$': 'jquery',
      'jQuery': 'jquery',
      'jquery': 'jquery',
      'window.$': 'jquery',
      'window.jQuery': 'jquery',
      'window.jquery': 'jquery',
    }),
    new CKEditorWebpackPlugin( {
      // See https://ckeditor.com/docs/ckeditor5/latest/features/ui-language.html
      language: 'en'
    })
  ],
  module:{
    rules:[
      { 
        test: require.resolve('jquery'),
        use: [{
          loader: 'expose-loader',
          options: 'jQuery'
        },{
          loader: 'expose-loader',
          options: '$'
        }]
      },
      { 
        test: require.resolve('moment'),
        use: [{
          loader: 'expose-loader',
          options: 'moment'
        }]
      },
      { 
        test: require.resolve('nouislider'),
        use: [{
          loader: 'expose-loader',
          options: 'noUiSlider'
        }]
      },
      { 
        test: require.resolve('bloodhound-js'),
        use: [{
          loader: 'expose-loader',
          options: 'Bloodhound'
        }]
      },
      // {
      //   test: /datatables\.net.*/,
      //   loader: 'imports-loader?define=>false'
      // },
      {
        test: /bootstrap-tokenfield.*/,
        loader: 'imports-loader?define=>false'
      },
      {
        test: /bloodhound.*/,
        loader: "imports-loader?this=>window"
      },
      {
        test:/\.css$/,
        use: [
          {
            loader: 'style-loader',
            options: {
              singleton: true
            }
          },
          {
            loader: 'postcss-loader',
            options: styles.getPostCssConfig({
              themeImporter: {
                themePath: require.resolve( '@ckeditor/ckeditor5-theme-lark' )
              },
              minify: true
            })
          },
        ]
      },
      {
        test: /\.svg$/,
        use: [ 'raw-loader' ]
      },
      {
        test: /\.(png|jp(e*)g)$/,  
        use: [{
          loader: 'url-loader',
          options: { 
            limit: 8000, // Convert images < 8kb to base64 strings
            name: 'images/[hash]-[name].[ext]'
          } 
        }]
      }
    ]
  },
};