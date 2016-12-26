<?php
include 'Queue/Queue.php';
include 'HTTP/Request2.php';

$worker = Queue::getInstance();

$run = function ($msg) use ($worker) {
    echo "Message from queue - id:{$msg->id}, name:{$msg->name} \n";
    $result     = new stdclass;
    $result->id = $msg->id;

    $request = new HTTP_Request2('http://www.nsk.mts.ru/', HTTP_Request2::METHOD_GET);
    try {
        $response       = $request->send();
        $result->status = $response->getStatus();
    } catch (HTTP_Request2_Exception $e) {
        $result->status = '500: ' . $e->getMessage();
    }

    $worker->msg_send(Queue::TYPE_RESPONSE, $result, true, true);
};

$worker->msg_receive(Queue::TYPE_REQUEST, $run);
