using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using PALADIN2.db_context;
using System.Data.Entity;
using PALADIN2.interfaces;


namespace PALADIN2.logic
{
    public class Auth_logic : auth_logic
    {
        pipipupuEntities dbContext = new pipipupuEntities();

        public bool auth_logic { get ; set ; }

        public bool IsAuth(string Login, string Password)
        {
            var user = dbContext.users.FirstOrDefault(u => u.login == Login && u.password == Password);
            if (user != null)
            {
                return true;
            }
            return false;
        }
    }
}
