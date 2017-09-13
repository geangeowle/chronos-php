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
        }
    });

    // Load the plugin that provides the "changelog" task.
    grunt.loadNpmTasks('grunt-changelog');

    // Default task(s).
    grunt.registerTask('default', ['changelog']);
};
