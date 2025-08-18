
namespace RSSPAPI
{
    class CertificateRequest : Request
    {
        public string agreementUUID { get; set; }
        public string certificates { get; set; }
        public bool certInfoEnabled { get; set; }
        public bool authInfoEnabled { get; set; }
    }
}
