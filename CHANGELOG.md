# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

**Library has been completely overwritten without backward compatibility with
previous releases.**

### Added
- `JsonValue` interface.
- `JsonValueType` enumeration.
- `JsonNull` value object.
- `JsonString` value object.
- `JsonBoolean` value object.
- `JsonNumber` value object.
- `JsonStructure` interface.

### Removed
- `AbstractConfiguration`
- `Codec`
- `CodecInterface`
- `Decoder`
- `DecoderConfiguration`
- `DecoderInterface`
- `Encoder`
- `EncoderConfiguration`
- `EncoderInterface`
- `Exception/JsonException`
- `Json`


## [0.1.1] - 2016-03-09
### Changed
- `LitGroup\Json\Json` now defined as final.

## [0.1.0] - 2016-02-18
- Initial version