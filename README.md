msgpack-hhvm
============

Build Status: [![Build Status](https://secure.travis-ci.org/reeze/msgpack-hhvm.png)](http://travis-ci.org/reeze/msgpack-hhvm)

Msgpack for HHVM, It is a msgpack binding for HHVM

# API

- msgpack_pack(mixed $input) : string;
  pack a input to msgpack, object and resource are not supported, array and other types supported,
  false on failure.
- msgpack_unpack(string $pac) : mixed;
  unpack a msgpack.

# Installation

```bash
$ git clone https://github.com/reeze/msgpack-hhvm
$ cd msgpack-hhvm
$ hphpize && cmake . && make
$ cp msgpack.so /path/to/your/hhvm/ext/dir
```

If you don't have `hphpize` program, please intall package `hhvm-dev`

```bash
$ sudo apt-get install hhvm-dev
```

# Contribution and  Issues

Feel free to send Pull Requests for bug report at: <http://github.com/reeze/msgpack-hhvm/issues>

# Authors

- Reeze Xia <reeze@php.net>
