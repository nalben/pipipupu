using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PALADIN2.classes
{
    public class role
    {
        public string roleID { get; set; }
        public string roleName { get; set; }

        public role (string roleID, string roleName)
        {
            this.roleID = roleID;
            this.roleName = roleName;
        }
    }

}
