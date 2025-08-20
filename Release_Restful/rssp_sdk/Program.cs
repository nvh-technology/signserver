using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Security.Cryptography;
using iTextSharp.text.pdf;
using System.Text;
using lib.rssp.exsig;
using lib.rssp.exsig.pdf;
using iTextSharp.xmp.impl;
using lib.rssp.exsig.office;
using workspace_test;


namespace RSSPAPI
{
    class Program
    {
        public static string PATH_TO_FILE_CONFIG = "BVTH_DEMO.ssl2";                    
        public static string credentialID;
        public static string userID = "USERNAME:202506100930";
        public static string passCode = "12345678";
        public static int numSignatures = 1;
        public static Nullable<HashAlgorithmOID> hashAlgo = HashAlgorithmOID.SHA_256;
        public static SignAlgo signAlgo = SignAlgo.RSA;
        public static HashAlgorithmName hashAlgorithmName = HashAlgorithmName.SHA256;
        public static RSASignaturePadding rsaPadding = RSASignaturePadding.Pkcs1;
        public static IServerSession session;
        public static ICertificate crt;
        public static string certChain;
        public static string sad;
        public static string filePDF = "sample.pdf";
        public static string fileOffice = "file/sample.xlsx";
        public static DocumentDigests doc;

        static void Main(string[] args)
        {
            Console.OutputEncoding = Encoding.UTF8;
            Console.WriteLine("");
            functions();
            string choose = "";

            do
            {
                Console.WriteLine("\nEnter function: ");
                choose = Console.ReadLine();
                switch (choose)
                {
                    case "1":
                        session = Handshake_func();
                        break;

                    case "2":
                        List<ICertificate> crts = session.listCertificates(userID, null);
                        foreach (ICertificate item in crts)
                        {
                            BaseCertificateInfo cc = item.baseCredentialInfo();
                            Console.WriteLine("Identity of certificate          : " + cc.credentialID);
                            Console.WriteLine("Status of certificate            : " + cc.status);
                            Console.WriteLine("Description status of certificate: " + cc.statusDesc);
                        }
                        break;

                    case "3":
                        Console.Write("Input credentialID: ");
                        credentialID = Console.ReadLine();
                        crt = session.certificateInfo(credentialID);
                        BaseCertificateInfo info = crt.baseCredentialInfo();
                        certChain = info.certificates[0];
                        Console.Write("certificates: " + certChain);
                        break;


                    case "4":

                        PdfProfileCMS profile = new PdfProfileCMS(PdfForm.B, Algorithm.SHA256);
                        profile.SetReason("Ký hợp đồng điện tử");
                        profile.SetTextContent("Ký bởi: {signby} \nNgày ký: {date} \nNơi ký: {location} \nLý do: {reason}");
                        profile.SetVisibleSignature("-30,-100", "170,70", "DIGITAL SIGNATURE");
                        /*profile.SetVisibleSignature("1", "150,150,350,200");*/
                        profile.SetCheckText(false);
                        profile.SetCheckMark(false);
                        profile.SetLocation("Hồ Chí Minh");
                        profile.SetBackground(File.ReadAllBytes("Signature.png"));
                        profile.SetSignerCertificate(certChain);


                        byte[] fileContent = File.ReadAllBytes(filePDF);
                        List<byte[]> src = new List<byte[]>();
                        src.Add(fileContent);

                        Encoding.RegisterProvider(CodePagesEncodingProvider.Instance);
                        Encoding.GetEncoding(1252);
                        byte[] Font = File.ReadAllBytes("font-times-new-roman.ttf");
                        profile.SetFont(Font, BaseFont.CP1252, true, 10, 0, TextAlignment.ALIGN_LEFT, DefaultColor.RED);

                        SigningMethodAsyncImp signInit = new SigningMethodAsyncImp();
                        byte[] temporalData = profile.CreateTemporalFile(signInit, src);
                        List<String> hashList = signInit.hashList;
                        signInit.saveTemporalData(credentialID, temporalData);

                        doc = new DocumentDigests();
                        doc.hashAlgorithmOID = hashAlgo;
                        doc.hashes = new List<byte[]>();
                        doc.hashes.Add(Utils.Base64Decode(hashList[0]));

                        sad = crt.authorize(numSignatures, doc, null, passCode);
                        Console.WriteLine("SAD: " + sad);
                        break;

                    case "5":
                        Console.Write("Input your SAD: ");
                        sad = Console.ReadLine();

                        CertificateInfo crtInfo = crt.credentialInfo("single", true, true);
                        List<byte[]> signatures = crt.signHash(doc, signAlgo, sad);
                        foreach (byte[] s in signatures)
                        {
                            Console.WriteLine("PKCS#1-Signature: " + Utils.Base64Encode(s));

                            SigningMethodAsyncImp signFinal = new SigningMethodAsyncImp();

                            List<String> chain = new List<String>();
                            chain.Add(crtInfo.certificates[0]);
                            signFinal.certificateChain = chain;

                            List<String> Signature = new List<String>();
                            Signature.Add(Utils.Base64Encode(s));
                            signFinal.signatures = Signature;

                            byte[] temp = signFinal.loadTemporalData(credentialID);

                            List<byte[]> results = PdfProfileCMS.Sign<PdfProfileCMS>(signFinal, temp);
                            foreach (byte[] result in results)
                            {
                                File.WriteAllBytes("signed." + filePDF, result);
                            }
                            break;
                        }
                        break;

                    case "6": // Ký office
                        List<byte[]> signaturesOffice = new List<byte[]>();
                        List<byte[]> srcs = new List<byte[]>();
                        srcs.Add(File.ReadAllBytes(fileOffice));

                        OfficeProfile profileOffice = new OfficeProfile(OfficeForm.DSIG, Algorithm.SHA256);
                        SigningMethodSyncImp signingMethodSync = new SigningMethodSyncImp(crt, certChain, userID, Algorithm.SHA256, credentialID, passCode);

                        signaturesOffice = profileOffice.Sign(signingMethodSync, srcs);

                        List<byte[]> resultsOffice = new List<byte[]>();
                        resultsOffice.AddRange(signaturesOffice);
                        int i = 0;
                        foreach (byte[] result in resultsOffice)
                        {
                            Console.WriteLine("File name: signed.sample.xlsx");
                            File.WriteAllBytes("signed.sample.xlsx", result);
                            i++;
                        }
                        break;

                    default:
                        break;
                }
            } while (choose != null);
        }

