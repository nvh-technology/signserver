using System;

namespace RSSPAPI
{
    public class Request
    {
        public Request()
        {
            this.profile = "rssp-119.432-v2.0";
            this.lang = "VN";
        }
        public String profile { get; set; }
        public String lang { get; set; }
        public String requestID { get; set; }
        public String rpRequestID { get; set; }
    }
}
