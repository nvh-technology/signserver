
namespace RSSPAPI
{
    public class CertificateAuthority : Response
    {
        public string name { get; set; }
        public string description { get; set; }
        public string notBefore { get; set; }
        public string notAfter { get; set; }
        public string[] certificates { get; set; }
    }
}
