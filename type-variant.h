
// HHVM Variant to msgpack implementation

#ifndef MSGPACK_TYPE_VARIANT_H__
#define MSGPACK_TYPE_VARIANT_H__

#include "hphp/runtime/base/base-includes.h"
#include "msgpack/object.hpp"

using namespace HPHP;

// TODO catch bad_cast exception???

namespace msgpack {

// Unpack
inline Variant& operator>> (object o, Variant& v)
{
  switch(o.type) {
    case type::NIL:
      v.setNull();
      break;
    case type::BOOLEAN:
      v = o.via.boolean ? true : false;
      break;
    case type::POSITIVE_INTEGER:
      v = (int64_t) o.via.u64;
      break;
    case type::NEGATIVE_INTEGER:
      v = (int64_t) o.via.i64;
      break;
	  case type::DOUBLE:
      v = o.via.dec;
      break;
	  case type::RAW:
      v = String((char*)o.via.raw.ptr, o.via.raw.size, AttachString);
      break;
	  case type::ARRAY: {
      Array array = Array::Create();
		  if(o.via.array.size != 0) {
        object* p(o.via.array.ptr);
        for(object* const pend(o.via.array.ptr + o.via.array.size);
            p < pend; ++p) {
          Variant item;
          Variant& item_ref = item;
          *p >> item;
          array.append(item_ref);
        }
      }

      v = array;
      break;
    }
    default:
      break;
  }

  return v;
}

// Pack
template <typename Stream>
inline packer<Stream>& operator<< (packer<Stream>& o, const Variant& v)
{
  switch (v.getType()) {
    case KindOfUninit:
    case KindOfNull:
      o.pack_nil();
      break;
    case KindOfBoolean:
      if (v.asBooleanVal()) {
        o.pack_true();
      } else {
        o.pack_false();
      }
      break;
    case KindOfInt64:
      o.pack_int64(v.asInt64Val());
      break;
    case KindOfDouble:
      o.pack_double(v.asDoubleVal());
      break;
    case KindOfStaticString:
    case KindOfString: {
      String str = v.toString();
      o.pack_raw(str.size());
      o.pack_raw_body(str.c_str(), str.size());
      break;
    }
    case KindOfArray: {
      if (v.toArray()->isVectorData()) {
        o.pack_array(v.toArray().size());
        for (ArrayIter iter(v.toArray()); iter; ++iter) {
          o << iter.second();
        }
      } else {

      }
      break;
    }
    default:
      break;
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

