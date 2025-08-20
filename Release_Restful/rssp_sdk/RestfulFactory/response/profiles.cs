using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RSSPAPI
{
    class profiles : Response
    {
        public string name { get; set; }
        public string type { get; set; }
        public string algorithm { get; set; }
        public int duration { get; set; }
        public int promotionDuration { get; set; }
        public string description { get; set; }
        //public Attribute[] attributes { get; set; }
        public int signingCounter { get; set; }
        public int amount { get; set; }
        public int renewalAmount { get; set; }
        public int reissueAmount { get; set; }
    }
}
