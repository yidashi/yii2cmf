'use strict';

var path = require('path');
var chalk = require('chalk');

// Default Grunt reporter
var defaultReporter = function (result) {
  var out = result.map(function(message) {
    var output = chalk.cyan(message.file) + ' ';
    output += chalk.red('[') + chalk.yellow('L' + message.lastLine) +
      chalk.red(':') + chalk.yellow('C' + message.lastColumn) + chalk.red('] ');
    output += message.message;
    return output;
  });
  return out.join('\n');
},

// Select a reporter (if not using the default Grunt reporter)
selectReporter = function (options) {
  if (options.reporter === 'checkstyle') {
    // Checkstyle XML reporter
    options.reporter = '../lib/reporters/checkstyle.js';
  } else if (options.reporter === 'json') {
    // JSON reporter
    options.reporter = '../lib/reporters/json.js';
  } else if (options.reporter !== null && options.reporter !== undefined) {
    // Custom reporter
    options.reporter = path.resolve(process.cwd(), options.reporter);
  }

  var reporter;
  if (options.reporter) {
    reporter = require(options.reporter);
  } else {
    reporter = defaultReporter;
  }

  return reporter;
};

module.exports = {
  defaultReporter: defaultReporter,
  selectReporter: selectReporter
};
