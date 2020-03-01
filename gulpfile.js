"use strict"

const themeDirectory = `web/app/themes/noface`
const gulp = require("gulp")
const sass = require("gulp-sass")
const sassGlob = require("gulp-sass-glob")
const plumber = require("gulp-plumber")
const notify = require("gulp-notify")
const cleanCSS = require("gulp-clean-css")
const autoprefixer = require("gulp-autoprefixer")
const concat = require("gulp-concat")
const path = require("path")
const browserSync = require("browser-sync").create()
const sourcemaps = require("gulp-sourcemaps")
const uglify = require("gulp-uglify-es").default
const babel = require("gulp-babel")
const imagemin = require("gulp-imagemin")

gulp.task("images", () => {
  return gulp
    .src(`${themeDirectory}/src/images/**/*`)
    .pipe(imagemin())
    .pipe(gulp.dest(`${themeDirectory}/dist/images`))
})

gulp.task("sass", function() {
  return gulp
    .src([
      `${themeDirectory}/src/styles/editor.scss`,
      `${themeDirectory}/src/styles/index.scss`,
    ])
    .pipe(customPlumber("Error running Sass"))
    .pipe(sassGlob())
    .pipe(sass())
    .pipe(
      autoprefixer({
        cascade: false,
      })
    )
    .pipe(
      cleanCSS(
        {
          debug: true,
        },
        details => {
          console.log(`${details.name}: ${details.stats.originalSize}`)
          console.log(`${details.name}: ${details.stats.minifiedSize}`)
        }
      )
    )
    .pipe(gulp.dest(`${themeDirectory}/dist/css`))
    .pipe(browserSync.stream())
})

gulp.task("scripts", function() {
  return gulp
    .src([
      "node_modules/@babel/polyfill/dist/polyfill.js",
      `${themeDirectory}/src/scripts/**/*.js`,
    ])
    .pipe(sourcemaps.init())
    .pipe(
      babel({
        presets: ["@babel/env"],
      })
    )
    .pipe(concat("index.js"))
    .pipe(uglify())
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(`${themeDirectory}/dist/js`))
})

function customPlumber(errTitle) {
  return plumber({
    errorHandler: notify.onError({
      title: errTitle || "Error running Gulp",
      message: "Error: <%= error.message %>",
    }),
  })
}

gulp.task("serve", () => {
  browserSync.init({
    proxy: "https://noface.local",
  })
  gulp
    .watch([`${themeDirectory}/src/scripts/**/*.js`], gulp.series("scripts"))
    .on("change", browserSync.reload)
  gulp
    .watch([`${themeDirectory}/src/styles/**/*.scss`], gulp.series("sass"))
    .on("change", browserSync.reload)
  gulp.watch(`${themeDirectory}/**/*.twig`).on("change", browserSync.reload)
  gulp.watch(`${themeDirectory}**/*.php`).on("change", browserSync.reload)
})

gulp.task("default", gulp.series(["images", "sass", "scripts", "serve"]))
