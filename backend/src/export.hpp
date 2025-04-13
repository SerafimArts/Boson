#pragma once

#if defined(_WIN32) || defined(__CYGWIN__)
  #ifdef BOSON_BUILD
    #define BOSON_API __declspec(dllexport)
  #else
    #define BOSON_API __declspec(dllimport)
  #endif
#else
  #define BOSON_API __attribute__((visibility("default")))
#endif
