# Core

### Kurulum

`composer.json`
```json
{
    "require": {
    	"ozziest/core": "dev-master"
    },
	"repositories": [
        {
            "type": "git",
            "url": "https://github.com/ozziest/core"
        }
    ]
}
```

### Rota Tanımları

```php
Router::get('/', 'Main', 'index');
Router::post('/api/auth/login', 'Auth', 'login');

Router::middleware('Auth', function () {
    
    Router::get('/api/references/all', 'Refrences', 'all');

});
```

Dikkat edilecek hususlar;

- Routing işlemi için [Routing Component](http://symfony.com/doc/current/components/routing/introduction.html) kullanılmaktadır.
- Parametreler sırasıyla: (url, controller, method) olarak gönderilir.

### Veritabanı Modelleri

- Veritabanı modelleri için [Eloquent ORM](https://laravel.com/docs/5.2/eloquent) kullanılmaktadır.
- Eloquent bir paket olarak kullanıldığından, Laravel ile birlikte kullanılan bazı özellikleri kullanılamayabilir. 


```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'users';
    protected $hidden = array('password');

}
```

```php
$users = User::all();
$user = User::find(1);
$users = User::where('email', 'foo@bar.com')
             ->where('first_name', 'Foo')
             ->get();
```

### Middlewares 

Rotalar için middleware katmanı tanımlanabilir.

```php
Router::middleware('Auth', function () {
    
    Router::get('/api/references/all', 'Refrences', 'all');

});
```

Tanımlanan middleware katmanı için `App\Middlewares` namespacei altında aynı isimde bir sınıf oluşturulmalıdır;

```php
namespace App\Middlewares;

use App\Core\Interfaces\Middleware;
use App\Core\Exceptions\UserException;
use Symfony\Component\HttpFoundation\Request;

class Auth implements Middleware {
    
    public function exec(Request $request)
    {
        throw new UserException("Oturum geçerli değil.", 401);
    }
    
}
```

Kurallar;

- Oluşturulan sınıfın adı, rota tanımındakiyle aynı olmalıdır. (Auth)
- Oluşturulan sınıf `App\Core\Interfaces\Middleware` interface'inin bir implementasyonu olmalıdır.
- Her middleware'e ilk parametre olarak [Symfony/Request](http://symfony.com/doc/current/components/http_foundation/introduction.html#request) sınıfı gönderilmektedir. Kontrol gerçekleştirirken `request` nesnesinden yararlanabilirsiniz.
- Her middleware sınıfı exec isimli bir metot barındırmalıdır. (`App\Core\Interfaces\Middleware`)
- Eğer herhangi bir hata olmadan rotaları kullanıma açacaksak herhangi bir şey yapmamıza gerek yok.
- Eğer bir hata oluştuysa (Oturum geçersiz gibi), `App\Core\Exceptions\UserException` ile Exception fırlatabilirsiniz. Exception kodu olarak gönderilen değer, **Http Status Code** olarak kullanıcıya dönecektir. :)

### Controllers

```php
namespace App\Controllers;

use App\Core\Types\Controller;
use IRequest, IResponse;

class Auth extends Controller {
    
    public function action(IRequest $input, IResponse $response)
    {
        // $this->db;
        // $this->session->id()
    }
    
}
```

- Tüm controller sınıfları `App\Controllers` dizini altında yer almaldır.
- Metoda gönderilen parametreler belirli bir sırada değildir. Siz ne isterseniz onlar gönderilir. İsteyebileceğiniz tüm sınıflar yukarıda alınmıştır.
    - `Input`: Form verilerine ulaşmak için kullanılır: **all()**, **get('email')**
    - `Response`: Response oluşturmak için kullanılır: **view('view_name')**, **json['status' => true]**, **ok()**
    - `Request`: Symfony'nin request sınıfıdır. ([bkz](http://symfony.com/doc/current/components/http_foundation/introduction.html#request))
    - `DB`: Eloquent'ın DB sınıfıdır. Raw SQL yazmak için vs. kullanabilirsiniz.

Sadece kullanacağımız şeylerin alınması;

```php
namespace App\Controllers;

use App\Core\Types\Controller;
use IResponse;

class Auth {
    
    public function action(IResponse $response)
    {
        return $response->json(['token' => 'my_secret_token']);
    }
    
}
```

### Form Validation 

Form validasyonları için [Windrider](https://github.com/ozziest/windrider) paketini kullanıyoruz.

```php
use App\Core\Types\Controller;
use use Ozziest\Windrider\Windrider;
use IRequest, IResponse;

class Auth extends Controller {
    
    public function login(IRequest $input, IResponse $response)
    {
    
        $rules = [
            ['email', 'E-Posta', 'required|valid_email'],
            ['password', 'Parola', 'required|min_length[6]']
        ];
        Windrider::runOrFail($input->all(), $rules);
        
        $response->ok();
        
    }
    
}
```

Önemli noktalar;

- Form validasyonları controller sınıfları içerisine kullanılması daha uygun olur.
- Form aracılığı ile gelen verilere `$input->all()` ya da `$input->get('email')` metotlarıyla ulaşıabilir.
- Validasyon sonrası eğer hata olursa `Windrider` bir exception fırlatır: `Ozziest\Windrider\ValidationException` 
- ValidationException çekirdek tarafından otomatik olarak yakalanır ve hata mesajları geriye gönderilir. Ekstra bir kontrol yapmanız gerekmez. 
- Ekstra kontrol ile kendiniz özel sonuçlar üretmek isterseniz try-catch ile istisnaları yakalamanız gerekir. 
- ValidationException, Exception sınıfından türetilmiştir. ([bkz](https://github.com/ozziest/windrider/blob/master/src/Ozziest/Windrider/ValidationException.php))