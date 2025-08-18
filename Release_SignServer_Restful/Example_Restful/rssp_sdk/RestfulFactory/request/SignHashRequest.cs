
using Newtonsoft.Json;
using Newtonsoft.Json.Converters;
using System;

namespace RSSPAPI
{
    class SignHashRequest : Request
    {

        public SignHashRequest()
        {
            this.validityPeriod = 300;
            this.operationMode = OperationMode.S;
        }

        public string agreementUUID { get; set; }
        public string credentialID { get; set; }
        public string SAD { get; set; }

        public DocumentDigests documentDigests { get; set; }
        [JsonConverter(typeof(StringEnumConverter))]
        public Nullable<SignAlgo> signAlgo { get; set; }
        public string signAlgoParams { get; set; }
        
        [JsonConverter(typeof(StringEnumConverter))]
        public OperationMode operationMode { get; set; }
        public string scaIdentity { get; set; }
        public string responseURI { get; set; }
        public int validityPeriod { get; set; }

        public ClientInfo clientInfo { get; set; }
    }
}
