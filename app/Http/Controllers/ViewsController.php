<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AuctionDate;
use App\Models\Seller;
use App\Models\Lot;

use Illuminate\Support\Facades\DB;

class ViewsController extends Controller
{
    private $dates_sorted = [];
    private $years = [];
    private $auction_dates = [];
    private $date_id_lookup = [];
    private $route_date = [];
    
    public function __construct()
    {
        $this->auction_dates = AuctionDate::all();
        
        $tmp = [];
        foreach( $this->auction_dates as $rec ){
            $tmp[$rec['f_unique_id']] = [
                'id' => $rec['f_unique_id'],
                'date' => $rec['f_auction_date'],
            ];
        }
        $this->auction_dates = $tmp;
        
        $date_most_recent = last($this->auction_dates)['date'];
        
        // Sort 'auction_dates' by 'date' in reverse, natural order
        uasort($this->auction_dates, function ($a, $b) {
            return strnatcmp($b['date'], $a['date']);
        });
        
        // $dates_arr = [];
        $this->date_id_lookup = [];
        foreach ($this->auction_dates as $rec) {
            // list($y,$m,$d) = explode('-', $rec['date']);
            // $dates_arr[ $rec['date'] ]['y'] = $y;
            // $dates_arr[ $rec['date'] ]['m'] = $m;
            // $dates_arr[ $rec['date'] ]['d'] = $d;
            $this->date_id_lookup[$rec['date']] = $rec['id'];
            
            $this->dates_sorted[ substr($rec['date'], 0,4) ][] = $rec['date'];
        }
        /*
        $this->date_id_lookup:
            [2021-06-29] => 163
            [2021-05-18] => 162
            [2021-04-20] => 161
            [2020-12-08] => 160
        
        $this->dates_sorted:
            [2021] => [
                [0] => 2021-06-29
                [1] => 2021-05-18
                [2] => 2021-04-20
            ]

            [2020] => [
                [0] => 2020-12-08
            ]
        */
        
        foreach ($this->dates_sorted as $key => $_) {
            $this->years[] = $key;
        }
        /*
        $this->years:
        [0] => 2021
        [1] => 2020
        */
        
        // Used to access the routes date parameter in the controller __construct()
        // $this->route_date = date_fmt_fnc(request()->route('date'), 'dd-mm-yyyy');
        $this->route_date = request()->route('date');
        
        if ('' == $this->route_date) {
            // $this->route_date = date_fmt_fnc($date_most_recent, 'yyyy-mm-dd');
            $this->route_date = $date_most_recent;
        }
        
        // echo '<pre style="background:#111; color:#b5ce28; font-size:11px;">'; print_r($this->route_date); echo '</pre>';
        
        // Convert year to full date when year dropdown changes
        if( strlen($this->route_date) == 4 ){
            $this->route_date = $this->dates_sorted[$this->route_date][0];
        }
        
        // $year_current = substr($this->route_date, -4); // 2021
        $year_current = substr($this->route_date, 0,4); // 2021
        
        // echo '<pre style="background:#111; color:#b5ce28; font-size:11px;">'; print_r($year_current); echo '</pre>'; die(); //DEBUG
        
        // This enables the dropdowns to be accessed by the layout.blade.php view.
        view()->share('dd_years', css_dropdown_fnc($year_current, $this->years, True) ); // css_dropdown_fnc() locaction: app/helpers_user.php
        view()->share('dd_year_dates', css_dropdown_fnc($this->route_date, $this->dates_sorted[$year_current]) );
        
        // config('user.auction_dates')
    }
    
    
    public function sellers_db($date=NULL)
    {
        $sellers = DB::table('sellers')->pluck('f_address');
        
        return $sellers;
    }
    
    public function sellers($date=NULL)
    {
        // Convert year to full date when year dropdown changes
        if( strlen($date) == 4 ){
            $date = $this->dates_sorted[$date][0];
        }
        
        $date = $date ? $date : $this->route_date;
        
        // $date = date_fmt_fnc($date, 'yyyy-mm-dd');
        
        // https://laravel.com/docs/9.x/eloquent#retrieving-models
        // $sellers = Seller::all();
        $sellers = Seller::select('f_seller_id','f_address','f_commission','f_carriage')->where('f_id', $this->date_id_lookup[$date])->get();
        // This needs to be cached for better performance
        
        $tmp = [];
        foreach( $sellers as $seller ){
            $tmp[$seller['f_seller_id']] = [
                'id'           => $seller['f_seller_id'],
                'name_address' => $seller['f_address'],
                'commission'   => $seller['f_commission'],
                'carriage'     => 0 == $seller['f_carriage'] ? '' : '&pound;'. number_format($seller['f_carriage'], 2, '.', ','),
            ];
        }
        $sellers = $tmp;
        
        // Sort sellers by ID using a natural sort: 1,2,3 etc. not 1,10,111,2 etc.
        uasort($sellers, function ($a, $b) {
            return strnatcmp($a['id'], $b['id']);
        });
        
        return view('sellers', compact('sellers', 'date'));
        
        // return view('sellers')->with('sellers', $sellers);
    }
    
    public function lots($date, $id)
    {
        // echo '<pre style="background:#111; color:#b5ce28; font-size:11px;">'; print_r($date); echo '</pre>'; die(); //DEBUG
        
        // $date = date_fmt_fnc($date, 'yyyy-mm-dd');
        
        $lots = Lot::select("*")->where([['f_seller_id', $id],['f_id', $this->date_id_lookup[$date]]])->get();
        // $lots = Lot::select("*")->where([['f_seller_id',$id],['f_id',163]])->get();
        
        // Should be able to look this up from previous seller query
        $seller = Seller::select('f_address')->where([['f_seller_id', $id],['f_id', $this->date_id_lookup[$date]]])->get();
        
        $seller = ['id' => $id,'name_address' => $seller[0]['f_address']];
        
        $tmp1 = [];
        foreach( $lots as $lot ){
            $checked = $lot['f_wd'] ? ' checked=""' : '';
            $withdrawn_cbx = '<input type="checkbox" name="wd_input_'.$lot['f_lot_no'].'" value="'.$lot['f_wd'].'"'.$checked.'>';
            
            $tmp2 = [];
            foreach( range(0, 4) as $opt ){
                $sel = $lot['f_electric'] == $opt ? ' selected=""' : '';
                $tmp2[] = "<option value='$opt'$sel>$opt</option>";
            }
            $elec_opts = implode('', $tmp2);
            $lot_price = number_format($lot['f_lot_price'], 2, '.', ',');
            
            $tmp1[] = [
                'lot_no'    => $lot['f_lot_no'],
                'lot_name'  => $lot['f_lot_name'],
                'withdrawn_cbx' => $withdrawn_cbx,
                'electric_dropdown' => '<select name="elec_input_'. $lot['f_lot_no'] .'">'. $elec_opts .'</select>',
                'lot_price_txtbx' => '<input type="text" name="price_input_'.$lot['f_lot_no'].'" value="'.$lot_price.'" id="price_input" class="txtbox lot_price_input">',
            ];
        }
        $lots = $tmp1;
        
        uasort($lots, function ($a, $b) {
            return strnatcmp($a['lot_no'], $b['lot_no']);
        });
        
        return view('lots', [
            'seller' => $seller,
            'lots' => $lots,
            // 'date' => $date,
        ]);
    }
}
