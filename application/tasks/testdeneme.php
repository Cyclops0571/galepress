<?php

class TestDeneme_Task {

    public function run()
    {
		$lockFile = path('base') . 'lock/' . __CLASS__ . ".lock";
		
		$fp = fopen($lockFile, 'r+');
		/* Activate the LOCK_NB option on an LOCK_EX operation */
		if(!flock($fp, LOCK_EX | LOCK_NB)) {
			echo 'Unable to obtain lock';
			exit(-1);
		}
		
		sleep(30);
		
    }

}