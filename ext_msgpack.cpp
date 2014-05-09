/*
   +----------------------------------------------------------------------+
   | HipHop for PHP                                                       |
   +----------------------------------------------------------------------+
   | Copyright (c) 2010-2013 Facebook, Inc. (http://www.facebook.com)     |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
*/

#include "hphp/runtime/base/base-includes.h"

#include <msgpack.h>

namespace HPHP {

static int64_t HHVM_FUNCTION(msgpack_sum, int64_t a, int64_t b) {
  return a + b;
}

static class MsgpackExtension : public Extension {
 public:
  MsgpackExtension() : Extension("msgpack") {}
  virtual void moduleInit() {
    HHVM_FE(msgpack_sum);
    loadSystemlib();
  }
} s_msgpack_extension;

HHVM_GET_MODULE(msgpack)

} // namespace HPHP
