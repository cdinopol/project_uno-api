<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExampleController extends ApiController
{
	public function test(Request $request)
	{
        return $this->respondSuccess('test');
	}

    public function get_user_id()
    {
    	//$test = 'hehe';
    	//var_dump(DB::connection()); exit;
    	//$test = DB::table("test_table")->pluck('test_field')->first();
        //return $this->respondSuccess('Good job! Good luck with your API! ' . $test, $this->user);
    	$before = microtime(true);

    	$hero_1 = ['id' => 'hero_1', 'aspd' => 150, 'hp' => 1000, 'dmg' => 51, 'def' => 30, 'nxt_atk' => 0];
    	$hero_2 = ['id' => 'hero_2', 'aspd' => 150, 'hp' => 5000, 'dmg' => 31, 'def' => 50, 'nxt_atk' => 0];

        $heroes = [
        	$hero_1, $hero_2
        ];

        // init atks
        foreach ($heroes as $k => $hero) {
        	$heroes[$k]['nxt_atk'] = floor(1000 / ($heroes[$k]['aspd'] / 60));
        }

        $battle_log = [];
        $winner = null;

        // start battle
		do {
			usort($heroes, function($a, $b) {
			    return $a['nxt_atk'] <=> $b['nxt_atk'];
			});
			$tmp_log = "";

			//update next atk
			$tmp_log .= $heroes[0]['nxt_atk'] . ' : ' .  $heroes[0]['id'];
			$heroes[0]['nxt_atk'] += floor(1000 / ($heroes[0]['aspd'] / 60));

			// atk
			$dmg = max(0, $heroes[0]['dmg'] - $heroes[1]['def']);
			$tmp_log .= ' ** atking ' .  $heroes[1]['id'] . ' damaging '. $dmg;
			$heroes[1]['hp'] -= $dmg;

			$tmp_log .= ' ** '.$heroes[1]['id'] . ' ' . $heroes[1]['hp'] . ' hp left';

			$battle_log[] = $tmp_log;

			if ($heroes[1]['hp'] <= 0) {
				$winner = $heroes[0];
			}

			
		} while (!$winner);

		$after = microtime(true);

		$battle_log[] = 'Execution time: '. ($after-$before) . 'seconds';

		return $this->respondSuccess('We have a winner! ' . $winner['id'], $battle_log);
    }
}
