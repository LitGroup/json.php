JSON
====

[![Build Status](https://travis-ci.org/LitGroup/json.php.svg?branch=master)](https://travis-ci.org/LitGroup/json.php)

See documentation for the last release [here][currentdoc]

Examples Of Usage
-----------------

### Encoder

```php
use LitGroup\Json\Encoder;
use LitGroup\Json\EncoderConfiguration;

// Create configuration:
$configuration = new EncoderConfiguration();

// Set encode options:
$configuration
    ->setForceObject(true)
    ->setPrettyPrint(true)
;

// Create and use encoder:
$encoder = new Encoder($configuration);

$json = $encoder->encode(['country' => 'Russia', 'town' => 'Moscow']);
```

### Decoder

```php
use LitGroup\Json\Decoder;
use LitGroup\Json\DecoderConfiguration;

// Create configuration:
$configuration = new DecoderConfiguration();

// Set decode options:
$configuration
    ->setBigIntAsString(true)
;

// Create and use decoder:
$decoder = new Decoder($configuration)

$location = $decoder->decode('{"country": "Russia", "town": "Moscow"}');
```

### Codec

Codec can be useful to decrease amount of injections for components which
depends on both `EncoderInterface` and `DecoderInterface`.
`Codec` implements both interfaces: `EncoderInterface` and `DecoderInterface`.

```php
use LitGroup\Json\Encoder;
use LitGroup\Json\EncoderConfiguration;
use LitGroup\Json\Decoder;
use LitGroup\Json\DecoderConfiguration;
use LitGroup\Json\Codec;

// Create ancoder and decoder:
$encoder = new Encoder(new EncoderConfiguration());
$decoder = new Decoder(new DecoderConfiguration());

// Create codec:
$codec = new Codec($encoder, $decoder);

// Use as encoder or decoder:
$json = $codec->encode($value);
$value = $codec->decode($json);

// Get used encoder or decoder:
$encoder = $codec->getEncoder();
$decoder = $codec->getDecoder();
```

#### Singleton Codec

For simple applications can be useful a Singleton implementation of the `LitGroup\Json\CodecInterface`:

```php
Json::getInstance()->encode(...);
Json::getInstance()->decode(...);
```

Configuration Reference
-----------------------

### Encoder configuration

| Option               | Default   | Description                                                                  |
| -------------------- | --------- | ---------------------------------------------------------------------------- |
| MaxDepth             | `512`     | Maximum depth.                                                               |
| ForceObject          | `false`   | Outputs an object rather than an array when a non-associative array is used. |
| HexAmp               | `false`   | All `&`s are converted to `\u0026`.                                          |
| HexApos              | `false`   | All `'` are converted to `\u0027`.                                           |
| HexQuot              | `false`   | All `"` are converted to `\u0022`.                                           |
| HexTag               | `false`   | All `<` and `>` are converted to `\u003C` and `\u003E`.                      |
| NumericCheck         | `false`   | Encodes numeric strings as numbers.                                          |
| PartialOutputOnError | `false`   | Substitute some unencodable values instead of failing.                       |
| PrettyPrint          | `false`   | Use whitespace in returned data to format it.                                |
| UnescapedSlashes     | `true`    | Don't escape `/`.                                                            |
| UnescapedUnicode     | `true`    | Encode multibyte Unicode characters literally.                               |

### Decoder configuration

| Option   | Default   | Description                                                                        |
| -------- | --------- | ---------------------------------------------------------------------------------- |
| MaxDepth | `512`     | Maximum depth.                                                                     |
| UseAssoc | `true`    | If UseAssoc is enabled — JSON-object will be presented as a PHP associative array. |


Run Tests
---------

```bash
./tests.sh
```

To run tests with coverage:

```bash
./tests.sh --coverage
```

HTML-report with code coverage will be stored in the `build/coverage`.

LICENSE
-------

See [LICENSE](https://github.com/LitGroup/json.php/blob/master/LICENSE) file for details.


[currentdoc]: https://github.com/LitGroup/json.php/blob/v0.1.1/README.md