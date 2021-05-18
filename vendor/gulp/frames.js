var gulp = require('gulp');
var plumber = require('gulp-plumber');

var onError = require('./onError');
import { paths } from './paths';

export const frames = {
	prod: function frames() {
		return gulp
			.src(paths.frames.src)
			.pipe(plumber({ errorHandler: onError }))
			.pipe(gulp.dest(paths.frames.prod));
	}
};
