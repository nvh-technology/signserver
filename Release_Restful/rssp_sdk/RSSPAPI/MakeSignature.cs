using System;
using System.Text;

namespace RSSPAPI
{
    class MakeSignature
    {
        private String data;
        private String key;
        private String passKey;

        public MakeSignature(String data, String PriKeyPath, String PriKeyPass)
        {
            this.data = data;
            this.key = PriKeyPath;
            this.passKey = PriKeyPass;
        }

        public String getSignature()
        {
            System.Security.Cryptography.RSACryptoServiceProvider key = GetKey();
            return Sign(this.data, key);
        }

        public static string Sign(string content, System.Security.Cryptography.RSACryptoServiceProvider rsa)
        {
            System.Security.Cryptography.RSACryptoServiceProvider crsa = rsa;
            byte[] Data = Encoding.UTF8.GetBytes(content);
            byte[] signData = crsa.SignData(Data, "sha1");
            return Convert.ToBase64String(signData);

        }
        private System.Security.Cryptography.RSACryptoServiceProvider GetKey()
        {
            System.Security.Cryptography.X509Certificates.X509Certificate2 cert2
                = new System.Security.Cryptography.X509Certificates.X509Certificate2(
                    this.key, this.passKey,
                    System.Security.Cryptography.X509Certificates.X509KeyStorageFlags.MachineKeySet |
                    System.Security.Cryptography.X509Certificates.X509KeyStorageFlags.PersistKeySet |
                    System.Security.Cryptography.X509Certificates.X509KeyStorageFlags.Exportable);
            System.Security.Cryptography.RSACryptoServiceProvider rsa = (System.Security.Cryptography.RSACryptoServiceProvider)cert2.PrivateKey;

            byte[] publicKey = cert2.PublicKey.EncodedKeyValue.RawData;
            //Console.WriteLine( Convert.ToBase64String(publicKey));
            return rsa;
        }

    }
}
