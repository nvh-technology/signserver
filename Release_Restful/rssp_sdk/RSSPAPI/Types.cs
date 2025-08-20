using System.ComponentModel;
using System.Runtime.Serialization;

namespace RSSPAPI
{
    public class CertificateDetails
    { 
        public string commonName { get; set; }
        public string organization { get; set; }
        public string organizationUnit { get; set; }
        public string title { get; set; }
        public string email { get; set; }
        public string telephoneNumber { get; set; }
        public string location { get; set; }
        public string stateOrProvince { get; set; }
        public string country { get; set; }
        public Identification[] identifications { get; set; }
    }
    
    public enum Function
    {
        INFO,
        AUTH_LOGIN,
        AUTH_LOGIN_SSL_ONLY,
        DEFAULT
    }
    public enum OTPType
    {
        EMAIL,
        SMS,
    }
    public enum SessionType
    {
        SERVER,
        USER,
    }
    public enum UserType
    {
        USERNAME,

        [Description("PERSONAL-ID")]
        PERSONAL_ID,

        [Description("PASSPORT-ID")]
        PASSPORT_ID,

        [Description("CITIZEN-IDENTITY-CARD")]
        CITIZEN_IDENTITY_CARD,

        [Description("BUDGET-CODE")]
        BUDGET_CODE,

        [Description("TAX-CODE")]
        TAX_CODE,

        UUID
    }
    public enum HashAlgorithmOID
    {
        //[Description("1.3.14.3.2.26")]
        [EnumMember(Value = "1.3.14.3.2.26")]
        SHA_1,
        //[Description("2.16.840.1.101.3.4.2.1")]
        [EnumMember(Value = "2.16.840.1.101.3.4.2.1")]
        SHA_256,
        //[Description("2.16.840.1.101.3.4.2.2")]
        [EnumMember(Value = "2.16.840.1.101.3.4.2.2")]
        SHA_384,
        //[Description("2.16.840.1.101.3.4.2.3")]
        [EnumMember(Value = "2.16.840.1.101.3.4.2.3")]
        SHA_512,
    }
    public enum SignAlgo
    {
        //[Description("1.2.840.113549.1.1.1")]
        [EnumMember(Value = "1.2.840.113549.1.1.1")]
        RSA,
        //[Description("1.2.840.113549.1.1.5")]
        [EnumMember(Value = "1.2.840.113549.1.1.5")]
        RSA_SHA1,
        //[Description("1.2.840.113549.1.1.11")]
        [EnumMember(Value = "1.2.840.113549.1.1.11")]
        RSA_SHA256,
        //[Description("1.2.840.113549.1.1.12")]
        [EnumMember(Value = "1.2.840.113549.1.1.12")]
        RSA_SHA384,
        //[Description("1.2.840.113549.1.1.13")]
        [EnumMember(Value = "1.2.840.113549.1.1.13")]
        RSA_SHA512,
    }

    public enum OperationMode {
        S,
        A
    }
    public enum AuthMode
    {
        [EnumMember(Value = "EXPLICIT/PIN")]
        EXPLICIT_PIN,
        [EnumMember(Value = "EXPLICIT/OTP-SMS")]
        EXPLICIT_OTP_SMS,
        [EnumMember(Value = "EXPLICIT/OTP-EMAIL")]
        EXPLICIT_OTP_EMAIL,
        [EnumMember(Value = "IMPLICIT/TSE")]
        IMPLICIT_TSE,
        [EnumMember(Value = "IMPLICIT/BIP-CATTP")]
        IMPLICIT_BIP_CATTP,
    }
    public enum SignatureFormat
    {
        C,
        X,
        P,
    }
    public enum ConformanceLevel
    {
        [EnumMember(Value = "AdES-B-B")]
        B_B,
        [EnumMember(Value = "AdES-B-T")]
        B_T,
        [EnumMember(Value = "AdES-B-LT")]
        B_LT,
        [EnumMember(Value = "AdES-B-LTA")]
        B_LTA,
        [EnumMember(Value = "AdES-B")]
        B,
        [EnumMember(Value = "AdES-T")]
        T,
        [EnumMember(Value = "AdES-LT")]
        LT,
        [EnumMember(Value = "AdES-LTA")]
        LTA,
    }

    public enum SignedPropertyType
    {
        APPEARANCES,

        VISIBLESIGNATURE,
        VISUALSTATUS,

        //IMAGEANDTEXT,
        TEXTALIGNMENT,
        TEXTDIRECTION,
        TEXTCOLOR,
        TEXTSIZE,

        SHOWSIGNERINFO,
        SIGNERINFOPREFIX,
        SHOWDATETIME,
        DATETIMEPREFIX,
        DATETIMEFORMAT,
        SHOWREASON,
        SIGNREASONPREFIX,
        REASON,

        SHOWLOCATION,
        LOCATIONPREFIX,
        LOCALTION,

        SHOWTELEPHONE,
        TELEPHONEPREFIX,
        SHOWENTERPRISEID,
        ENTERPRISEIDPREFIX,
        SHOWPERSONALID,
        PERSONALIDPREFIX,
        SHOWSERIALNUMBER,
        SERIALNUMBERPREFIX,
        SHOWORGANIZATION,
        ORGANIZATIONPREFIX,
        SHOWTITLE,
        TITLEPREFIX,
        SHOWISSUERINFO,
        ISSUERINFOPREFIX,

        ONLYCOUNTERSIGNENABLED,

        BACKGROUNDIMAGE,
        IMAGE,
        //PAGESFORINITIALSIGNATURE,
        //SHADOWSIGNATUREPROPERTIES,
        PDFPASSWORD,
        MIMETYPE,
        FILENAME,
    }
}
