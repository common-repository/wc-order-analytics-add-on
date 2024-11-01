var install = require( "gulp-install" );

gulp.src( ['./bower.json', './package.json'] )
	  .pipe( sass.sync().on( 'error', sass.logError ) )
	  .pipe( gulp.dest( './assets/css/' ) )
	  .pipe( install() );
