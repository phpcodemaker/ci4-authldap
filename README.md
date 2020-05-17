# AuthLdap
CodeIgniter[4.0.3] LDAP Authentication

``` composer require phpcodemaker/ci4-authldap:1.0 ```

Thanks to the Forumsys Site to make LDAP connection testing<br/>
https://www.forumsys.com/tutorials/integration-how-to/ldap/online-ldap-test-server

To check your LDAP connection in local, Execute the below command in Terminal<br/>
/var/www/html$ ldapsearch -W -h ldap.forumsys.com -D "uid=riemann,dc=example,dc=com" -b "dc=example,dc=com"


Create your Own User Controller for login and logout as follows,
```
<?php
namespace App\Controllers;
use AuthLdap\Libraries\AuthLdap;
use CodeIgniter\View\View;

/**
 * Class User
 * @package App\Controllers
 * @author Karthikeyan C <karthikn.mca@gmail.com>
 */
class User extends BaseController
{
    /**
     * @var AuthLdap $ldapAuth
     */
    private $ldapAuth;

    /**
     * If Already declared Session in BaseController,
     * then comment the below declaration
     * @var \CodeIgniter\Session\Session
     */
    private $session;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->ldapAuth = new AuthLdap();
        /**
         * If Already declared Session in BaseController,
         * then comment the below declaration
         */
        $this->session = \Config\Services::session();
    }

    /**
     * @return \CodeIgniter\HTTP\RedirectResponse|View  (postlogin redirect | pre-login template)
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
    public function login()
    {
          if (null !== $this->request->getPost('username')
            && null !== $this->request->getPost('password')
            && is_object($this->ldapAuth)
            && method_exists($this->ldapAuth, 'authenticate')) {
            $authenticatedUserData  =   $this->ldapAuth->authenticate(
                                            trim($this->request->getPost('username')),
                                            trim($this->request->getPost('password'))
                                        );
            $this->session->set($authenticatedUserData);
            return redirect()->route('/user/dashboard');
        }
        return view('user/login');
    }

    /**
     * @return string
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
     public function logout()
     {
        $this->session->destroy();
        return view('user/logout');
     }

    /**
     * @author Karthikeyan C <karthikn.mca@gmail.com>
     */
    public function dashboard()
    {
      //implement your own stuffs
    }
```

[login]<br/>
<b>login</b> : http://localhost/user/login<br/>
<b>logout</b> : http://localhost/user/logout

[Test Credentials]<br/>
<b>username</b> : riemann<br/>
<b>password</b> : password<br/>
