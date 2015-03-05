<?php

class TestDeneme_Task {

    public function run()
    {
		$consoleLog = new ConsoleLog(Config::get('custom.' . __CLASS__), "deneme log");
		$consoleLog->save();
		sleep(10);
		var_dump($consoleLog->created_at);
//		echo date("Y-m-d H:i:s", $consoleLog->created_at) . "-------" . date("Y-m-d H:i:s", $consoleLog->updated_at), PHP_EOL;
		$consoleLog->cli_text .= " Success";
		$consoleLog->save();
//		echo date("Y-m-d H:i:s", $consoleLog->created_at) . "-------" . date("Y-m-d H:i:s", $consoleLog->updated_at), PHP_EOL;
    }

}