# Filtan from Patienceman

Flltan is fast and reusable laravel package for custom model query filters

## Installation

To install the package don't require much requirement except to paste the following compand in laravel terminal,  and the you're good to go.

```bash
composer require patienceman/filtan
```

## Usage
In your App/Services directory, create new folrder called Filters, where you gonna put all of your model filter files.

After everything, you can add your custom model filter file, let take example of ```App/Services/Filters/AirplaneFilters``` class.

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
