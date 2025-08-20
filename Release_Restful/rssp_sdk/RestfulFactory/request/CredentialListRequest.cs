
namespace RSSPAPI
{
    class CredentialListRequest : CertificateRequest
    {
        public SearchConditions searchConditions { get; set; }

        public string userID { get; set; }
    }
}
