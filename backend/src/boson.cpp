#include "boson.hpp"
#include "export.hpp"

#define BOSON_STRING(value) #value
#define BOSON_STRING_EXPAND(value) BOSON_STRING(value)

extern "C"
{
    BOSON_API const char* boson_version()
    {
        #ifndef BOSON_VERSION
            #define unknown-dev
        #endif

        return BOSON_STRING_EXPAND(BOSON_VERSION) "";
    }
}
