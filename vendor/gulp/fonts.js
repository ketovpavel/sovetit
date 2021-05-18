var gulp = require('gulp');
var plumber = require('gulp-plumber');

var onError = require('./onError');
import { paths } from './paths';

export const fonts = {
	prod: function fonts() {
		return gulp
			.src(paths.fonts.src)
			.pipe(plumber({ errorHandler: onError }))
			.pipe(gulp.dest(paths.fonts.prod));
	}
};
