using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RSSPAPI
{
    public class SearchConditions
    {
        public string certificateStatus { get; set; }
        public string cetificatePurpose { get; set; }
        public string taxID { get; set; }
        public string budgetID { get; set; }
        public string personalID { get; set; }
        public string passportID { get; set; }
        public Identification identification { get; set; }
        public string[] agreementStates { get; set; }
        public string fromDate { get; set; }
        public string toDate { get; set; }
    }
}
