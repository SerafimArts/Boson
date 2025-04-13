cmake_minimum_required(VERSION 3.21)
project(boson LANGUAGES CXX VERSION 5.0.0)

set(COPYRIGHT "Copyright (c) Nesmeyanov Kirill")
set(VENDOR "Boson")
set(DESCRIPTION "PHP WebView Bindings")
set(VERSION "1.0.0")
set(OUTPUT_NAME "libboson")

add_compile_definitions(BOSON_COPYRIGHT=${COPYRIGHT})
add_compile_definitions(BOSON_VENDOR=${VENDOR})
add_compile_definitions(BOSON_DESCRIPTION=${DESCRIPTION})
add_compile_definitions(BOSON_VERSION=${VERSION})

if(WIN32)
    set(OUTPUT_NAME "${OUTPUT_NAME}-windows")
elseif(APPLE)
    set(OUTPUT_NAME "${OUTPUT_NAME}-darwin")
else()
    set(OUTPUT_NAME "${OUTPUT_NAME}-linux")
endif()

if(APPLE)
  set(CMAKE_OSX_ARCHITECTURES "arm64;x86_64" CACHE STRING "Build universal binary" FORCE)
endif()

if(CMAKE_SYSTEM_PROCESSOR MATCHES "x86_64|AMD64")
    set(OUTPUT_NAME "${OUTPUT_NAME}-amd64")
elseif(CMAKE_SYSTEM_PROCESSOR MATCHES "i[3-6]86|^x86$")
    set(OUTPUT_NAME "${OUTPUT_NAME}-x86")
elseif(CMAKE_SYSTEM_PROCESSOR MATCHES "arm|aarch64")
    set(OUTPUT_NAME "${OUTPUT_NAME}-arm64")
endif()

# --------------------------------------------------------------------------------------------------------
# CMake options
# --------------------------------------------------------------------------------------------------------

set(CMAKE_CXX_STANDARD 23)
set(CMAKE_CXX_STANDARD_REQUIRED ON)
set(CMAKE_RUNTIME_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/bin)
set(CMAKE_LIBRARY_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/bin)
set(CMAKE_ARCHIVE_OUTPUT_DIRECTORY "${CMAKE_BINARY_DIR}/lib")
set(CMAKE_POSITION_INDEPENDENT_CODE ON)

# --------------------------------------------------------------------------------------------------------
# Setup Dependencies
# --------------------------------------------------------------------------------------------------------

include(FetchContent)

set(saucer_static ON CACHE BOOL "Build a static library" FORCE)
set(saucer_modules OFF CACHE BOOL "Disable module support" FORCE)

set(ENV{GIT_TERMINAL_PROMPT} 0)

FetchContent_Declare(
    lockpp
    GIT_REPOSITORY https://github.com/Curve/lockpp
    GIT_TAG v3.0
)
FetchContent_MakeAvailable(lockpp)

include_directories(${lockpp_SOURCE_DIR}/include)

FetchContent_Declare(
    saucer
    GIT_REPOSITORY https://github.com/saucer/saucer
    GIT_TAG v6.0.1)
FetchContent_MakeAvailable(saucer)

FetchContent_Declare(
    saucer-bindings
    GIT_REPOSITORY https://github.com/saucer/bindings
    GIT_TAG v6.0.0)
FetchContent_MakeAvailable(saucer-bindings)

# --------------------------------------------------------------------------------------------------------
# Setup library
# --------------------------------------------------------------------------------------------------------

add_library(${PROJECT_NAME} SHARED "src/boson.cpp")

target_compile_definitions(${PROJECT_NAME} PRIVATE BOSON_BUILD)

target_link_libraries(${PROJECT_NAME} PRIVATE cr::lockpp)

target_link_libraries(${PROJECT_NAME} PRIVATE saucer::saucer)

target_compile_features(${PROJECT_NAME} PRIVATE cxx_std_23)

set_target_properties(${PROJECT_NAME} PROPERTIES CXX_STANDARD 23 CXX_EXTENSIONS OFF CXX_STANDARD_REQUIRED ON)
set_target_properties(${PROJECT_NAME} PROPERTIES PREFIX "")
set_target_properties(${PROJECT_NAME} PROPERTIES OUTPUT_NAME ${OUTPUT_NAME})
if(WIN32)
    set_target_properties(${PROJECT_NAME} PROPERTIES SUFFIX ".dll")
elseif(APPLE)
    set_target_properties(${PROJECT_NAME} PROPERTIES SUFFIX ".dylib")
else()
    set_target_properties(${PROJECT_NAME} PROPERTIES SUFFIX ".so")
endif()


if (PROJECT_IS_TOP_LEVEL AND NOT MSVC AND NOT CMAKE_CXX_SIMULATE_ID MATCHES "MSVC")
    target_compile_options(${PROJECT_NAME} PRIVATE
        -Wall -Wextra -Wpedantic -Werror -pedantic -pedantic-errors -Wfatal-errors)
endif()

if (NOT MSVC)
    target_compile_options(${PROJECT_NAME} PRIVATE
        -Wno-unknown-warning-option -Wno-missing-field-initializers -Wno-cast-function-type)
endif()

# --------------------------------------------------------------------------------------------------------
# Include directories
# --------------------------------------------------------------------------------------------------------

target_include_directories(${PROJECT_NAME} PRIVATE ${lockpp_SOURCE_DIR}/include)
target_include_directories(saucer PRIVATE ${lockpp_SOURCE_DIR}/include)

target_include_directories(${PROJECT_NAME} PUBLIC
    $<BUILD_INTERFACE:${saucer-bindings_SOURCE_DIR}/include>)

target_include_directories(${PROJECT_NAME} PRIVATE
    $<BUILD_INTERFACE:${saucer-bindings_SOURCE_DIR}/include/saucer>
    $<BUILD_INTERFACE:${saucer-bindings_SOURCE_DIR}/private>)

target_sources(${PROJECT_NAME} PRIVATE
    ${saucer-bindings_SOURCE_DIR}/src/app.cpp
    ${saucer-bindings_SOURCE_DIR}/src/options.cpp
    ${saucer-bindings_SOURCE_DIR}/src/memory.cpp
    ${saucer-bindings_SOURCE_DIR}/src/icon.cpp
    ${saucer-bindings_SOURCE_DIR}/src/stash.cpp
    ${saucer-bindings_SOURCE_DIR}/src/script.cpp
    ${saucer-bindings_SOURCE_DIR}/src/scheme.cpp
    ${saucer-bindings_SOURCE_DIR}/src/navigation.cpp
    ${saucer-bindings_SOURCE_DIR}/src/preferences.cpp
    ${saucer-bindings_SOURCE_DIR}/src/window.cpp
    ${saucer-bindings_SOURCE_DIR}/src/webview.cpp)

