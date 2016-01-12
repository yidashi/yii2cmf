/*
 * Author: Josh Hagins
 * https://github.com/jawshooah
 */

'use strict';

module.exports = function(results) {
  results.forEach(function(result) {
    // result already has 'file' property, 'url' is redundant
    delete result.url;
  });
  return JSON.stringify(results);
};
