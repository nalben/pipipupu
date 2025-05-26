using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DIABLO.interfaces
{
    public interface Auth_interface
    {
        bool IsAuth(string login, string password);
    }
}
