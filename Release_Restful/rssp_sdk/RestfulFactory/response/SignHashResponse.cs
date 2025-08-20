using System;
using System.Collections.Generic;

namespace RSSPAPI
{
    class SignHashResponse : Response
    {
        public List<byte[]> signatures;
        public int remainingSigningCounter;

        public int remainingCounter;
        public int tempLockoutDuration;
    }
}
