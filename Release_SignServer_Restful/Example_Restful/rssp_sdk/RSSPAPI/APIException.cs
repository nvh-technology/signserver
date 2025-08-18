using System;

namespace RSSPAPI
{
    class APIException : Exception
    {
        public int error { get; }
        public APIException (int code, String msg) : base(msg)
        {
            this.error = code;
        }

        public APIException( String msg) : base(msg)
        {
            this.error = -1;
        }
    }
}
