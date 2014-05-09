

link_directories(deps/msgpack)
include_directories(deps/msgpack)

HHVM_EXTENSION(msgpack ext_msgpack.cpp)
HHVM_SYSTEMLIB(msgpack ext_msgpack.php)

add_subdirectory(deps/msgpack)
add_dependencies(msgpack msgpack-c)

target_link_libraries(msgpack -lmsgpack-c)
