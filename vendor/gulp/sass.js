var gulp = require('gulp');
var plumber = require('gulp-plumber');
var rename = require("gulp-rename");
var autoprefixer = require('autoprefixer');
var cssnano = require('cssnano');
var postcss = require('gulp-postcss');
var sass = require('gulp-sass');
var sassGlob = require('gulp-sass-glob');
var onError = require('./onError');
import { paths } from './paths';
var gcmq = require('gulp-group-css-media-queries');

var plugins = [
	autoprefixer({
		browsers: ['last 3 versions'],
		cascade: false
	}),
	cssnano({
		preset: 'default',
		zIndex: false,
		sourcemap: true,
		safe: true
	})
];

export const styles = {
	prod: function styles() {
		return gulp
			.src(paths.styles.src)
			.pipe(plumber({ errorHandler: onError }))
			.pipe(sassGlob())
			.pipe(sass().on('error', sass.logError))
			.pipe(gcmq())
			.pipe(postcss(plugins))
			.pipe(rename({
				suffix: ".min",
				extname: ".css"
			}))
			.pipe(gulp.dest(paths.styles.prod));
	}
};
