'use strict';

module.exports = function (grunt) {

  grunt.initConfig({
    watch: {
      options: {
        livereload: true
      },
      sass: {
        files: ['assets/sass/{,**/}*.{scss,sass}'],
        tasks: ['compass:dev'],
        options: {
          livereload: false
        }
      },
      images: {
        files: ['assets/images/**']
      },
      css: {
        files: ['assets/stylesheets/{,**/}*.css']
      },
      scripts: {
        files: ['assets/scripts/{,**/}*.js', '!assets/scripts/{,**/}*.min.js'],
        tasks: ['jshint', 'uglify:dev']
      },
      styleguide: {
        files: ['assets/stylesheets/{,**/}*.css'],
        tasks: ['styleguide']
      },
      handlebars: {
        files: ['assets/templates/{,**/}*.hbs'],
        tasks: ['handlebars']
      }
    },

    compass: {
      options: {
        config: 'config.rb',
        bundleExec: true,
        force: true
      },
      dev: {
        options: {
          environment: 'development'
        }
      },
      dist: {
        options: {
          environment: 'production'
        }
      }
    },

    styleguide: {
        options: {
            framework: {
                name: 'kss'
            },

            template: {
                src: 'assets/kss_template'
            }

        },
        all: {
            files: [{
                'assets/styleguide': 'assets/sass/**/*.scss'
            }]
        }
    },

    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: ['assets/scripts/{,**/}*.js', '!assets/scripts/{,**/}*.min.js']
    },

    uglify: {
        dev: {
            options: {
                mangle: false,
                compress: false,
                beautify: true
            },
            files: [{
                expand: true,
                flatten: true,
                cwd: 'assets/scripts',
                dest: 'assets/scripts',
                src: ['**/*.js', '!**/*.min.js'],
                rename: function (dest, src) {
                    var folder = src.substring(0, src.lastIndexOf('/'));
                    var filename = src.substring(src.lastIndexOf('/'), src.length);
                    filename = filename.substring(0, filename.lastIndexOf('.'));
                    return dest + '/' + folder + filename + '.min.js';
                }
            }]
        },
        dist: {
            options: {
                mangle: true,
                compress: true
            },
            files: [{
                expand: true,
                flatten: true,
                cwd: 'assets/scripts',
                dest: 'assets/scripts',
                src: ['**/*.js', '!**/*.min.js'],
                rename: function (dest, src) {
                    var folder = src.substring(0, src.lastIndexOf('/'));
                    var filename = src.substring(src.lastIndexOf('/'), src.length);
                    filename = filename.substring(0, filename.lastIndexOf('.'));
                    return dest + '/' + folder + filename + '.min.js';
                }
            }]
        }
    },
    handlebars: {
      options: {
        namespace: 'Handlebars.Templates',
        processName: function(filePath) {
          return filePath.replace('assets/templates/', '').replace(/\.hbs$/, '');
        }
      },
      all: {
        files: {
          'assets/js/templates.js': ['assets/templates/{,**/}*.hbs']
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-shell');
  grunt.loadNpmTasks('grunt-styleguide');
  grunt.loadNpmTasks('grunt-contrib-handlebars');

  grunt.registerTask('build', [
    'uglify:dist',
    'compass:dist',
    'jshint'
  ]);

};
