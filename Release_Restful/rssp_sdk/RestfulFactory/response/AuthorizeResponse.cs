using System;

namespace RSSPAPI
{
    class AuthorizeResponse : Response
    {
        public String SAD;
        public int expiresIn;
        public int remainingCounter;
        public int tempLockoutDuration;
    }
}
