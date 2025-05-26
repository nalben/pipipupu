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
using System.Windows.Navigation;
using System.Windows.Shapes;
using DIABLO.interfaces;
using DIABLO.logic;

namespace DIABLO
{
    /// <summary>
    /// Логика взаимодействия для MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private Auth_interface _auth;
        public MainWindow()
        {
            InitializeComponent();
            _auth = new Auth_logic();
        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {
            string login = tbxLog.Text;
            string password = tbxPass.Text;
            if (_auth.IsAuth(login, password))
            {
                Close();
            }
            else
            {
                MessageBox.Show("Неверный логин или пароль","");
            }
        }

        private void tbxPass_TextChanged(object sender, TextChangedEventArgs e)
        {

        }
    }
}
