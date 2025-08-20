using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using lib.rssp.exsig;
using lib.rssp.sign;
using RSSPAPI;

namespace workspace_test
{
    public class SigningMethodSyncImp : SigningMethodSync
    {
        private string certChain;
        private string credentialID;
        private string userID;
        private string passCode;

        private Algorithm algorithm;
        private DocumentDigests doc;
        private ICertificate crt;
        private int numSignatures = 1;
        private string sad;


        public SignAlgo signAlgo = SignAlgo.RSA;
        private Nullable<HashAlgorithmOID> hashAlgo = HashAlgorithmOID.SHA_256;

        public SigningMethodSyncImp(ICertificate crt, string certChain, string userID, Algorithm algorithm, string credentialID, string passCode)
        {
            this.crt = crt;
            this.certChain = certChain;
            this.userID = userID;
            this.algorithm = algorithm;
            this.credentialID = credentialID;
            this.passCode = passCode;
        }

        public List<string> Sign(List<string> hashList)
        {
            List<string> signatures = new List<string>();

            doc = new DocumentDigests();
            doc.hashAlgorithmOID = hashAlgo;
            doc.hashes = new List<byte[]>();
            doc.hashes.Add(RSSPAPI.Utils.Base64Decode(hashList[0]));

            sad = crt.authorize(numSignatures, doc, null, passCode);
            Console.WriteLine("sad: " + sad);
            //signhash
            CertificateInfo crtInfo = crt.credentialInfo("single", true, true);
            List<byte[]>  signature = crt.signHash(doc, signAlgo, sad);
            foreach (byte[] byteSignature in signature) {
                signatures.Add(RSSPAPI.Utils.Base64Encode(byteSignature));
                }
            return signatures;
        }

        public List<string> GetCert()
        {
            List<string> cert = new List<string>();
            cert.Add(this.certChain);
            return cert;
        }
    }
}
