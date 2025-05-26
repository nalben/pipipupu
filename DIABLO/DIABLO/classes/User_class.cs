using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DIABLO.classes
{
    public class User_class
    {
        public string login {  get; set; }
        public string password { get; set; }
        public string RoleID { get; set; }
        public User_class(string Login, string Password)
        {
            login = Login;
            password = Password;
        }
    }
}
