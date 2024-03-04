<?php
namespace App\Imports;
use App\Models\RequestBooking;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Auth;
class RequestImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $hotel_id = Auth::guard('admin')->user()->hotel_id ?? "";

            if($row['from'] !="" && $row['to'] !="" && $row['pax'] !="" && $hotel_id!=""){
                $RequestBooking = new RequestBooking;
                $RequestBooking->hotel_id = $hotel_id;
                $RequestBooking->referrer = $row['referer'];
                $RequestBooking->phone = $row['tel'];
                $RequestBooking->email = $row['mail'];
                $RequestBooking->check_in = date("Y-m-d", strtotime($row['from']));
                $RequestBooking->check_out = date("Y-m-d", strtotime($row['to']));
                $RequestBooking->adult = $row['pax'];
                $RequestBooking->note = $row['note'];
                $RequestBooking->sc = $row['sc'];
                $RequestBooking->inf = $row['inf'];
                $RequestBooking->anim = $row['anim'];
                $RequestBooking->save();
            }

        }
   }
}
