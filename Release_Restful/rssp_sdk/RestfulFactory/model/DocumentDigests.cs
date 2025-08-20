using Newtonsoft.Json;
using Newtonsoft.Json.Converters;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RSSPAPI
{
    public class DocumentDigests
    {
        public List<byte[]> hashes { get; set; }
        [JsonConverter(typeof(StringEnumConverter))]
        public Nullable<HashAlgorithmOID> hashAlgorithmOID { get; set; }
    }
}
