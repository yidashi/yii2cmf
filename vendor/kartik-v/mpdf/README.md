mpdf
====

[![Latest Stable Version](https://poser.pugx.org/kartik-v/mpdf/v/stable)](https://packagist.org/packages/kartik-v/mpdf)
[![License](https://poser.pugx.org/kartik-v/mpdf/license)](https://packagist.org/packages/kartik-v/mpdf)
[![Total Downloads](https://poser.pugx.org/kartik-v/mpdf/downloads)](https://packagist.org/packages/kartik-v/mpdf)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/mpdf/d/monthly)](https://packagist.org/packages/kartik-v/mpdf)
[![Daily Downloads](https://poser.pugx.org/kartik-v/mpdf/d/daily)](https://packagist.org/packages/kartik-v/mpdf)

This is a fork of the [mPDF library](http://mpdf1.com/). mPDF is a PHP class which generates PDF files from UTF-8 encoded HTML. It is based on [FPDF](http://www.fpdf.org/) and [HTML2FPDF](http://html2fpdf.sourceforge.net/), with a number of enhancements.
It is slower than the original scripts e.g. HTML2FPDF and produces larger files when using Unicode fonts, but support for CSS styles etc. has been much enhanced.

See the [features](http://www.mpdf1.com/mpdf/index.php?page=Features) and/or [examples](http://www.mpdf1.com/mpdf/index.php?page=Examples).

This fork adds composer and packagist support.

Why this repo?
--------------

I needed this for building many of my dependent PHP based projects that use this wonderful PDF library. Managing package dependencies via a central repository was important for folks like me. I use composer to manage package dependencies via packages on packagist.org. This repository allows access to some specific features and needs:

1. Adds ability to update library and manage dependencies via composer in your PHP based applications
2. Uses the latest development version (v6.0beta) of the mPDF library. I needed the latest development version via composer, which was not found elsewhere. mPDF 6.0 can utilise OpenType layout tables to display complex scripts. It will be of most interest to those wishing to use Arabic or Indic scripts (as well as Khmer, Lao, Myanmar etc.). It will  also improve the display of Thai, Vietnamese and Hebrew.
3. This beta release (v6.0) contains fonts (open source) to cover almost every imaginable script / language. It also includes additional fonts for Chinese, Japanese, and Korean.

This [demo PDF](http://www.mpdf1.com/repos/example61_new_mPDF_v6-0_features.pdf) file explains what mPDF 6.0 can do, and acts as temporary documentation. The source file for this is also included as [example61_new_mPDF_v6-0_features.php](https://github.com/kartik-v/mpdf/blob/master/examples/example61_new_mPDF_v6-0_features.php) in the repository.

You can refer another [demo PDF file](http://www.mpdf1.com/repos/example_web.pdf) taken from a [UTF test web page](http://www.columbia.edu/~fdc/utf8/).

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require kartik-v/mpdf "dev-master"
```

or add

```
"kartik-v/mpdf": "dev-master"
```

to the ```require``` section of your `composer.json` file.

Refer the [readme instructions](https://github.com/kartik-v/mpdf/blob/master/README.txt) for other details on setting up the extension.


Usage
-----

PHP 5.4 and later can use namespaces to access. Refer the [official documentation manual](http://mpdf1.com/manual/index.php) at the [mpdf1 site](http://mpdf1.com) for further details and understanding of the library.

```php
use \mPDF;

$pdf = new mPDF();
```