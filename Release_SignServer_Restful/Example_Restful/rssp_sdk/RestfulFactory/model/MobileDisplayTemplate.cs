using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RSSPAPI
{
    class MobileDisplayTemplate
    {
        public string notificationMessage { get; set; }
        public string messageCaption { get; set; }
        public string message { get; set; }

        public string logoURI { get; set; }
        public string bgImageURI { get; set; }
        public string rpIconURI { get; set; }
        public string rpName { get; set; }
        //public string confirmationPolicy { get; set; }
        public bool vcEnabled { get; set; }
        public bool acEnabled { get; set; }

        public string scaIdentity { get; set; }
    }
}
