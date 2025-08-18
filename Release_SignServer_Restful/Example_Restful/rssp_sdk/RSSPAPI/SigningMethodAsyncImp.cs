using lib.rssp.sign;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RSSPAPI 
{
    class SigningMethodAsyncImp : SigningMethodAsync
    {
        public List<string> certificateChain { get; set; }
        public List<string> signatures { get; set; }
        public List<string> hashList { get; set; }

        public void GenerateTempFile(List<string> hashList)
        {
            this.hashList = hashList;
        }

        public List<string> GetCert()
        {
            return this.certificateChain;
        }

        public List<string> Pack()
        {
            return this.signatures;
        }

        public void saveTemporalData(string owner, byte[] temporalData)
        {
            string result = Path.GetTempPath();
            string filename = result + owner + ".temp";
            File.WriteAllBytes(filename, temporalData);
        }

        public byte[] loadTemporalData(string owner)
        {
            string result = Path.GetTempPath();
            string filename = result + owner + ".temp";
            return File.ReadAllBytes(filename);
        }
    }
}
