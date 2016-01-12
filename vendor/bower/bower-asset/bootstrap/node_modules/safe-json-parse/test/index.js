var test = require("tape")

var safeParse = require("../callback")
var safeParseTuple = require("../tuple")

test("safeParse is a function", function (assert) {
    assert.equal(typeof safeParse, "function")
    assert.end()
})

test("safeParse valid json", function (assert) {
    safeParse("{ \"foo\": true }", function (err, json) {
        assert.ifError(err)
        assert.equal(json.foo, true)

        assert.end()
    })
})

test("safeParse faulty", function (assert) {
    safeParse("WRONG", function (err) {
        assert.ok(err)
        assert.equal(err.message, "Unexpected token W")

        assert.end()
    })
})

test("safeParseTuple valid json", function (assert) {
    var t = safeParseTuple("{ \"foo\": true }")

    assert.ifError(t[0])
    assert.equal(t[1].foo, true)

    assert.end()
})

test("safeParseTuple faulty", function (assert) {
    var t = safeParseTuple("WRONG")

    assert.ok(t[0])
    assert.equal(t[0].message, "Unexpected token W")

    assert.end()
})
