module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    watch: {
      css: {
        files: ['**/*.scss'],
        // files: ['scss/partials/*.scss'],
        tasks: ['sass', 'postcss'],
        // options: {
        //   spawn: false
        // }
      },
      // js: {
      //   files: [
      //     'assets/js/main.js',
      //     'Gruntfile.js'
      //   ],
      //   tasks: ['uglify']
      // },
      plugins: {
        files: [
          'assets/js/plugins/*.js',
          'assets/css/plugins/*.css'
        ],
        tasks: ['concat']
      }
    },

    sass: {                           
      dist: {
        options: {
          style: 'compressed'
        },
        files: {
          'assets/css/main.css': 'assets/scss/main.scss',       // 'destination': 'source'
        }
      }
    },

    uglify: {
      my_target: {
        files: {
          'assets/js/main.min.js': 'assets/js/main.js',
        }
      }
    },

    postcss: {
      options: {
        map: true, // inline sourcemaps

        processors: [
          require('pixrem')(), // add fallbacks for rem units
          require('autoprefixer'), // add vendor prefixes
          require('postcss-object-fit-images') // Object Fit Polyfill
        ]
      },
      dist: {
        src: 'css/*.css'
      }
    },

    concat: {
      basic: {
        src: ['assets/js/plugins/*.js'],
        dest: 'assets/js/vendor.js',
      },
      css: {
        src: ['assets/css/plugins/*.css'],
        dest: 'assets/css/vendor.css',
      }
    }
    
  });

  // Load the Grunt plugins.
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-postcss');
  // grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-uglify-es');
  // grunt.loadNpmTasks('grunt-svgstore');

  // Register the default tasks.
  grunt.registerTask('default', ['watch']);
};
