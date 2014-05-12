
// HHVM Variant to msgpack implementation

#ifndef MSGPACK_TYPE_VARIANT_H__
#define MSGPACK_TYPE_VARIANT_H__

#include "hphp/runtime/base/base-includes.h"

#include <msgpack.hpp>

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
    case type::MAP: {
      Array array = Array::Create();
      if(o.via.map.size != 0) {
        object_kv* p(o.via.map.ptr);
        for(object_kv* const pend(o.via.map.ptr + o.via.map.size);
          p < pend; ++p) {
          Variant key, val;
          p->key >> key;
          p->val >> val;
          array.set(key, val, true);
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
      Array array = v.toArray();
      if (array->isVectorData()) {
        o.pack_array(array.size());
        for (ArrayIter iter(array); iter; ++iter) {
          o << iter.second();
        }
      } else {
        o.pack_map(array.size());
        for (ArrayIter iter(array); iter; ++iter) {
          o << iter.first();
          o << iter.second();
        }
      }
      break;
    }
    default:
      break;
  }

  return o;
}

}  // namespace msgpack

#endif
