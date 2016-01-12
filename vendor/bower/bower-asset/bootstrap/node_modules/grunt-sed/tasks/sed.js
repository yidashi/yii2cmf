// grunt-sed
// =========
// * GitHub: https://github.com/jharding/grunt-sed
// * Copyright (c) 2013 Jake Harding
// * Licensed under the MIT license.

module.exports = function(grunt) {
  var replace = require('replace')
    , _ = require('lodash')
    , log = grunt.log;

  grunt.registerMultiTask('sed', 'Search and replace.', function() {
    var data = this.data;

    if (!data.pattern) {
      log.error('Missing pattern property.');
      return;
    }

    if (_.isUndefined(data.replacement)) {
      log.error('Missing replacement property.');
      return;
    }

    data.path = data.path || '.';
    data.include = data.include || '';
    data.exclude = data.exclude || '';

    replace({
      regex: data.pattern
    , replacement: data.replacement
    , paths: _.isArray(data.path) ? data.path : [data.path]
    , include: _.isArray(data.include) ? _(data.include).toString() : data.include
    , exclude: _.isArray(data.exclude) ? _(data.exclude).toString() : data.exclude
    , recursive: data.recursive
    , quiet: grunt.option('verbose') ? false : true
    , silent: false
    , async: false
    });
  });
};
