const ImageminPlugin = require("imagemin-webpack-plugin").default
const mix = require("laravel-mix")
const themeRoot = `web/app/themes/noface`
const publicPath = `${themeRoot}/dist`
const resourceRoot = `${themeRoot}/src`

// set the public path directory
mix.setPublicPath(publicPath)

// enable versioning for all compiled files
mix.version()

// set global webpack config
mix.webpackConfig({
  resolve: {
    modules: [`node_modules`],
  },
  module: {
    rules: [
      {
        test: /\.scss/,
        enforce: `pre`,
        loader: `import-glob-loader`,
      },
    ],
  },
  plugins: [
    new ImageminPlugin({
      //            disable: process.env.NODE_ENV !== 'production', // Disable during development
      pngquant: {
        quality: `95-100`,
      },
      test: /\.(jpe?g|png|gif|svg)$/i,
    }),
  ],
})

// initialise the mix compiling
mix
  .copyDirectory(`${resourceRoot}/images`, `${publicPath}/images`)
  .babel(
    [
      `${resourceRoot}/scripts/index.js`,
    ],
    `js/index.js`
  )
  .minify(`${publicPath}/js/index.js`)
  .sass(`${resourceRoot}/styles/editor.scss`, `css`)
  .sass(`${resourceRoot}/styles/index.scss`, `css`)
  .options({
    processCssUrls: false,
  })
  .browserSync({
    proxy: `https://noface.local/`,
    files: [`${themeRoot}/**/*.php}`, `${resourceRoot}/**/*`],
  })
