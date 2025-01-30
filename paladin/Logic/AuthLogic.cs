using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using paladin.Model;

namespace paladin.Logic
{
    public class AuthLogic
    { 
        private List<User> _users;

        public AuthLogic() 
        { 
            _users = new List<User>()
        {
            new User("Login", "Pass") 
        };
    }
        public bool AuthService(string login, string pass)

        { 
            var user = _users.FirstOrDefault(u => u.Login == login && u.Pass == pass);

            if (user != null && user.Pass == pass && user.Login == login)
            { 
            return true;
            }
            else
                return false;
        }
        

    } 
}
    
