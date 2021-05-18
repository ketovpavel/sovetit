import gulp from 'gulp';
import browserSync from 'browser-sync';

import	{paths}		from 	'./gulp/paths';
import	{fonts}		from 	'./gulp/fonts';
import	{styles} 	from 	'./gulp/sass';
import	{scripts} 	from 	'./gulp/scripts';
import	{images} 	from 	'./gulp/images';
import	{frames} 	from 	'./gulp/frames';

// gulp prod
gulp.task( 'default', gulp.series (
    gulp.parallel( fonts.prod, scripts.prod, styles.prod, images.prod, frames.prod ),
	function startBrowser( done ) {
		browserSync.init({
			proxy: paths.settings.domain
		});
		done();
	},
	function watch(done) {
		const reload = (done) => {
			browserSync.reload();
			done();
		};
		gulp.watch(	paths.styles.watch,		gulp.series(	styles	.prod,	reload ) );
		gulp.watch(	paths.fonts.watch,		gulp.series(	fonts	.prod,	reload ) );
		gulp.watch(	paths.scripts.watch,	gulp.series(	scripts	.prod,	reload ) );
		gulp.watch(	paths.images.watch,		gulp.series(	images	.prod,	reload ) );
		gulp.watch(	paths.frames.watch,		gulp.series(	frames	.prod,	reload ) );
		gulp.watch(	paths.settings.watch,	reload );
		done();
	}
));