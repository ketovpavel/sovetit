var notify = require('gulp-notify');
var gutil = require('gulp-util');

// Custom error function
module.exports = function(err) {
	notify.onError({
		title: 'Gulp error in ' + err.plugin,
		message: err.toString()
	})(err);
	this.emit('end');
	gutil.log(gutil.colors.red(err));
};
