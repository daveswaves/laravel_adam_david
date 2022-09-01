<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * View the following file to see available faker fields:
 * 'vendor/fakerphp/faker/src/Faker/Generator.php'
 */
class MockDataController extends Controller
{
    public function mock_data()
    {
        $iterations = 49;
        
        $num_arr = range(0, $iterations);
        $shuffled_arr = $num_arr;
        shuffle($shuffled_arr);
        
        $data = [];
        foreach ($num_arr as $i) {
            $str_16 = Str::random(16);
            
            $data[] = [
                'id'          => $i+1,
                'hash'        => $this->reduce(hash('sha256', $str_16), 12),
                // 'bcrypt'      => $this->reduce(bcrypt($str_16), 12),
                // 'sha256'      => fake()->unique()->sha256,
                'email'       => fake()->unique()->safeEmail,
                'rand_str'    => $str_16,
                'shuffled_id' => $shuffled_arr[$i],
                'text'        => fake()->text(50),
            ];
            
            // ->name ->userName ->bcrypt($str_16) ->randomDigitNotNull ->iban ->uuid ->sha256
            // rand(1, 100);
        }
        
        $tbl_str = $this->table([
            'headings' => ['id','hash (64 chars)','email','random str','shuffled id','text'],
            'content' => $data,
        ]);
        
        return view('table', ['tbl_str'=>$tbl_str]);
    }
    
    private function table($args)
    {
        $headings = $args['headings'];
        $content  = $args['content'];
        
        $tbl = [];
        
        $tbl[] = "<table><thead><tr>";
        foreach ($headings as $i => $heading) {
            $tbl[] = "<th>$heading</th>";
        }
        
        $tbl[] = "</tr></thead><tbody>";
        foreach ($content as $row) {
            $tbl[] = "<tr>";
            foreach ($row as $cell) {
                $tbl[] = "<td>$cell</td>";
            }
            $tbl[] = "</tr>";
        }
        
        $tbl[] = "</tbody></table>";
        
        return implode('', $tbl);
    }
    
    private function reduce(string $str, int $len)
    {
        return substr($str, 0,$len) . '...';
    }
}
