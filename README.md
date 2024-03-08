# Simplifying Laravel Eloquent Query Filtering 🪴

![ray-so-export (1)](https://github.com/manirabona-programer/Filtan/assets/55847682/7ef50c39-8f5a-4760-9d3c-6a2bad63c69c)

Filtan is a Laravel QueryFilter package that simplifies and improves the process of filtering Eloquent queries. It allows developers to easily apply filters to queries and customize the results based on dynamic parameters. By integrating Filtan into your Laravel project, you can effortlessly create complex and flexible filtering mechanisms for your models.

## Installation

To install the package, simply paste the command in the Laravel terminal. 

```bash
composer require patienceman/filtan
```

## Usage

We all love automated tasks like artisan commands. Filtan allows the creation of filter files with a single command, eliminating the need for manual creation.

```bash
php artisan make:cake BananaCake 
```

Instead of creating files for traditional filters, I can do it for you with just one command. Let's use the Airplane Model example to create a new filter.

```bash
php artisan make:filter AirPlaneFilter
```

so it will create the filter file for u, Just in

```bash
App\Services\Filters 
```

```PHP
namespace App\Services\Filters;

use Patienceman\Filtan\QueryFilter;

class AirPlaneFilter extends QueryFilter {
    /**
     * public function query($query) {
     *     $this->builder->where('name', 'LIKE', '%' .  . '%')
     * }
     */
}
```
It's possible to specify a custom path for your filter. Simply add it in front of the filter name. Let's revisit our example.

```bash
php artisan make:filter Model/AirPlaneFilter
```

In your App/Services/Filters directory, Where are you gonna put all of your model filter files?

```PHP
namespace App\Services\Filters;

use Patienceman\Filtan\QueryFilter;

class AirplaneFilter extends QueryFilter {

    public function query(string $query){
        $this->builder->where('name', 'LIKE', '%' . $query . '%');
    }

}
```

So now you have your filters function to be applied when a new AirplaneModel query is called!

We need to communicate to the model and tell them that we have filters so that we can call it anytime!!,
So let's use a filterable trait to enable filter builder.

```PHP
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Patienceman\Filtan\Filterable;

class Airplane extends Model {
    use HasFactory, Filterable;
}
```

From now on, we will be able to call our filter anytime, any place that needs an Airplane model, so let's see how we can use this in our controller

```PHP
namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Filters\CompanyFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AirplaneController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(CompanyFilter $filter): JsonResponse {
        $planes = Airplane::allPlanes()->filter($filter)->get();

        return successResponse(
            AirplaneResource::collection($planes),
            AirplaneAlert::DISPLAY_MESSAGE
        );
    }
}
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

1. Fork the repository and create a new branch for your contributions.
2. Make your changes or additions, adhering to the coding guidelines.
3. Submit a pull request detailing your changes, and our team will review it promptly.

## License

[MIT](https://choosealicense.com/licenses/mit/)
