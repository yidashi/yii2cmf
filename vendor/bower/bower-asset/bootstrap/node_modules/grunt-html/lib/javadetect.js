'use strict';

var exec = require('child_process').exec;

module.exports = function(callback) {
  exec('java -version', function(error, stdout, stderr) {
    if (error) {
      return callback(error);
    }

    callback(null, {
      version: stderr.match(/(?:java|openjdk) version "(.*)"/)[1],
      arch: stderr.match(/64-Bit/) ? 'x64' : 'ia32'
    });
  });
};
