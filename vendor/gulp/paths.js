export const paths = {
	settings: {
		domain: 'site.test',
		watch: '../**/*.php'
	},
	images: {
		src: 'src/assets/images/**',
		prod: '../assets/images/',
		watch: 'src/assets/images/*'
	},
	frames: {
		src: 'src/assets/frames/**/*',
		prod: '../assets/frames/',
		watch: 'src/assets/frames/*'
	},
	fonts: {
		src: 'src/assets/fonts/**',
		prod: '../assets/fonts/',
		watch: 'src/assets/fonts/*'
	},
	styles: {
		src: 'src/styles/*.scss',
		prod: '../assets/css',
		watch: 'src/styles/**/*'
	},
	scripts: {
		src: 'src/scripts/*.js',
		prod: '../assets/js',
		watch: 'src/scripts/*'
	}
};