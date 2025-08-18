using System;

namespace RSSPAPI
{
    class LoginRequest : Request
    {
        public String relyingParty { get; set; }
        public bool rememberMeEnabled { get; set; }
    }
}
