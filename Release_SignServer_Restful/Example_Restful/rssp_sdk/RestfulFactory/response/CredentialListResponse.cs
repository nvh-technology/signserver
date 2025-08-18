using System.Collections.Generic;

namespace RSSPAPI
{
    class CredentialListResponse : Response
    {
        public List<BaseCertificateInfo> certs { get; set; }
    }
}
