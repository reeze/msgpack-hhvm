CMAKE_MINIMUM_REQUIRED(VERSION 2.8.7 FATAL_ERROR)

include_directories(${CMAKE_CURRENT_SOURCE_DIR})

add_library(msgpack-c STATIC gcc_atomic.cpp object.cpp objectc.c
		unpack.c vrefbuffer.c zone.c version.c)

set_target_properties(msgpack-c PROPERTIES COMPILE_FLAGS "-fPIC")
