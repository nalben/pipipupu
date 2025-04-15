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
using PALADIN2.interfaces;
using PALADIN2.logic;

namespace PALADIN2
{
    /// <summary>
    /// Логика взаимодействия для MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private auth_logic auth_Logic;
        public MainWindow()
        {
            InitializeComponent();
            auth_Logic = new Auth_logic();
        }

        private void TextBox_TextChanged(object sender, TextChangedEventArgs e)
        {

        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {
            string login = tbxlogin.Text;
            string password = tbxpassword.Text;
            if (auth_Logic.auth_logic == true)
            {

            };
        }
    }
}
