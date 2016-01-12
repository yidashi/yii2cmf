/*
 * Author: Josh Hagins
 * https://github.com/jawshooah
 *
 * Modified from the original by: Boy Baukema
 * https://github.com/relaxnow
 */

'use strict';

module.exports = function(results) {
  var path = require('path'),
    files = {},
    out = [],
    pairs = {
      '&': '&amp;',
      '"': '&quot;',
      '\'': '&apos;',
      '<': '&lt;',
      '>': '&gt;'
    };

  function encode(s) {
    for (var r in pairs) {
      if (typeof s !== 'undefined') {
        s = s.replace(new RegExp(r, 'g'), pairs[r]);
      }
    }
    return s || '';
  }

  results.forEach(function(result) {
    // Register the file
    result.file = path.normalize(result.file);
    if (!files[result.file]) {
      files[result.file] = [];
    }

    // Add the error
    files[result.file].push({
      severity: result.type,
      line: result.lastLine,
      column: result.lastColumn,
      message: result.message,
      source: 'htmllint.Validation' + (result.type === 'error' ? 'Error' : 'Warning')
    });
  });


  out.push('<?xml version="1.0" encoding="utf-8"?><checkstyle>');

  for (var fileName in files) {
    if (files.hasOwnProperty(fileName)) {
      out.push('\t<file name="' + fileName + '">');
      for (var i = 0; i < files[fileName].length; i++) {
        var issue = files[fileName][i];
        out.push(
          '\t\t<error ' +
            'line="' + issue.line + '" ' +
            'column="' + issue.column + '" ' +
            'severity="' + issue.severity + '" ' +
            'message="' + encode(issue.message) + '" ' +
            'source="' + issue.source + '" ' +
            '/>'
        );
      }
      out.push('\t</file>');
    }
  }

  out.push('</checkstyle>');

  return out.join('\n');
};
