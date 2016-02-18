JSON
====

[![Build Status](https://travis-ci.org/LitGroup/json.php.svg?branch=master)](https://travis-ci.org/LitGroup/json.php)

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

// set decode options:
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