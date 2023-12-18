<?php

namespace App\Http\Controllers;

use App\Http\Resources\VisitResource;
use App\Models\Cashier;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VisitController extends Controller
{
    # index: to get vdith search by member name
    # filter by member phone number
    # search by cashier name
    # search by date
    # search by receipt
    # load loyalty points with it
    # load cashier name with it
    # load member name with it
    # order by max loyalty points

    public function index()
    {
        return Visit::orderByPoints()->filter(
            request(['member', 'cashier', 'loyalty', 'receipt'])
        )->paginate();
    }


    public function show(Visit $visit)
    {
        return VisitResource::make($visit);
    }

    # create visit and loyalty when member buy something
    # note: cashier who create visits
    # you can assume that cashier is logged in (auth::user() == cashier)
    public function store(Request $request)
    {
        $visit = Visit::create($request->all());
        $cashier = Cashier::find($request->cashier_id);
        $settings = $cashier->settings;
        // Not comfortable with this little dublication here.
        if ($request->receipt < $settings->min_amount) {
            throw new \Exception(); // Or whatever you going to do in this case.
        }

        $visit->loyalty()->create([
            'points' => self::itemPoints($settings->loyalty_model, $request->receipt, $settings->factor)
        ]);

    }

    public function update(Request $request, Visit $visit)
    {
        $visit->update($request->all());
        $cashier = Cashier::find($request->cashier_id);
        $settings = $cashier->settings;

        if ($request->receipt < $settings->min_amount) {
            throw new \Exception(); // Or whatever you going to do in this case.
        }


        $visit->loyalty()->create([
            'points' => self::itemPoints($settings->loyalty_model, $request->receipt, $settings->factor)
        ]);
    }

    public static function itemPoints($model, $reqValue, $factor)
    {
        return match ($model) {
            'first_model' => $reqValue * $factor,
            'second_model' => $reqValue / $factor,
            default => 0 // OR whatever the default value is.
        };
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        $visit->loyalty()->delete();
    }

}
