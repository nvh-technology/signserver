using System;

namespace RSSPAPI
{
    class Property
    {
        public Property(String baseUrl, String relyingParty, String relyingPartyUser, String relyingPartyPassword, String relyingPartySignature, String relyingPartyKeyStore, String relyingPartyKeyStorePassword)
        {
            this.baseUrl = baseUrl;
            this.relyingParty = relyingParty;
            this.relyingPartyUser = relyingPartyUser;
            this.relyingPartyPassword = relyingPartyPassword;
            this.relyingPartySignature = relyingPartySignature;
            this.relyingPartyKeyStore = relyingPartyKeyStore;
            this.relyingPartyKeyStorePassword = relyingPartyKeyStorePassword;
        }

        public String profile = "rssp-119.432-v2.0";
        public String baseUrl { get; }
        public String relyingParty { get; }
        public String relyingPartyUser { get;  }
        public String relyingPartyPassword { get;  }
        public String relyingPartySignature { get;  }
        public String relyingPartyKeyStore { get; } 
        public String relyingPartyKeyStorePassword { get;  }


        public string getAuthorization()
        {
            string timestamp = Utils.CurrentTimeMillis().ToString();
            string data2sign = relyingPartyUser + relyingPartyPassword + relyingPartySignature + timestamp;
            string pkcs1Signature = Utils.getPKCS1Signature(data2sign, relyingPartyKeyStore, relyingPartyKeyStorePassword);

            string SSL2 = relyingPartyUser + ":" + relyingPartyPassword + ":" + relyingPartySignature + ":" + timestamp + ":" + pkcs1Signature;

            return "SSL2 " + Utils.Base64Encode(SSL2);
        }
    }
}
