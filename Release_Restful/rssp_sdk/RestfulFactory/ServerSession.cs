using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Runtime.CompilerServices;

namespace RSSPAPI
{
    class ServerSession : IServerSession
    {
        private String bearer;
        private String refreshToken;
        private Property property;
        private String lang;
        private int retryLogin = 0;

        public ServerSession(Property prop, string lang)
        {
            this.property = prop;
            this.lang = lang;
            this.login();
        }

        // auth/login ================================================================================================
        [MethodImpl(MethodImplOptions.Synchronized)]
        public void login()
        {
            Console.WriteLine("____________auth/login____________");
            String authHeader;
            if (refreshToken != null)
            {
                authHeader = refreshToken;
            }
            else
            {
                retryLogin++;
                authHeader = property.getAuthorization();
            }
            Console.WriteLine("Login-retry: " + retryLogin);
            LoginRequest loginRequest = new LoginRequest();
            loginRequest.rememberMeEnabled = true;
            loginRequest.relyingParty = property.relyingParty;
            loginRequest.lang = this.lang;

            string jsonReq = JsonConvert.SerializeObject(loginRequest, new JsonSerializerSettings { NullValueHandling = NullValueHandling.Ignore });

            string jsonResp = HTTPUtils.sendPost(property.baseUrl + "auth/login", jsonReq, authHeader);

            LoginResponse signCloudResp = JsonConvert.DeserializeObject<LoginResponse>(jsonResp);
            if (signCloudResp.error == 3005 || signCloudResp.error == 3006)
            {
                refreshToken = null;
                if (retryLogin >= 5)
                {
                    retryLogin = 0;
                    throw new APIException(signCloudResp.error, signCloudResp.errorDescription);
                }
                login();
            }
            else if (signCloudResp.error != 0)
            {
                throw new APIException(signCloudResp.error, signCloudResp.errorDescription);
            }
            else
            {
                this.bearer = "Bearer " + signCloudResp.accessToken;
                if (signCloudResp.refreshToken != null)
                {
                    this.refreshToken = "Bearer " + signCloudResp.refreshToken;
                    Console.WriteLine("Response code: " + signCloudResp.error);
                    Console.WriteLine("Response Desscription: " + signCloudResp.errorDescription);
                    Console.WriteLine("Response ID: " + signCloudResp.responseID);
                    Console.WriteLine("AccessToken: " + signCloudResp.accessToken);
                }
            }
        }

        // credential/list ===========================================================================================
        public List<ICertificate> listCertificates()
        {
            return listCertificates(null, null, null, false, false, null);
        }
        public List<ICertificate> listCertificates(String agreementUUID)
        {
            return listCertificates(null, agreementUUID, null, false, false, null);
        }
        public List<ICertificate> listCertificates(String userID, String agreementUUID)
        {
            return listCertificates(userID, null, null, false, false, null);
        }
        public List<ICertificate> listCertificates(string userID, string agreementUUID, string certificate, bool certInfoEnabled, bool authInfoEnabled, SearchConditions conditions)
        {
            Console.WriteLine("____________credentials/list____________");
            String authHeader = bearer;
            CredentialListRequest credentiallistRequest = new CredentialListRequest();
            credentiallistRequest.userID = userID;
            credentiallistRequest.agreementUUID = agreementUUID;
            credentiallistRequest.certificates = certificate;
            credentiallistRequest.certInfoEnabled = certInfoEnabled;
            credentiallistRequest.authInfoEnabled = authInfoEnabled;
            credentiallistRequest.searchConditions = conditions;
            credentiallistRequest.lang = this.lang;

            string jsonReq = JsonConvert.SerializeObject(
            credentiallistRequest, new JsonSerializerSettings { NullValueHandling = NullValueHandling.Ignore });
            string jsonResp = HTTPUtils.sendPost(property.baseUrl + "credentials/list", jsonReq, authHeader);

            CredentialListResponse signCloudResp = JsonConvert.DeserializeObject<CredentialListResponse>(jsonResp);
            if (signCloudResp.error == 3005 || signCloudResp.error == 3006)
            {
                login();
                return listCertificates(userID, agreementUUID, certificate, certInfoEnabled, authInfoEnabled, conditions);
            }
            else if (signCloudResp.error != 0)
            {
                throw new APIException(signCloudResp.error, signCloudResp.errorDescription);
            }
            List<BaseCertificateInfo> listCert = signCloudResp.certs;
            List<ICertificate> listCertificate = new List<ICertificate>();

            foreach (var item in listCert)
            {
                ICertificate icrt = new Certificate(item, agreementUUID, this);
                listCertificate.Add(icrt);
            }

            Console.WriteLine("Error code: " + signCloudResp.error);
            Console.WriteLine("Error description: " + signCloudResp.errorDescription);
            return listCertificate;
        }

