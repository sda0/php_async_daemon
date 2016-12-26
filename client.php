<?php
include 'Queue/Queue.php';



$object = new stdclass;
$object->name = 'имя';
$object->id = uniqid();
 

$client = Queue::getInstance();
if ( $client->msg_send(Queue::TYPE_REQUEST, $object, true, true) ) {
    echo "added object to queue - id:{$object->id}, name:{$object->name} <br/>\n";
}else {
	echo "could not add message to queue: $client->errorcode <br/>\n";
}

//смотрим какие ответы уже пришли от сервера к этому моменту
foreach ($client->responses() as $n => $msg) {
    echo "received response about object id:{$msg->id}, status:{$msg->status} <br/>\n";
}