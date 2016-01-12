# safe-json-parse

[![build status][1]][2] [![dependency status][3]][4]

<!-- [![browser support][5]][6] -->

Parse JSON safely without throwing

## Example (callback)

```js
var safeParse = require("safe-json-parse/callback")

safeParse("{}", function (err, json) {
    /* we have json */
})

safeparse("WRONG", function (err) {
    /* we have err! */
})
```

## Example (tuple)

```js
var safeParse = require("safe-json-parse/tuple")

var tuple1 = safeParse("{}")
var json = tuple1[1] /* we have json */

var tuple2 = safeparse("WRONG")
var err = tuple[0] /* we have err! */

var tuple3 = safeParse(something)
if (tuple3[0]) {
    var err = tuple3[0]
    // handle err
} else {
    var json = tuple3[1]
    // handle json
}
```

## Installation

`npm install safe-json-parse`

## Contributors

 - Raynos

## MIT Licenced


  [1]: https://secure.travis-ci.org/Raynos/safe-json-parse.png
  [2]: https://travis-ci.org/Raynos/safe-json-parse
  [3]: https://david-dm.org/Raynos/safe-json-parse.png
  [4]: https://david-dm.org/Raynos/safe-json-parse
  [5]: https://ci.testling.com/Raynos/safe-json-parse.png
  [6]: https://ci.testling.com/Raynos/safe-json-parse
