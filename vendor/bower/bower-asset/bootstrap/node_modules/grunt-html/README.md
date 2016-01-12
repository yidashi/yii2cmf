# grunt-html

[![Linux Build Status](https://img.shields.io/travis/jzaefferer/grunt-html/master.svg?label=Linux%20build)](https://travis-ci.org/jzaefferer/grunt-html)
[![Windows Build status](https://img.shields.io/appveyor/ci/jzaefferer/grunt-html/master.svg?label=Windows%20build)](https://ci.appveyor.com/project/jzaefferer/grunt-html/branch/master)
[![Code Climate](https://img.shields.io/codeclimate/github/jzaefferer/grunt-html.svg)](https://codeclimate.com/github/jzaefferer/grunt-html)
[![Dependency Status](https://img.shields.io/david/jzaefferer/grunt-html.svg)](https://david-dm.org/jzaefferer/grunt-html)
[![devDependency Status](https://img.shields.io/david/dev/jzaefferer/grunt-html.svg)](https://david-dm.org/jzaefferer/grunt-html#info=devDependencies)

[Grunt][grunt] plugin for html validation, using the [vnu.jar markup checker][vnujar].

## Getting Started
Install this grunt plugin next to your project's [Gruntfile.js][getting_started] with:

```bash
npm install grunt-html --save-dev
```

Then add this line to your project's `Gruntfile.js`:

```js
grunt.loadNpmTasks('grunt-html');
```

Then specify what files to validate in your config:

```js
grunt.initConfig({
  htmllint: {
    all: ["demos/**/*.html", "tests/**/*.html"]
  }
});
```

For fast validation, keep that in a single group, as the validator initialization takes a few seconds.

## Options

### `ignore`

Type: `Array`, `String`, or `RegExp`  
Default: `null`

Use this to specify the error message(s) to ignore. For example:

```js
all: {
  options: {
    ignore: 'The “clear” attribute on the “br” element is obsolete. Use CSS instead.'
  },
  src: "html4.html"
}
```

The ignore option also supports regular expressions. For example, to ignore AngularJS directive attributes:

```js
all: {
  options: {
    ignore: /attribute “ng-[a-z-]+” not allowed/
  },
  src: "app.html"
}
```

### `force`

Type: `Boolean`  
Default: `false`

Set `force` to `true` to report errors but not fail the `grunt` task.

### `reporter`

Type: `String`  
Default: `null`

Allows you to modify the output format. By default, this plugin will use a built-in Grunt reporter. Set the path to your own custom reporter or to one of the provided reporters: `checkstyle` or `json`.

### `reporterOutput`

Type: `String`  
Default: `null`

Specify a filepath to output the results of a reporter. If `reporterOutput` is specified then all output will be written to the given filepath rather than printed to `stdout`.

### `absoluteFilePathsForReporter`

Type: `Boolean`  
Default: `false`

Set `absoluteFilePathsForReporter` to `true` to use absolute file paths in generated reports.

[grunt]: http://gruntjs.com/
[getting_started]: http://gruntjs.com/getting-started
[vnujar]: https://validator.github.io/validator/

## License
Copyright Jörn Zaefferer.  
Licensed under the MIT license.
