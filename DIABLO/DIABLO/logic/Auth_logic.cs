using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using DIABLO.db;
using DIABLO.interfaces;

namespace DIABLO.logic
{
    public class Auth_logic:Auth_interface
    {
        DIABLO666Entities db=new DIABLO666Entities();
        public bool IsAuth(string login, string password) 
        {
            var user = db.Users.FirstOrDefault(u=>u.User_Password==password && u.User_Login==login);
            if (user != null)
            {
                new DataGrid().Show();
                return true;
            }
            return false;
        }
        
    }
}
