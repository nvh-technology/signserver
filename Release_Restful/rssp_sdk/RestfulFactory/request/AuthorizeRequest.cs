
using Newtonsoft.Json;
using Newtonsoft.Json.Converters;
using System;

namespace RSSPAPI
{
    class AuthorizeRequest : Request
    {

        public AuthorizeRequest()
        {
            this.validityPeriod = 300;
            this.operationMode = OperationMode.S;
        }

        public string agreementUUID { get; set; }
        public string credentialID { get; set; }
        public string authorizeCode { get; set; }

        public int numSignatures { get; set; }
        public DocumentDigests documentDigests { get; set; }
        public ClientInfo clientInfo { get; set; }

        public string notificationMessage { get; set; }
        public string messageCaption { get; set; }
        public string message { get; set; }

        public string logoURI { get; set; }
        public string bgImageURI { get; set; }
        public string rpIconURI { get; set; }
        public string rpName { get; set; }
        //public string confirmationPolicy { get; set; }
        public bool vcEnabled { get; set; }
        public bool acEnabled { get; set; }

        [JsonConverter(typeof(StringEnumConverter))]
        public OperationMode operationMode { get; set; }

        public string scaIdentity { get; set; }
        public string responseURI { get; set; }
        public int validityPeriod { get; set; }
        public string[] documents { get; set; }
        [JsonConverter(typeof(StringEnumConverter))]
        public Nullable<SignAlgo> signAlgo { get; set; }
        public string signAlgoParams { get; set; }
    }
}
