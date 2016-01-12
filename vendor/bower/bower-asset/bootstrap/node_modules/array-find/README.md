# array-find
Find array elements. Executes a callback for each element, returns the first element for which its callback returns a truthy value.

## Usage

```javascript
var find = require('array-find');
var array = [1,2,3,4];

find(array, function (element, index, arr) {
  return element === 2;
});
// => 2

```
Optionally pass in an object as third argument to use as ``this`` when executing callback. 

## Install

```bash
$ npm install array-find
```
