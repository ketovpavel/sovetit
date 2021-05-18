var gulp = require('gulp');
var plumber = require('gulp-plumber');

var onError = require('./onError');
import { paths } from './paths';

export const images = {
	prod: function images() {
		return gulp
			.src(paths.images.src)
			.pipe(plumber({ errorHandler: onError }))
			.pipe(gulp.dest(paths.images.prod));
	}
};
