
// HHVM Variant to msgpack implementation

#ifndef MSGPACK_TYPE_VARIANT_H__
#define MSGPACK_TYPE_VARIANT_H__

#include "hphp/runtime/base/base-includes.h"
#include "msgpack/object.hpp"

using namespace HPHP;

namespace msgpack {

// Unpack
inline Variant& operator>> (object o, Variant& v)
{
  if(o.type != type::RAW) { throw type_error(); }
  v = String((char*)o.via.raw.ptr, o.via.raw.size, AttachString);

  return v;
}

// Pack
template <typename Stream>
inline packer<Stream>& operator<< (packer<Stream>& o, const Variant& v)
{
  if (v.isString()) {
    String str = v.toString();
    o.pack_raw(str.size());
    o.pack_raw_body(str.c_str(), str.size());
  }

  return o;
}

inline void operator<< (object::with_zone& o, const Variant& v)
{
  if (v.isString()) {
    String str = v.toString();

    o.type = type::RAW;
    char* ptr = (char*)o.zone->malloc(str.size());
    o.via.raw.ptr = ptr;
    o.via.raw.size = (uint32_t)str.size();
    memcpy(ptr, str.c_str(), str.size());
  }
}

inline void operator<< (object& o, const Variant& v)
{
  if (v.isString()) {
    String str = v.toString();

    o.type = type::RAW;
    o.via.raw.ptr = str.c_str();
    o.via.raw.size = (uint32_t)str.size();
  }
}


}  // namespace msgpack

#endif

