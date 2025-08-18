using System;

namespace RSSPAPI
{
    interface ISessionFactory
    {
        //auth/login
        IServerSession getServerSession();

        
    }
}
