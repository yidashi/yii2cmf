/*
 * grunt-contrib-cssmin
 * http://gruntjs.com/
 *
 * Copyright (c) 2015 Tim Branyen, contributors
 * Licensed under the MIT license.
 */

'use strict';

module.exports = function(grunt) {
  grunt.registerMultiTask( 'csslint', 'Lint CSS files with csslint', function() {
    var csslint = require( 'csslint' ).CSSLint;
    var stripJsonComments = require( 'strip-json-comments' );
    var ruleset = {};
    var verbose = grunt.verbose;
    var externalOptions = {};
    var combinedResult = {};
    var options = this.options();
    var path = require('path');
    var _ = require('lodash');
    var chalk = require('chalk');
    var absoluteFilePaths = options.absoluteFilePathsForFormatters || false;

    // Read CSSLint options from a specified csslintrc file.
    if (options.csslintrc) {
      var contents = grunt.file.read( options.csslintrc );
      externalOptions = JSON.parse( stripJsonComments( contents ) );
      // delete csslintrc option to not confuse csslint if a future release
      // implements a rule or options on its own
      delete options.csslintrc;
    }

    // merge external options with options specified in gruntfile
    options = _.assign( options, externalOptions );

    // if we have disabled explicitly unspecified rules
    var defaultDisabled = options['*'] === false;
    delete options['*'];

    csslint.getRules().forEach(function( rule ) {
      if ( options[ rule.id ] || ! defaultDisabled ) {
        ruleset[ rule.id ] = 1;
      }
    });

    for ( var rule in options ) {
      if ( !options[ rule ] ) {
        delete ruleset[rule];
      } else {
        ruleset[ rule ] = options[ rule ];
      }
    }
    var hadErrors = 0;
    this.filesSrc.forEach(function( filepath ) {
      var file = grunt.file.read( filepath ),
        message = 'Linting ' + chalk.cyan(filepath) + '...',
        result;

      // skip empty files
      if (file.length) {
        result = csslint.verify( file, ruleset );
        verbose.write( message );
        if (result.messages.length) {
          verbose.or.write( message );
          grunt.log.error();
        } else {
          verbose.ok();
        }

        // store combined result for later use with formatters
        combinedResult[filepath] = result;

        result.messages.forEach(function( message ) {
          var offenderMessage;
          if (typeof message.line !== 'undefined') {
            offenderMessage =
              chalk.yellow('L' + message.line) +
              chalk.red(':') +
              chalk.yellow('C' + message.col);
          } else {
            offenderMessage = chalk.yellow('GENERAL');
          }

          grunt.log.writeln(chalk.red('[') + offenderMessage + chalk.red(']'));
          grunt.log[ message.type === 'error' ? 'error' : 'writeln' ](
              message.type.toUpperCase() + ': ' +
              message.message + ' ' +
              message.rule.desc +
              ' (' + message.rule.id + ')' +
              ' Browsers: ' + message.rule.browsers
          );

          if (message.type === 'error' ) {
            hadErrors += 1;
          }
        });
      } else {
        grunt.log.writeln('Skipping empty file ' + chalk.cyan(filepath) + '.');
      }

    });

    // formatted output
    if (options.formatters && Array.isArray( options.formatters )) {
      options.formatters.forEach(function ( formatterDefinition ) {
        if (formatterDefinition.id && formatterDefinition.dest) {
          var formatter = csslint.getFormatter( formatterDefinition.id );
          if (formatter) {
            var output = formatter.startFormat();
            _.each( combinedResult, function ( result, filename ) {
              if (absoluteFilePaths) {
                filename = path.resolve(filename);
              }
              output += formatter.formatResults( result, filename, {});
            });
            output += formatter.endFormat();
            grunt.file.write( formatterDefinition.dest, output );
          }
        }
      });
    }

    if ( hadErrors ) {
      return false;
    }
    grunt.log.ok( this.filesSrc.length + grunt.util.pluralize(this.filesSrc.length, ' file/ files') + ' lint free.' );
  });
};
