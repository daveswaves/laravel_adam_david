<?php
namespace App\Http\Controllers;
// namespace App\Models\StoreSeller;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AddSellerController extends Controller
{
    public function store()
    {
        // var_dump(request()->all());
        // dd(request()->all());
        // return request()->all();
        
        // Laravel validation: https://laravel.com/docs/9.x/validation#available-validation-rules
        
        
        /*
         * Validate 'Add New Seller' form input - Location: Top of Sellers view
         * 
         * Note: If the validation fails, Laravel automatically redirects back to the form.
         */
        $new_seller_data = request()->validate([
            'name_address_input' => [
                'required',
                'min:3',
                'max:100',
                // https://laravel.com/docs/9.x/validation#rule-unique
                Rule::unique('sellers', 'f_address') // checks if input already exists in 'f_address@sellers'
            ],
            'commission_input' => [
                'required',
                'min:1',
                'max:2',
            ],
            'carriage_input' => [
                'required',
                'min:1',
                'max:6',
            ],
        ]);
        
        // dd( $new_seller_data );
        
        // https://laravel.com/docs/9.x/database
        
        // DB::insert('INSERT INTO `sellers` (`f_seller_id`,`f_id`,`f_address`) VALUES (?,?,?)', ['1','164','TEST_ADDRESS']);

        DB::table('sellers')->insert([
            'f_seller_id' => '115',
            'f_id'        => '163',
            'f_address'   => 'TEST_ADDRESS',
            'f_edit_date' => '2021-08-01',
            
            // 'password' => bcrypt('abc-123'), // Use with table 'sellers_test'
            // $2y$10$IRartrTT937J2ThoF8PiheMi.KSTIIgBGXTtzO1Wi4me9YY2LiQOG
        ]);

        // dd('Successful Validation');
        // Seller::create($new_seller_data);
        
        // echo env('DB_DATABASE');
    }
    
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
