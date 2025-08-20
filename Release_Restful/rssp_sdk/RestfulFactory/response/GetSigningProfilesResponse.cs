using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RSSPAPI
{
    class GetSigningProfilesResponse : Response
    {
        public List<profiles> profiles { get; set; }
    }
}
