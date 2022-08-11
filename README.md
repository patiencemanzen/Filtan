# Filtan from Patienceman

Flltan is fast and reusable laravel package for custom model query filters

## Installation

To install the package don't require much requirement except to paste the following compand in laravel terminal,  and the you're good to go.

```bash
composer require patienceman/filtan
```

## Usage

We all like automated stuff like 
```bash 
php artisan make:cake BananaCake 
```
that what I was doing for you, so you don't have always to create files for filter traditional. :firecracker:

Just one command :tada: 
Let us use our example of the AirPlane Model and create a new filter:

```bash
php artisan make:filter AirPlaneFilter
```
so it will create the filter file for u, Just in 
```bash App\Services\Filters ```

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
:fire: :fire: What best move we make: in the world?

So you may want even to specify the custom path for your filter, Just relax and add it in front of your filter name.
Let's take again our current example.
```bash
php artisan make:filter Model/AirPlaneFilter
```
:wave: :wave: That is just what magic can make, awesome right?

In your App/Services/Filters directory, Where you gonna put all of your model filter files.

```PHP
    namespace App\Services\Filters;
    
    use Patienceman\Filtan\QueryFilter;

    class AirplaneFilter extends QueryFilter {

        public function query(string $query){
            $this->builder->where('name', 'LIKE', '%' . $query . '%');
        }

    }
```
So now you have your filters function to be applied when new AirplaneModel query called!,

We need to communicate to model and tell that we have it filters, so that we can call it anytime!!, 
So let use filterable trait to enable filter builder.

```PHP
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Patienceman\Filtan\Filterable;

    class Airplane extends Model {
        use HasFactory, Filterable;
    }
```
Boom Boom, from now on, we are able call our fiter anytime, any place that need Airplane model, so let see how we can use this in our controller

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

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
