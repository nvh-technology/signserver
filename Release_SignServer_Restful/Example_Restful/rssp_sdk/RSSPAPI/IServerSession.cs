using System;
using System.Collections.Generic;

namespace RSSPAPI
{
    interface IServerSession : ISession
    {
        //2.9: credentials/list
        List<ICertificate> listCertificates();
        List<ICertificate> listCertificates(String agreementUUID);
        List<ICertificate> listCertificates(String userID, String agreementUUID);
        List<ICertificate> listCertificates(string userID, String agreementUUID, String certificate, bool certInfoEnabled, bool authInfoEnabled, SearchConditions conditions);

        //2.10: credentials/info
        //get certificate-info of user indentity by agreement-uuid and certificate-uuid
        ICertificate certificateInfo(String credentialID);
        ICertificate certificateInfo(String agreementUUID, String credentialID);
        ICertificate certificateInfo(String agreementUUID, String credentialID, String certificate, bool certInfoEnabled, bool authInfoEnabled);


        //authorize
        //if certififate has auth_mode
        //          - PIN then authorizeCode is pin-code
        //          - OTP then authorizeCode is otp
        //          - TSE then authorizeCode is null
        //validIn in seconds
        String authorize(String agreementUUID, String credentialID, int numSignatures, DocumentDigests doc, Nullable<SignAlgo> signAlgo,
            String authorizeCode);

        String authorize(String agreementUUID, String credentialID, int numSignatures, DocumentDigests doc, Nullable<SignAlgo> signAlgo,
            String otpRequestID, String otp);

        String authorize(String agreementUUID, String credentialID, int numSignatures, DocumentDigests doc, Nullable<SignAlgo> signAlgo,
            MobileDisplayTemplate displayTemplate);

        //2.14: signatures/signHash
        List<byte[]> signHash(String agreementUUID, String credentialID, DocumentDigests documentDigest, Nullable<SignAlgo> signAlgo, string SAD);

    }
}
