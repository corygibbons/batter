'use strict';
module.exports = function(grunt) {

    // load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // watch for changes and trigger compass, jshint, uglify and livereload
        watch: {
            compass: {
                files: ['assets/scss/**/*.{scss,sass}'],
                tasks: ['compass']
            },
            js: {
                files: '<%= jshint.all %>',
                tasks: ['jshint', 'uglify']
            },
            livereload: {
                options: { livereload: true },
                files: ['style.css', 'assets/js/*.js', '*.html', '*.php', 'assets/images/**/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },

        // compass and scss
        compass: {
            dist: {
                options: {
                    config: 'config.rb',
                    force: true
                }
            }
        },

        // javascript linting with jshint
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                "force": true
            },
            all: [
                'Gruntfile.js',
                'assets/js/*.js'
            ]
        },

        uglify: {
            dynamic_mappings: {
                files: [{
                    expand: true,
                    cwd: 'assets/js/',
                    src: '**/*.js',
                    dest: 'js/',
                    ext: '.min.js'
                }]
            }
        },

        // build
        build: {
            copy: {
                files: [{
                    src: [
                        'css/**',
                        'img/**',
                        'js/**',
                        'views/**',
                        'info.php'
                        ],
                    dest: 'upload/',
                    filter: 'isFile'
                }]
            }
        },

        // deploy via rsync
        deploy: {
            options: {
                args: ["--verbose"],
                src: "./",
                exclude: ['.git*', 'node_modules', '.sass-cache', 'Gruntfile.js', 'package.json', '.DS_Store', 'README.md', 'config.rb', '.jshintrc'],
                syncDestIgnoreExcl: true,
                recursive: true
            },
            stage: {
                options: {
                    dest: "~/path/to/theme",
                    host: "user@staging-host"
                }
            },
            production: {
                options: {
                    dest: "~/path/to/theme",
                    host: "user@production-host"
                }
            }
        }

    });


    // rename tasks
    grunt.renameTask('rsync', 'deploy');
    grunt.renameTask('copy', 'build');

    // register task
    grunt.registerTask('default', ['watch']);


};