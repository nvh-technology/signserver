namespace RSSPAPI
{
    class BaseCertificateInfo
    {
        public string status { get; set; }
        public string statusDesc { get; set; }
        public string[] certificates { get; set; }
        public string csr { get; set; }
        public string credentialID { get; set; }
        public string issuerDN { get; set; }
        public string serialNumber { get; set; }
        public string thumbprint { get; set; }
        public string subjectDN { get; set; }
        public string validFrom { get; set; }
        public string validTo { get; set; }
        public string purpose { get; set; }
        public int version { get; set; }
        public string multisign { get; set; }
        public int numSignatures { get; set; }
        public int remainingSigningCounter { get; set; }
        public string authorizationEmail { get; set; }
        public string authorizationPhone { get; set; }
        public CertificateProfile certificateProfile { get; set; }
        public CertificateAuthority certificateAuthority { get; set; }
    }
}
