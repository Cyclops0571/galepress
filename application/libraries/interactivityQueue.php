<?php
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class InteractivityQueue {
	public static function trigger() {
		// burada queueya atiyoruz
		$connection = new AMQPConnection('localhost', 5672, 'galepress', 'galeprens');
		$channel = $connection->channel();
		$channel->queue_declare('queue_interactivepdf', false, false, false, false);
		$msg = new AMQPMessage('Interactivity Start Progress!');
		$channel->basic_publish($msg, '', 'queue_interactivepdf');
		$channel->close();
		$connection->close();
	}
}
