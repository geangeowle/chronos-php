'use strict';

module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        changelog: {
            sample: {
                options: {
                    fileHeader: '# Changelog',
                    logArguments: [
                        '--pretty=* %h - %ad: %s',
                        '--no-merges',
                        '--date=short'
                    ],
                    template: '{{> features}}',
                    featureRegex: /^(.*)$/gim,
                    partials: {
                        features: '{{#if features}}{{#each features}}{{> feature}}{{/each}}{{else}}{{> empty}}{{/if}}\n',
                        feature: '- {{this}} {{this.date}}\n'
                    }
                }
            }
        },
        typescript: {
            options: {
                module: 'commonjs',
                target: 'es5',
                removeComments: true
            },
            dist: {
                src: 'app/public/assets/ts/*.ts',
                dest: 'public/assets/js/',
            },
        },
        uglify: {
            options: {
                sourceMap: true,
                compress: {
                    drop_console: true
                },
            },
            my_target: {
                files: [{
                    expand: true,
                    src: ['public/assets/js/*.js', '!public/assets/js/*.min.js'],
                    dest: '.',
                    cwd: '.',
                    rename: function (dst, src) {
                        // To keep the source js files and make new files as `*.min.js`:
                        return dst + '/' + src.replace('.js', '.min.js');
                        // Or to override to src:
                        return src;
                    }
                }]
            }
        }
    });

    // Load the plugin that provides the "changelog" task.
    grunt.loadNpmTasks('grunt-changelog');
    grunt.loadNpmTasks('grunt-typescript-compile');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Default task(s).
    grunt.registerTask('default', ['changelog', 'typescript', 'uglify']);
};
