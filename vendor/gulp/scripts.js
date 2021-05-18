var gulp = require('gulp');
var plumber = require('gulp-plumber');
var gconcat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var babel = require('gulp-babel');

var onError = require('./onError');
import { paths } from './paths';

export const scripts = {
	prod: function scripts() {
		return gulp
			.src(paths.scripts.src)
			.pipe(plumber({ errorHandler: onError }))
			.pipe(babel())
			.pipe(uglify())
			.pipe(gconcat('main.js'))
			.pipe(rename({ suffix: '.min' }))
			.pipe(gulp.dest(paths.scripts.prod));
	}
};
