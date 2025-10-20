using iTextSharp.text.pdf;
using iTextSharp.xmp.impl;
using lib.rssp.exsig;
using lib.rssp.exsig.office;
using lib.rssp.exsig.pdf;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using workspace_test;

namespace RSSPAPI
{
    class Program
    {
        // public static string PATH_TO_FILE_CONFIG = "BVTH_DEMO.ssl2";
        // public static string userID = "USERNAME:202506100930";
        // public static string passCode = "12345678";
        // public static string filePDF = "sample.pdf";

        public static string PATH_TO_FILE_CONFIG;
        public static string credentialID;
        public static string userID;
        public static string passCode;
        public static int numSignatures = 1;
        public static Nullable<HashAlgorithmOID> hashAlgo = HashAlgorithmOID.SHA_256;
        public static SignAlgo signAlgo = SignAlgo.RSA;
        public static HashAlgorithmName hashAlgorithmName = HashAlgorithmName.SHA256;
        public static RSASignaturePadding rsaPadding = RSASignaturePadding.Pkcs1;
        public static IServerSession session;
        public static ICertificate crt;
        public static string certChain;
        public static string sad;
        public static string filePDF;
        public static string fileOffice;
        public static string signedsPath;
        public static DocumentDigests doc;

        public static string reason = "Ký hợp đồng điện tử";
        public static string location = "Hồ Chí Minh";
        public static string backgroundPath = "Signature.png";
        public static string offset = "-30,-100";
        public static string boxSize = "170,70";
        public static string titleText = "DIGITAL SIGNATURE";
        public static string signaturePage;
        public static string signaturePosition;
        public static string relyingPartyKeyStore;
        public static string signatureType = "main"; // Default to "main", can be "draft"

