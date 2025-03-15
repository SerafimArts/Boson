cmake_minimum_required(VERSION 3.30)
project(webview LANGUAGES C CXX)

set(COPYRIGHT "Copyright (c) Nesmeyanov Kirill")
set(VENDOR "WebView")
set(DESCRIPTION "PHP WebView Bindings")
set(VERSION_BASE "1.0.0")
set(VERSION "1.0.0")
set(CMAKE_C_STANDARD 11)

if (WIN32)
    set(OUTPUT_NAME "libwebview")
else ()
    set(OUTPUT_NAME "webview")
endif ()

set(CMAKE_RUNTIME_OUTPUT_DIRECTORY $<1:${CMAKE_SOURCE_DIR}/bin>)
set(CMAKE_LIBRARY_OUTPUT_DIRECTORY $<1:${CMAKE_SOURCE_DIR}/bin>)
set(CMAKE_ARCHIVE_OUTPUT_DIRECTORY "${CMAKE_BINARY_DIR}/lib")

include(FetchContent)

FetchContent_Declare(
    webview_source
    GIT_REPOSITORY https://github.com/webview/webview
    GIT_TAG 0.12.0)
FetchContent_MakeAvailable(webview_source)

add_library(webview STATIC resources/bindings/bindings.c)

set_property(TARGET webview_core_shared PROPERTY VERSION)
set_property(TARGET webview_core_shared PROPERTY SOVERSION)
set_property(TARGET webview_core_shared PROPERTY OUTPUT_NAME "${OUTPUT_NAME}")
set_property(TARGET webview_core_shared PROPERTY EXPORT_NAME "${EXPORT_NAME}")

target_link_libraries(webview PUBLIC webview_core_shared)
