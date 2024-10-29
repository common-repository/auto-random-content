module.exports = function (grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            my_target: {
                files: {
                    'assets/random_content.js': [
                        'public_resources/*.js',
                    ]
                }
            }
        },
        sass: {
            dist: {
                files: {
                    'assets/random_content.css': 'public_resources/random_content.scss'
                }
            },
            options: {
                noCache: true
            },
        },
        cssmin: {
            options: {
                mergeIntoShorthands: false,
                roundingPrecision: -1
            },
            target: {
                files: {
                    'assets/random_content.css': [
                        'public_resources/random_content.scss'
                    ]
                }
            }
        },
        watch: {
            configFiles: {
                files: [
                    'public_resources/*'
                ],
                tasks: [
                    'uglify',
                    'sass',
                    'cssmin'
                ],
                options: {
                    reload: true
                }
            }
        }
    });

    /* questo modulo minifica il file js*/
    grunt.loadNpmTasks('grunt-contrib-uglify');

    /* questo modulo compila il sass*/
    grunt.loadNpmTasks('grunt-contrib-sass');

    /* questo modulo minimizza il css */
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    /*questo modulo verifica automaticamente se sono state apportate delle modifiche al codice; se si esegue in maniera autonoma dei task*/
    grunt.loadNpmTasks('grunt-contrib-watch');

    /*uglify concatena e minimizza il js*/
    grunt.registerTask('default', ['uglify', 'sass', 'cssmin']);
};