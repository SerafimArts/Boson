#ifndef EXPORT_HPP
#define EXPORT_HPP

#ifndef BOSON_EXPORT
    #ifdef SAUCER_EXPORT
        #define BOSON_EXPORT SAUCER_EXPORT
    #elif defined(_WIN32) || defined(_WIN64)
        #define BOSON_EXPORT __declspec(dllimport)
    #else
        #define BOSON_EXPORT __attribute__((visibility("default")))
    #endif
#endif

#endif //EXPORT_HPP
