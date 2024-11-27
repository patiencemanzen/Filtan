# Laravel Filtan

Simplifying Laravel Eloquent Query Filtering

Filtan is a Laravel QueryFilter package that simplifies and improves the process of filtering Eloquent queries. It allows developers to easily apply filters to queries and customize the results based on dynamic parameters. By integrating Filtan into your Laravel project, you can effortlessly create complex and flexible filtering mechanisms for your models.

## Installation

To install the package, simply run the following command in your Laravel terminal:

```bash
composer require patienceman/filtan
```

## Configuration

After installing the package, you need to publish the configuration file. Run the following command to publish the configuration file:

```bash
php artisan filtan:config
```

This will create a ```filtan.php``` file in your config directory. You can customize the default directory for your filters in this configuration file.

## Usage

We all love automated tasks like artisan commands. With Filtan, you can generate filter files with just one command. No need to manually create filter files!

```bash
php artisan filtan:create BananaCakeFilter
```

This command will create a filter file for you in the default directory specified in your configuration.

Just one command :tada: Let us use our example of the AirPlane Model and create a new filter:

```bash
php artisan filtan:create AirPlaneFilter
```

This will create the filter file in:

```bash
app/Http/QueryFilters/AirPlaneFilter.php
```

```PHP
namespace App\Http\QueryFilters;

use Patienceman\Filtan\QueryFilter;

class AirPlaneFilter extends QueryFilter {
    /**
     * Search specific values from Airplan by name
     *
     * @param string $query
     */
    public function query(string $query) {
        $this->builder->where('name', 'LIKE', '%' . $query . '%');
    }
}
```

You can also specify a custom path for your filter. Just add the path in front of your filter name. Let's take our current example:

```bash
php artisan filtan:create Model/AirPlaneFilter
```

In your App/Services/Filters directory, Where are you gonna put all of your model filter files?

```PHP
namespace App\Http\QueryFilters\Model;

use Patienceman\Filtan\QueryFilter;

class AirPlaneFilter extends QueryFilter {
    /**
     * Search specific values from industry by name
     *
     * @param string $query
     */
    public function query(string $query) {
        $this->builder->where('name', 'LIKE', '%' . $query . '%');
    }
}
```

Now you have your filter function to be applied when a new AirplaneModel query is called!

We need to communicate to the model and tell it that we have filters, so that we can call it anytime! Use the ```Filterable``` trait to enable the filter builder.

```PHP
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Patienceman\Filtan\Filterable;

class Airplane extends Model {
    use HasFactory, Filterable;
}
```

From now on, we are able to call our filter anytime, any place that needs the Airplane model. Let's see how we can use this in our controller:

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
        $planes = Airplane::filter($filter)->get();

        return response()->json([
            'data' => $planes,
            'message' => 'Airplanes retrieved successfully'
        ]);
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