        // credential/info =============================================================================================
        public ICertificate certificateInfo(String credentialID)
        {
            return certificateInfo(null, credentialID, null, false, false);
        }
        public ICertificate certificateInfo(String agreementUUID, String credentialID)
        {
            return certificateInfo(agreementUUID, credentialID, null, false, false);
        }
        public ICertificate certificateInfo(String agreementUUID, String credentialID, String certificate, bool certInfoEnabled, bool authInfoEnabled)
        {
            Console.WriteLine("____________credentials/info____________");
            CredentialInfoRequest credentiallistRequest = new CredentialInfoRequest();
            credentiallistRequest.agreementUUID = agreementUUID;
            credentiallistRequest.credentialID = credentialID;
            credentiallistRequest.certificates = certificate;
            credentiallistRequest.certInfoEnabled = certInfoEnabled;
            credentiallistRequest.authInfoEnabled = authInfoEnabled;
            credentiallistRequest.lang = this.lang;

            string jsonReq = JsonConvert.SerializeObject(
            credentiallistRequest, new JsonSerializerSettings { NullValueHandling = NullValueHandling.Ignore });
            string jsonResp = HTTPUtils.sendPost(property.baseUrl + "credentials/info", jsonReq, bearer);

            CredentialInfoResponse signCloudResp = JsonConvert.DeserializeObject<CredentialInfoResponse>(jsonResp);
            if (signCloudResp.error == 3005 || signCloudResp.error == 3006)
            {
                login();
                return certificateInfo(agreementUUID, credentialID, certificate, certInfoEnabled, authInfoEnabled);
            }
            else if (signCloudResp.error != 0)
            {
                throw new APIException(signCloudResp.error, signCloudResp.errorDescription);
            }

            ICertificate icrt = new Certificate(signCloudResp.cert, agreementUUID, this);
            signCloudResp.cert.authorizationEmail = signCloudResp.authorizationEmail;
            signCloudResp.cert.authorizationPhone = signCloudResp.authorizationPhone;
            signCloudResp.cert.sharedMode = signCloudResp.sharedMode;
            signCloudResp.cert.createdRP = signCloudResp.createdRP;
            signCloudResp.cert.authModes = signCloudResp.authModes;

            signCloudResp.cert.authMode = signCloudResp.authMode;
            signCloudResp.cert.SCAL = signCloudResp.SCAL;
            signCloudResp.cert.contractExpirationDate = signCloudResp.contractExpirationDate;
            signCloudResp.cert.defaultPassphraseEnabled = signCloudResp.defaultPassphraseEnabled;
            signCloudResp.cert.trialEnabled = signCloudResp.trialEnabled;

            return icrt;
        }

