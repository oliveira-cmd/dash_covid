<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
 
use App\Models\User;
use Illuminate\View\View;
// mes/dia/ano
class ApiController extends Controller
{

    public function index(){
        $response = $this->callApi();

        $year = $_GET['year'];

        if(!empty($response)){
            $cases = $response->cases;
            $deaths = $response->deaths;

            foreach($cases as $case => $key){
                $arr_cases[] = [
                    'data'          => $case,
                    'qtde_cases'    => $key        
                ];
            }

            $cases_per_year = $this->casesPerYear($arr_cases,$year);

            $years = ['20', '21','22','23'];

            $year_most_registered_cases = $this->checkingYearMostRegisteredCases($years);

            echo $cases_per_year . ' em 20'.$year;
        }
    }

    private function callApi(){
        $link = 'https://disease.sh/v3/covid-19/historical/all?lastdays=all';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
        ]);

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if(!empty($response)){
            return json_decode($response);
        }

        return [];
    }

    private function casesPerYear($cases,$year){
        $count_cases = 0;
        foreach($cases as $case){
            $year_validate = explode('/',$case['data'])[2];

            if($year_validate == $year){
                $count_cases += $case['qtde_cases'];
            }
        }

        return $count_cases;

    }

}
