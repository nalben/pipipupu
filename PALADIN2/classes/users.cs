using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PALADIN2.classes
{
    public class users
    {
        public string login { get; set; }
        public string password { get; set; }

        public users (string Login, string Password)
        {
            login = Login; password = Password;
        }
    }
}
