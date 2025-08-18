using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RSSPAPI
{
    class ByteArrayConvertor : JsonConverter
    {
        public override bool CanConvert(Type objectType)
        {
            return objectType == typeof(byte[]);
        }

        public override object ReadJson(JsonReader reader, Type objectType, object existingValue, JsonSerializer serializer)
        {
            String arr = (String)existingValue;
            return Utils.Base64Decode((String)existingValue);
        }

        public override void WriteJson(JsonWriter writer, object value, JsonSerializer serializer)
        {
            byte[] arr = (byte[])value;
            writer.WriteRaw(Utils.Base64Encode(arr));
        }
    }
}
