
using Newtonsoft.Json;
using Newtonsoft.Json.Converters;

namespace RSSPAPI
{
    public class CertificateInfo : BaseCertificateInfo
    {
        public string sharedMode { get; set; }
        public string createdRP { get; set; }
        public string[] authModes { get; set; }
        [JsonConverter(typeof(StringEnumConverter))]
        public AuthMode authMode { get; set; }
        public int SCAL { get; set; }
        public string contractExpirationDate { get; set; }
        public bool defaultPassphraseEnabled { get; set; }
        public bool trialEnabled { get; set; }

        //public int multisign { get; set; }
        //public int remainingSigningCounter { get; set; }
        //public string authorizationEmail { get; set; }
        //public string authorizationPhone { get; set; }

    }
}
