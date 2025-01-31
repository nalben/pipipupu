using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using paladin.Logic;

namespace paladin
{
    /// <summary>
    /// Логика взаимодействия для AuthWindow.xaml
    /// </summary>
    public partial class AuthWindow : Window
    {
        AuthLogic authLogic = new AuthLogic();

        public AuthWindow()
        {
            InitializeComponent();
        }

        private void Button_Clock(object sender, RoutedEventArgs e)
        {
            string pass = btxP.Text;
            string login = btxL.Text;

            if (authLogic.AuthService(login, pass))
            {
                AuthWindow authWindow = new AuthWindow();
                authWindow.Show();
            }

            else MessageBox.Show("Ошибка");
        }
    }
}
