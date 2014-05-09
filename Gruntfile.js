module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {   
            dist: {
                src: [
                    'wp-content/themes/travel/js/lib/*.js', // All JS in the libs folder
                    'wp-content/themes/travel/js/travel.js'  // This specific file
                ],
                dest: 'wp-content/themes/travel/js/build/production.js',
            }
        },

        uglify: {
            build: {
                src: 'wp-content/themes/travel/js/build/production.js',
                dest: 'wp-content/themes/travel/js/build/production.min.js'
            }
        },
        // imagemin: {
        //     dynamic: {
        //         files: [{
        //             expand: true,
        //             cwd: 'img/',
        //             src: ['*.{png,jpg,gif}'],
        //             dest: 'img/build/'
        //         }]
        //     }
        // },

        watch: {
            scripts: {
                files: ['wp-content/themes/travel/js/*.js'],
                tasks: ['concat', 'uglify'],
                options: {
                    spawn: false,
                },
            } ,
            css: {
                files: ['wp-content/themes/travel/css/*.scss', 'wp-content/themes/travel/css/util/*.scss'],
                tasks: ['sass'],
                options: {
                    spawn: false,
                }
            }
        },
        sass: {
            dist: {
                options: {
                    style: 'compact'
                },
                files: {
                    'wp-content/themes/travel/style.css': 'wp-content/themes/travel/css/travel.scss'
                }
            } 
        }

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    // grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    // grunt.registerTask('default', ['concat', 'uglify', 'imagemin', 'watch', 'sass']);
    grunt.registerTask('default', ['concat', 'uglify', 'watch', 'sass']);

};