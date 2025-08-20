using System;
using System.Collections.Generic;

namespace RSSPAPI
{
    public interface ICertificate
    {
        BaseCertificateInfo baseCredentialInfo();

        //getCredentialInfo();
        CertificateInfo credentialInfo();
        CertificateInfo credentialInfo(String cetificate, bool certInfoEnabled, bool authInfoEnabled);

        //authorize
        //if certififate has auth_mode
        //          - PIN then authorizeCode is pin-code
        //          - OTP then authorizeCode is otp
        //          - TSE then authorizeCode is null
        //validIn in seconds
        String authorize(int numSignatures, DocumentDigests doc, Nullable<SignAlgo> signAlgo, String authorizeCode);

        String authorize(int numSignatures, DocumentDigests doc, Nullable<SignAlgo> signAlgo, String otpRequestID, String otp);

        String authorize(int numSignatures, DocumentDigests doc, Nullable<SignAlgo> signAlgo, MobileDisplayTemplate displayTemplate);

        //if DocumentDigests/SignAlgo is avaiable in authorize then they can missing
        List<byte[]> signHash(DocumentDigests documentDigest, Nullable<SignAlgo> signAlgo, string SAD);
        

    }
}
