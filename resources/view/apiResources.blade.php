namespace {{ $data['namespace'] }};

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class {{ $data['ResourcesName'] }}Resource extends JsonResource
{
public function toArray($request): array
{
@if($data["stub_conditions"]['create'])
    return [
    'attributes' => $this->attributes ?? []
    ];
@else
    $defaultData = [
    'id' => $this->id??[],
    'attributes' => $this->attributes ?? [],
    'created_at' => Carbon::make($this->created_at)->format('Y-m-d'),
    'updated_at' => Carbon::make($this->updated_at)->format('Y-m-d')
    ];
    $data = [
    {{ $data['data'] }}
    ];
    return array_merge($defaultData, $data) ;
@endif
}
}
