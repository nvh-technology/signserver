using System;
using System.IO;
using System.Net;

namespace RSSPAPI
{
    public class HTTPUtils
    {
        public static string sendPost(string url, string payload, String authorizationHeader)
        {
            try
            {
                //Console.WriteLine("Send POST to [" + url +"]");
                string result;
                string endpointUrl = url;

                ServicePointManager.CheckCertificateRevocationList = false;
                ServicePointManager.ServerCertificateValidationCallback = (a, b, c, d) => true;
                ServicePointManager.Expect100Continue = true;
                ServicePointManager.SecurityProtocol = SecurityProtocolType.Tls12;
                ServicePointManager.DefaultConnectionLimit = 9999;

                HttpWebRequest httpWebRequest = (HttpWebRequest)WebRequest.Create(endpointUrl);
                httpWebRequest.ContentType = "application/json";
                httpWebRequest.Method = "POST";
                httpWebRequest.Headers["Authorization"] = authorizationHeader;

                using (StreamWriter streamWriter = new StreamWriter(httpWebRequest.GetRequestStream()))
                {
                    streamWriter.Write(payload);
                }

                HttpWebResponse httpResponse = (HttpWebResponse)httpWebRequest.GetResponse();
                using (StreamReader streamReader = new StreamReader(httpResponse.GetResponseStream()))
                {
                    result = streamReader.ReadToEnd();
                }
                return result;
            }
            catch (Exception e)
            {
                throw e;
            }
        }

    }
}