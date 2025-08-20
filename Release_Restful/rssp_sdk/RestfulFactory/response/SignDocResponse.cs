using System;
using System.Collections.Generic;

namespace RSSPAPI
{
    class SignDocResponse : Response
    {
        public List<byte[]> documentWithSignature;
        public int remainingSigningCounter;

        public int remainingCounter;
        public int tempLockoutDuration;
    }
}
