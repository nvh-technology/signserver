using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RSSPAPI
{
    public class Identification
    {
        public string type { get; set; }
        public string value { get; set; }
        public Identification(string type, string value)
        {
            this.type = type;
            this.value = value;
        }

        public Identification()
        {
        }
    }
}