        static void Main(string[] args)
        {
            // Parse command-line arguments
            for (int i = 0; i < args.Length; i++)
            {
                switch (args[i])
                {
                    case "--fileConfig":
                        PATH_TO_FILE_CONFIG = args[++i];
                        break;
                    case "--userID":
                        userID = args[++i];
                        break;
                    case "--passCode":
                        passCode = args[++i];
                        break;
                    case "--filePDF":
                        filePDF = args[++i];
                        break;
                    case "--fileOffice":
                        fileOffice = args[++i];
                        break;
                    case "--signedsPath":
                        signedsPath = args[++i];
                        break;
                    case "--credentialID":
                        credentialID = args[++i];
                        break;
                    case "--keystoreFile":
                        relyingPartyKeyStore = args[++i];
                        break;
                    case "--reason":
                        reason = args[++i];
                        break;
                    case "--location":
                        location = args[++i];
                        break;
                    case "--backgroundPath":
                        backgroundPath = args[++i];
                        break;
                    case "--offset":
                        offset = args[++i];
                        break;
                    case "--boxSize":
                        boxSize = args[++i];
                        break;
                    case "--titleText":
                        titleText = args[++i];
                        break;
                    case "--page":
                        signaturePage = args[++i];
                        break;
                    case "--position":
                        signaturePosition = args[++i];
                        break;
                    case "--signatureType":
                        signatureType = args[++i];
                        break;
                }
            }

            // Argument validation and usage instructions
            if (string.IsNullOrEmpty(PATH_TO_FILE_CONFIG) || string.IsNullOrEmpty(relyingPartyKeyStore) || string.IsNullOrEmpty(passCode) || (string.IsNullOrEmpty(filePDF) && string.IsNullOrEmpty(fileOffice)) || (string.IsNullOrEmpty(userID) && string.IsNullOrEmpty(credentialID)))
            {
                Console.Error.WriteLine("Usage: Program.exe --fileConfig <path> --keystoreFile <path> (--userID <id> | --credentialID <id>) --passCode <pass> (--filePDF <path> | --fileOffice <path>) [--signedsPath <path>] [--reason <text>] [--location <text>] [--backgroundPath <path>] [--offset <x,y>] [--boxSize <width,height>] [--titleText <text>] [--page <page>] [--position <llx,lly,urx,ury>] [--signatureType <main|draft>]");
                Console.Error.WriteLine("  --fileConfig: Path to the configuration file.");
                Console.Error.WriteLine("  --userID: User ID for listing certificates (required if --credentialID is not used).");
                Console.Error.WriteLine("  --credentialID: Specific credential ID to use (skips certificate listing).");
                Console.Error.WriteLine("  --passCode: Passcode for authorization.");
                Console.Error.WriteLine("  --filePDF: Path to the PDF file to be signed.");
                Console.Error.WriteLine("  --fileOffice: Path to the Office file to be signed.");
                Console.Error.WriteLine("  --signedsPath: Path to the save PDF file signed.");
                Console.Error.WriteLine("  --keystoreFile: Path to the keystore file.");
                Console.Error.WriteLine("=======================================");
                Console.Error.WriteLine("  --reason: Reason for signing (default: \"Ký hợp đồng điện tử\").");
                Console.Error.WriteLine("  --location: Location of signing (default: \"Hồ Chí Minh\").");
                Console.Error.WriteLine("  --backgroundPath: Path to the background image for signature (default: \"Signature.png\").");
                Console.Error.WriteLine("=======================================");
                Console.Error.WriteLine("  --offset: X,Y coordinates for visible signature (default: \"-30,-100\").");
                Console.Error.WriteLine("  --boxSize: Width,Height for visible signature box (default: \"170,70\").");
                Console.Error.WriteLine("  --titleText: Title text for visible signature (default: \"DIGITAL SIGNATURE\").");
                Console.Error.WriteLine("=======================================");
                Console.Error.WriteLine("  --page: Page number for the visible signature.");
                Console.Error.WriteLine("  --position: Coordinates for the visible signature (format: llx,lly,urx,ury).");
                Console.Error.WriteLine("  --signatureType: Type of signature: 'main' (with text) or 'draft' (background only, default: 'main').");
                return;
            }

            if (!string.IsNullOrEmpty(filePDF) && !string.IsNullOrEmpty(fileOffice))
            {
                Console.Error.WriteLine("Error: --filePDF and --fileOffice cannot be used at the same time.");
                return;
            }

            try
            {
                // Step 1: Handshake_func()
                session = Handshake_func();
                Console.WriteLine("Handshake successful.");

                // Step 2: listCertificates and get credentialID (skipped if credentialID is provided)
                if (string.IsNullOrEmpty(credentialID)) // Only execute if credentialID was not provided
                {
                    List<ICertificate> crts = session.listCertificates(userID, null);
                    if (crts != null && crts.Any())
                    {
                        BaseCertificateInfo cc = crts[0].baseCredentialInfo();
                        credentialID = cc.credentialID;
                        Console.WriteLine($"Credential ID obtained: {credentialID}");
                    }
                    else
                    {
                        Console.Error.WriteLine("No certificates found for the given User ID. Please provide a valid --userID or --credentialID.");
                        return; // Exit if no certificates
                    }
                }

                // Step 3: certificateInfo
                crt = session.certificateInfo(credentialID);
                BaseCertificateInfo info = crt.baseCredentialInfo();
                if (info.certificates == null)
                {
                    Console.Error.WriteLine("No certificates found.");
                    return;
                }
                certChain = info.certificates[0];
                Console.WriteLine($"Certificate chain obtained: {certChain}");

                if (!string.IsNullOrEmpty(filePDF))
                {
                    // Step 4: credentials/authorize
                    PdfProfileCMS profile = new PdfProfileCMS(PdfForm.B, Algorithm.SHA256);
                    profile.SetReason(reason);

                    // If signatureType is "draft", only show background (no text)
                    if (signatureType == "draft")
                    {
                        profile.SetTextContent(""); // Empty text for draft signature
                    }
                    else
                    {
                        profile.SetTextContent("Ký bởi: {signby} \nNgày ký: {date} \nNơi ký: {location} \nLý do: {reason}");
                    }

                    if (!string.IsNullOrEmpty(signaturePage) && !string.IsNullOrEmpty(signaturePosition))
                    {
                        profile.SetVisibleSignature(signaturePage, signaturePosition);
                    } else {
                        profile.SetVisibleSignature(offset, boxSize, titleText);
                    }
                    // profile.SetVisibleSignature("-30,-100", "170,70", "DIGITAL SIGNATURE");
                    /*profile.SetVisibleSignature("1", "150,150,350,200");*/
                    profile.timeFormat = "dd/MM/yyyy HH:mm:ss";
                    profile.SetCheckText(false);
                    profile.SetCheckMark(false);
                    profile.SetLocation(location);
                    profile.SetBackground(File.ReadAllBytes(backgroundPath));
                    profile.SetSignerCertificate(certChain);

                    byte[] fileContent = File.ReadAllBytes(filePDF);
                    List<byte[]> src = new List<byte[]>();
                    src.Add(fileContent);

                    Encoding.RegisterProvider(CodePagesEncodingProvider.Instance);
                    Encoding.GetEncoding(1252);

                    // Only set font if signatureType is NOT "draft"
                    if (signatureType != "draft")
                    {
                        byte[] Font = File.ReadAllBytes("font-times-new-roman.ttf");
                        profile.SetFont(Font, BaseFont.CP1252, true, 10, 0, TextAlignment.ALIGN_LEFT, DefaultColor.RED);
                    }

                    SigningMethodAsyncImp signInit = new SigningMethodAsyncImp();
                    byte[] temporalData = profile.CreateTemporalFile(signInit, src);
                    List<String> hashList = signInit.hashList;
                    signInit.saveTemporalData(credentialID, temporalData);

                    doc = new DocumentDigests();
                    doc.hashAlgorithmOID = hashAlgo;
                    doc.hashes = new List<byte[]>();
                    doc.hashes.Add(Utils.Base64Decode(hashList[0]));

                    sad = crt.authorize(numSignatures, doc, null, passCode);
                    Console.WriteLine($"SAD obtained: {sad}");

                    // Step 5: signatures/signHash
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
                            string originalFileName = Path.GetFileName(filePDF);
                            string outputFileName = "signed." + originalFileName;
                            string fullOutputPath = Path.Combine(signedsPath, outputFileName);

                            File.WriteAllBytes(fullOutputPath, result);
                            Console.WriteLine($"Signed successfully saved as {fullOutputPath}");
                        }
                        break; // Assuming only one signature is processed
                    }
                }
                else if (!string.IsNullOrEmpty(fileOffice))
                {
                    Console.WriteLine("Signing Office file...");
                    List<byte[]> srcs = new List<byte[]>();
                    srcs.Add(File.ReadAllBytes(fileOffice));

                    OfficeProfile profileOffice = new OfficeProfile(OfficeForm.DSIG, Algorithm.SHA256);
                    SigningMethodSyncImp signingMethodSync = new SigningMethodSyncImp(crt, certChain, userID, Algorithm.SHA256, credentialID, passCode);

                    List<byte[]> signaturesOffice = profileOffice.Sign(signingMethodSync, srcs);

                    foreach (byte[] result in signaturesOffice)
                    {
                        string originalFileName = Path.GetFileName(fileOffice);
                        string outputFileName = "signed." + originalFileName;
                        string fullOutputPath = Path.Combine(signedsPath ?? "", outputFileName);

                        File.WriteAllBytes(fullOutputPath, result);
                        Console.WriteLine($"Signed successfully saved as {fullOutputPath}");
                    }
                }
            } catch (Exception ex) {
                Console.Error.WriteLine($"An error occurred: {ex.Message}");
                Console.WriteLine(ex.StackTrace);
                Environment.Exit(1);
            }
            Environment.Exit(0);
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
            if (string.IsNullOrEmpty(relyingPartyKeyStore))
            {
                relyingPartyKeyStore = configs["keystore.file"];
            }
            string relyingPartyKeyStorePassword = configs["keystore.password"];

            Property property = new Property(baseUrl, relyingParty, relyingPartyUser, relyingPartyPassword,
                relyingPartySignature, relyingPartyKeyStore, relyingPartyKeyStorePassword);

            SessionFactory factory = new SessionFactory(property, "VN");
            IServerSession session = factory.getServerSession();
            return session;
        }



    }
}
