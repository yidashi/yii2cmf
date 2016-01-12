var fs = require('fs');
var path = require('path');
var marked = require('marked');
var cardinal = require('cardinal');
var xtend = require('xtend');
var color = require('./color');

var defaultOptions = {
    collapseNewlines: true,
    space: '',
    hrStart: '',
    hrEnd: '',
    headingStart: '\n',
    headingEnd: '\n\n',
    headingIndentChar: '#',
    codeStart: '\n',
    codeEnd: '\n\n',
    codePad: '    ',
    blockquoteStart: '\n',
    blockquoteEnd: '\n\n',
    blockquoteColor: 'blockquote',
    blockquotePad: '  > ',
    blockquotePadColor: 'syntax',
    listStart: '\n',
    listEnd: '\n',
    listItemStart: '',
    listItemEnd: '\n',
    listItemColor: 'ul',
    listItemPad: '  * ',
    listItemPadColor: 'syntax',
    paragraphStart: '',
    paragraphEnd: '\n'
};

var tokens;
var inline;
var token;
var blockDepth = 0;

function processInline(src, options) {
    var out = '';
    var cap;

    function outLink (title, href) {
        out += '[' + color(title, 'strong') + '](' + color(href, 'link') + ')';
    }

    while (src) {
        // escape
        if (cap = inline.rules.escape.exec(src)) {
          src = src.substring(cap[0].length);
          out += cap[1];
          continue;
        }

        // code
        if (cap = inline.rules.code.exec(src)) {
            src = src.substring(cap[0].length);
            out += color(cap[2], 'code');
            continue;
        }

        // autolink
        if (cap = inline.rules.autolink.exec(src)) {
            src = src.substring(cap[0].length);
            out += color(cap[0], 'link');
            continue;
        }

        // url (gfm)
        if (cap = inline.rules.url.exec(src)) {
            src = src.substring(cap[0].length);
            outLink(cap[1], cap[1]);
          continue;
        }

        // tag
        if (cap = inline.rules.tag.exec(src)) {
            src = src.substring(cap[0].length);
            out += cap[0];
            continue;
        }

        // link
        if (cap = inline.rules.link.exec(src)) {
            src = src.substring(cap[0].length);
            outLink(cap[1], cap[2]);
            continue;
        }

        // reflink, nolink
        if ((cap = inline.rules.reflink.exec(src))
                || (cap = inline.rules.nolink.exec(src))) {
            src = src.substring(cap[0].length);
            out += cap[0];
            continue;
        }

        // strong
        if (cap = inline.rules.strong.exec(src)) {
            src = src.substring(cap[0].length);
            out += color(processInline(cap[2] || cap[1]), 'strong');
            continue;
        }

        // em
        if (cap = inline.rules.em.exec(src)) {
            src = src.substring(cap[0].length);
            out += color(processInline(cap[2] || cap[1]), 'em');
            continue;
        }

        // br
        if (cap = inline.rules.br.exec(src)) {
            src = src.substring(cap[0].length);
            out += '\n';
            continue;
        }

        // del (gfm)
        if (cap = inline.rules.del.exec(src)) {
            src = src.substring(cap[0].length);
            out += color(processInline(cap[1]), 'del');
            continue;
        }

        // text
        if (cap = inline.rules.text.exec(src)) {
            src = src.substring(cap[0].length);
            out += cap[0];
            continue;
        }

        if (src) {
          throw new Error('Infinite loop on byte: ' + src.charCodeAt(0));
        }
    }

    return out;
}

function processToken(options) {
    var type = token.type;
    var text = token.text;
    var content;

    switch (type) {
        case 'space': {
            return options.space;
        }
        case 'hr': {
            var hrStr = new Array(80).join('-') + '\n';
            return options.hrStart + color(hrStr, type) + options.hrEnd;
        }
        case 'heading': {
            var syntaxFlag = color(
                Array(token.depth + 1).join(options.headingIndentChar),
                'syntax'
            );
            text = processInline(text);
            content = color(text, type);

            return options.headingStart + syntaxFlag + ' ' + content + options.headingEnd;
        }
        case 'code': {
            content = '';

            try {
                content = cardinal.highlight(text);
            }
            catch (e) {
                content = color(text, type);
            }
            
            content = blockFormat(content, {
                pad_str: options.codePad
            });

            return options.codeStart + content + options.codeEnd;
        }
        case 'table': {
            // TODO
        }
        case 'blockquote_start': {
            content = '';
            blockDepth++;

            while (next().type !== 'blockquote_end') {
                content += processToken(options);
            }
            content = blockFormat(content, {
                block_color: options.blockquoteColor,
                pad_str: options.blockquotePad,
                pad_color: options.blockquotePadColor
            });

            blockDepth--;
            return options.blockquoteStart + content + options.blockquoteEnd;
        }
        case 'list_start': {
            content = '';

            while (next().type !== 'list_end') {
                content += processToken(options);
            }

            return options.listStart + content + options.listEnd;
        }
        case 'list_item_start': {
            content = '';

            while (next().type !== 'list_item_end') {
                if (type === 'text') {
                    content += text;
                } else {
                    content += processToken(options);
                }
            }
            content = blockFormat(content, {
                block_color: options.listItemColor,
                pad_str: options.listItemPad,
                pad_color: options.listItemPadColor
            });
            return options.listItemStart + content + options.listItemEnd;
        }
        case 'paragraph': {
            if (blockDepth > 0) {
                return text;
            }
            text = processInline(text);
            return options.paragraphStart + color(text, type) + options.paragraphEnd;
        }
        default: {
            if (text) {
                return text;
            }
        }
    }
}

function next() {
    return token = tokens.shift();
}

function blockFormat(src, opts) {
    opts = opts || {};

    var lines = src.split('\n');
    var padStr = opts.pad_str || '';
    var padColor = opts.pad_color || opts.block_color;
    var retLines = [];

    if (padColor) {
        padStr = color(padStr, padColor);
    }

    lines.forEach(function(line) {
        if (opts.block_color) {
            line = color(line, opts.block_color);
        }
        retLines.push(padStr + line);
    });

    return retLines.join('\n');
}

exports.parse = function(text, options) {
    tokens = marked.lexer(text);
    inline = new marked.InlineLexer(tokens.links);
    options = xtend(defaultOptions, options);

    var outputArr = [];
    var output;

    while (next()) {
        outputArr.push(processToken(options));
    }

    if (options.collapseNewlines) {
        output = outputArr.join('').replace(/\n\n\n/g, '\n\n');
    }

    tokens = null;
    token = null;

    return output;
}

exports.parseFile = function(file, options) {
    var filePath = path.resolve(__dirname, file);
    var ret = '';
    
    try {
        var text = fs.readFileSync(filePath).toString();
        ret = exports.parse(text, options);
    }
    catch (e) {
        throw e;
    }

    return ret;
}
