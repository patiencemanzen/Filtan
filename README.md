# Filtan

FIltan is fast and reusable laravel package for custom model query results filters

## Installation

To install the package don't require much requirement except to paste the following compand in laravel terminal,  and the you're good to go.

```bash
composer require patienceman/filtan
```

## Usage
In your App/Services directory, create new folrder called Filters, where you gonna put all of your model filter files.

After everything, you can add your custom model filter file, let take example of ```App/Services/Filters/AirplaneFilters``` class.

```Laravel
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

```Laravel
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Patienceman\Filtan\Filterable;

    class Airplane extends Model {
        use HasFactory, Filterable;
    }
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
