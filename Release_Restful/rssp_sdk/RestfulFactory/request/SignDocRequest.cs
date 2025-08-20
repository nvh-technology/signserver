
using Newtonsoft.Json;
using Newtonsoft.Json.Converters;
using System;
using System.Collections.Generic;

namespace RSSPAPI
{
    class SignDocRequest : Request
    {

        public SignDocRequest()
        {
            this.validityPeriod = 300;
            this.operationMode = OperationMode.S;
            this.signatureFormat = SignatureFormat.P;
            this.conformanceLevel = ConformanceLevel.B_B;
        }

        public string agreementUUID { get; set; }
        public string credentialID { get; set; }
        public string SAD { get; set; }

        public List<byte[]> documents { get; set; }
        [JsonConverter(typeof(StringEnumConverter))]
        public Nullable<HashAlgorithmOID> hashAlgorithmOID;
        [JsonConverter(typeof(StringEnumConverter))]
        public Nullable<SignAlgo> signAlgo { get; set; }
        public string signAlgoParams { get; set; }

        [JsonConverter(typeof(StringEnumConverter))]
        public SignatureFormat signatureFormat { get; set; }
        [JsonConverter(typeof(StringEnumConverter))]
        public ConformanceLevel conformanceLevel { get; set; }
        public String signedEnvelopeProperty { get; set; }
        public Dictionary<SignedPropertyType, Object> signedProps { get; set; }


        [JsonConverter(typeof(StringEnumConverter))]
        public OperationMode operationMode { get; set; }
        public string scaIdentity { get; set; }
        public string responseURI { get; set; }
        public int validityPeriod { get; set; }

        public ClientInfo clientInfo { get; set; }
    }
}
