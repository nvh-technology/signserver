using System;

namespace RSSPAPI
{
    class LoginResponse : Response
    {
        public String accessToken;
        public String refreshToken;
        public int remainingCounter;
        public int tempLockoutDuration;
    }
}