        // credentials/authorize ===========================================================================================
        public string authorize(string agreementUUID, string credentialID, int numSignatures, DocumentDigests doc, Nullable<SignAlgo> signAlgo, string authorizeCode)
        {
            return authorize(agreementUUID, credentialID, numSignatures, doc, signAlgo, null, authorizeCode);
        }
        public string authorize(string agreementUUID, string credentialID, int numSignatures, DocumentDigests doc, Nullable<SignAlgo> signAlgo, MobileDisplayTemplate displayTemplate)
        {
            Console.WriteLine("____________credentials/authorize____________");
            AuthorizeRequest request = new AuthorizeRequest();
            request.agreementUUID = agreementUUID;
            request.credentialID = credentialID;
            request.numSignatures = numSignatures;
            request.documentDigests = doc;
            request.signAlgo = signAlgo;

            request.notificationMessage = displayTemplate.notificationMessage;
            request.messageCaption = displayTemplate.messageCaption;
            request.message = displayTemplate.message;
            request.logoURI = displayTemplate.logoURI;
            request.rpIconURI = displayTemplate.rpIconURI;
            request.bgImageURI = displayTemplate.bgImageURI;
            request.rpName = displayTemplate.rpName;
            request.scaIdentity = displayTemplate.scaIdentity;
            request.vcEnabled = displayTemplate.vcEnabled;
            request.acEnabled = displayTemplate.acEnabled;
            request.lang = this.lang;

            string jsonReq = JsonConvert.SerializeObject(
            request, new JsonSerializerSettings { NullValueHandling = NullValueHandling.Ignore });
            string jsonResp = HTTPUtils.sendPost(property.baseUrl + "credentials/authorize", jsonReq, bearer);

            AuthorizeResponse signCloudResp = JsonConvert.DeserializeObject<AuthorizeResponse>(jsonResp);
            if (signCloudResp.error == 3005 || signCloudResp.error == 3006)
            {
                login();
                return authorize(agreementUUID, credentialID, numSignatures, doc, signAlgo, displayTemplate);
            }
            else if (signCloudResp.error != 0)
            {
                throw new APIException(signCloudResp.error, signCloudResp.errorDescription);
            }
            return signCloudResp.SAD;
        }
        public string authorize(string agreementUUID, string credentialID, int numSignatures, DocumentDigests doc, SignAlgo? signAlgo, string otpRequestID, string passCode)
        {
            Console.WriteLine("____________credentials/authorize____________");
            AuthorizeRequest request = new AuthorizeRequest();
            request.agreementUUID = agreementUUID;
            request.credentialID = credentialID;
            request.numSignatures = numSignatures;
            request.documentDigests = doc;
            request.signAlgo = signAlgo;
            request.requestID = otpRequestID;
            request.authorizeCode = passCode;
            request.lang = this.lang;

            string jsonReq = JsonConvert.SerializeObject(
            request, new JsonSerializerSettings { NullValueHandling = NullValueHandling.Ignore });
            string jsonResp = HTTPUtils.sendPost(property.baseUrl + "credentials/authorize", jsonReq, bearer);

            AuthorizeResponse signCloudResp = JsonConvert.DeserializeObject<AuthorizeResponse>(jsonResp);
            if (signCloudResp.error == 3005 || signCloudResp.error == 3006)
            {
                login();
                return authorize(agreementUUID, credentialID, numSignatures, doc, signAlgo, otpRequestID, passCode);
            }
            else if (signCloudResp.error != 0)
            {
                throw new APIException(signCloudResp.error, signCloudResp.errorDescription);
            }
            return signCloudResp.SAD;
        }

        // signatures/signHash ===========================================================================================
        public List<byte[]> signHash(string agreementUUID, string credentialID, DocumentDigests documentDigest, SignAlgo? signAlgo, string SAD)
        {
            Console.WriteLine("____________signatures/signHash____________");
            SignHashRequest request = new SignHashRequest();
            request.agreementUUID = agreementUUID;
            request.credentialID = credentialID;
            request.documentDigests = documentDigest;
            request.signAlgo = signAlgo;
            request.SAD = SAD;
            request.lang = this.lang;

            string jsonReq = JsonConvert.SerializeObject(
            request, new JsonSerializerSettings { NullValueHandling = NullValueHandling.Ignore });
            string jsonResp = HTTPUtils.sendPost(property.baseUrl + "signatures/signHash", jsonReq, bearer);

            SignHashResponse signCloudResp = JsonConvert.DeserializeObject<SignHashResponse>(jsonResp);
            if (signCloudResp.error == 3005 || signCloudResp.error == 3006)
            {
                login();
                return signHash(agreementUUID, credentialID, documentDigest, signAlgo, SAD);
            }
            else if (signCloudResp.error != 0)
            {
                throw new APIException(signCloudResp.error, signCloudResp.errorDescription);
            }
            Console.WriteLine("err code: " + signCloudResp.error);
            Console.WriteLine("error description: " + signCloudResp.errorDescription);
            return signCloudResp.signatures;
        }

        public bool close()
        {
            throw new NotImplementedException();
        }
    }
}
