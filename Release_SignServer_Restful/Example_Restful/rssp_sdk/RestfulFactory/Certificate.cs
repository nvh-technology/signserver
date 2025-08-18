using System;
using System.Collections.Generic;

namespace RSSPAPI
{
    class Certificate : ICertificate
    {
        private BaseCertificateInfo certificate;
        private String agreementUUID;
        private IServerSession serverSession;
        public Certificate(BaseCertificateInfo cert, String agreementUUID, IServerSession serverSession)
        {
            this.certificate = cert;
            this.agreementUUID = agreementUUID;
            this.serverSession = serverSession;
        }

        public BaseCertificateInfo baseCredentialInfo()
        {
            return certificate;
        }

        public CertificateInfo credentialInfo()
        {
            ICertificate icrt = this.serverSession.certificateInfo(this.agreementUUID, certificate.credentialID);
            if (icrt.baseCredentialInfo() is CertificateInfo)
            {
                return (CertificateInfo)icrt.baseCredentialInfo();
            }
            throw new APIException("Type of certificate is not [CertificateInfo]");
        }


        public CertificateInfo credentialInfo(String cetificates, bool certInfoEnabled, bool authInfoEnabled)
        {
            //call to server
            ICertificate icrt = this.serverSession.certificateInfo(this.agreementUUID,  certificate.credentialID, cetificates, certInfoEnabled, authInfoEnabled);
            if (icrt.baseCredentialInfo() is CertificateInfo)
            {
                return (CertificateInfo)icrt.baseCredentialInfo();
            }
            throw new APIException("Type of certificate is not [CertificateInfo]");
        }

        public String authorize(int numSignatures, DocumentDigests doc, Nullable<SignAlgo> signAlgo, String authorizeCode)
        {
            return this.serverSession.authorize(this.agreementUUID, this.certificate.credentialID, numSignatures, doc, signAlgo, authorizeCode);
        }

        public string authorize(int numSignatures, DocumentDigests doc, Nullable<SignAlgo> signAlgo, MobileDisplayTemplate displayTemplate)
        {
            return this.serverSession.authorize(this.agreementUUID, this.certificate.credentialID, numSignatures, doc, signAlgo, displayTemplate);
        }

        public string authorize(int numSignatures, DocumentDigests doc, SignAlgo? signAlgo, string otpRequestID, string otp)
        {
            return this.serverSession.authorize(this.agreementUUID, this.certificate.credentialID, numSignatures, doc, signAlgo, otpRequestID, otp);
        }

        public List<byte[]> signHash(DocumentDigests documentDigest, Nullable<SignAlgo> signAlgo, string SAD)
        {
            return this.serverSession.signHash(this.agreementUUID, this.certificate.credentialID, documentDigest, signAlgo, SAD);
        }

    }
} 
