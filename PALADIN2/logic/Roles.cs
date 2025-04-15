using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using PALADIN2.db_context;

namespace PALADIN2.logic
{
    public class Roles
    {
        public bool IsRole (users user)
        {
            var role = user.Roles.roleID;
            if (role == 1)
            {
                return true;
            }
            else return false;
        }
       
    }
}
