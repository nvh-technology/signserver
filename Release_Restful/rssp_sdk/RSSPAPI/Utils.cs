using System;
using System.Collections;
using System.Collections.Generic;
using System.Diagnostics;
using System.Security.Cryptography;
using System.Text;

namespace RSSPAPI
{
    class Utils
    {
        public static string getPKCS1Signature(string data, string key, string passkey)
        {
            MakeSignature mks = new MakeSignature(data, key, passkey);
            return mks.getSignature();
        }

        private static readonly DateTime Jan1st1970 = new DateTime(1970, 1, 1, 0, 0, 0, DateTimeKind.Utc);
        public static long CurrentTimeMillis()
        {
            return (long)(DateTime.UtcNow - Jan1st1970).TotalMilliseconds;
        }

        private static long nanoTime()
        {
            long nano = 10000L * Stopwatch.GetTimestamp();
            nano /= TimeSpan.TicksPerMillisecond;
            nano *= 100L;
            return nano;
        }

        internal static string Base64Encode(string plainText)
        {
            var plainTextBytes = System.Text.Encoding.UTF8.GetBytes(plainText);
            return System.Convert.ToBase64String(plainTextBytes);
        }

        public static String Base64Encode(byte[] rawData)
        {
            //Console.WriteLine(Encoding.Default.GetString(rawData));
            var data = System.Convert.ToBase64String(rawData);
            return data;
            //return System.Text.Encoding.UTF8.GetBytes(data);
        }

        public static byte[] Base64Decode(String base64EncodedData)
        {
            var base64EncodedBytes = System.Convert.FromBase64String(base64EncodedData);
            //Console.WriteLine(Encoding.Default.GetString(base64EncodedBytes));
            return base64EncodedBytes;
        }

        public static string ByteArrayToString(byte[] ba)
        {
            StringBuilder hex = new StringBuilder(ba.Length * 2);
            foreach (byte b in ba)
                hex.AppendFormat("{0:x2}", b);
            return hex.ToString();
        }

        public static String computeVC(DocumentDigests doc)
        {
            List<byte[]> hashes = doc.hashes;
            int hshLen = hashes[0].Length;
            BitArray bits = new BitArray(new byte[hshLen]);
            foreach (byte[] h in hashes)
            {
                bits.Xor(new BitArray(h));
            }

            byte[] ret = new byte[(bits.Length - 1) / 8 + 1];
            bits.CopyTo(ret, 0);
            byte[] final = SHA256.Create().ComputeHash(ret);

            byte[] vc = new byte[4];
            vc[0] = final[0];
            vc[1] = final[1];
            vc[2] = final[hshLen - 2];
            vc[3] = final[hshLen - 1];
            //Console.WriteLine(Utils.ByteArrayToString(final));
            return String.Format("{0:X2}{1:X2}-{2:X2}{3:X2}", vc[0], vc[1], vc[2], vc[3]);
            
        }
    }
}