        public static void functions()
        {
            Console.WriteLine("========== RESTFUL SDK FUNCTIONS =========");
            Console.WriteLine("1. auth/login");
            Console.WriteLine("2. credentials/list");
            Console.WriteLine("3. credentials/info");
            Console.WriteLine("4. credentials/authorize");
            Console.WriteLine("5. signatures/signHash");
            Console.WriteLine("6. signatures/signHash (Office)");
        }

        public static IServerSession Handshake_func()
        {
            var configs = new Dictionary<string, string>();
            foreach (var row in File.ReadAllLines(PATH_TO_FILE_CONFIG))
            {
                configs.Add(row.Split('=')[0], string.Join("=", row.Split('=').Skip(1).ToArray()));
            }
            //Info of Relyingpaty, RSSP Operator will send infos to RelyingParty
            string baseUrl = configs["baseurl"];
            string relyingParty = configs["name"];
            string relyingPartyUser = configs["user"];
            string relyingPartyPassword = configs["password"];
            string relyingPartySignature = configs["signature"];
            string relyingPartyKeyStore = configs["keystore.file"];
            string relyingPartyKeyStorePassword = configs["keystore.password"];

            Property property = new Property(baseUrl, relyingParty, relyingPartyUser, relyingPartyPassword,
                relyingPartySignature, relyingPartyKeyStore, relyingPartyKeyStorePassword);

            SessionFactory factory = new SessionFactory(property, "VN");   
            IServerSession session = factory.getServerSession();                                
            return session;
        }

        

    }
}
