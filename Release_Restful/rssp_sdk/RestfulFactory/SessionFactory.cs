using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RSSPAPI  
{
    class SessionFactory : ISessionFactory
    {
        private Property prop;
        private string lang;

        public SessionFactory(Property prop, string lang) {
            this.prop = prop;
            this.lang = lang;
        }
        
        public IServerSession getServerSession()
        {
            ServerSession serverSession = new ServerSession(this.prop, this.lang);
            return serverSession;
        }
    }
}
