'use strict';

module.exports = function (files, maxChars) {
  var filesChunk = [];
  var chunk = '';

  for (var f = 0; f < files.length; f++) {
    if (chunk.length + (files[f].length + 1) > maxChars) {
      filesChunk.push(chunk);
      chunk = '';
    }
    chunk += '"' + files[f] + '" ';
  }
  filesChunk.push(chunk);
  return filesChunk;
};
