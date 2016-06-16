<?php

require_once path("base") . "php-amqplib/vendor/autoload.php";

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class TestDeneme_Task
{

    public function run()
    {
        $cf = ContentFile::find(2716);
        ContentFile::createPdfPages($cf);
    }

    public function consume()
    {

        $connection = new AMQPConnection('localhost', 5672, 'galepress', 'galeprens');
        $channel = $connection->channel();
        $channel->queue_declare('queue_interactivepdf', false, true, false, false);
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        $callback = function ($msg) {
            echo " [x] Received ", $msg->body, "\n";
        };
        $channel->basic_consume('queue_interactivepdf', '', false, true, false, false, $callback);
        while (count($channel->callbacks)) {
            echo "calisiyorum";
            ob_flush();
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }

    public function soruMaratonu2015_1()
    {
        /**
         * İki rakamlı iki farklı sayı tutuyor ve toplamlarını alıyorsunuz. Aynı işlemi arkadaşınız da yapıyor. Sizin ve arkadaşınızın aynı toplamı elde etme olasılığınız kaçtır?
         * Problem tek rakamlı iki farklı sayı için sorulsaydı cevap 29/405 olacaktı
         * Cevabınızı kesir olarak ve sadeleştirerek giriniz.
         */
        $esitlikSayisi = 0;
        $ihtimalSayisi = 0;
        for ($i = 10; $i < 100; $i++) {
            for ($j = 10; $j < 100; $j++) {
                if ($i == $j) {
                    continue;
                }
                $firstPersonTotal = $i + $j;

                for ($secondPersonFirstChoose = 10; $secondPersonFirstChoose < 100; $secondPersonFirstChoose++) {
                    for ($secondPersonSecondChoose = 10; $secondPersonSecondChoose < 100; $secondPersonSecondChoose++) {
                        if ($secondPersonFirstChoose == $secondPersonSecondChoose) {
                            continue;
                        }
                        $secondPersonTotal = $secondPersonFirstChoose + $secondPersonSecondChoose;
                        if ($firstPersonTotal == $secondPersonTotal) {
                            echo "1_1=" . $i . " 1_2=" . $j . " 2_1=" . $secondPersonFirstChoose . " 2_2=" . $secondPersonSecondChoose . "\r\n";
                            $esitlikSayisi++;
                        }
                        $ihtimalSayisi++;
                    }
                }
            }
        }

        echo "esitlikSayisi = " . $esitlikSayisi . " ihtimalSayisi=" . $ihtimalSayisi;
        return;
    }

}
