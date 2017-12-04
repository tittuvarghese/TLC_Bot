<?php
/**
* This file is part of the TelegramBot package.
*
* (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

/**
* User "/echo" command
*
* Simply echo the input back to the user.
*/
class IndianpriceCommand extends UserCommand
{
  /**
  * @var string
  */
  protected $name = 'indianprice';
  
  /**
  * @var string
  */
  protected $description = 'Get the current Koinex price in INR.';
  
  /**
  * @var string
  */
  protected $usage = '/indianprice';
  
  /**
  * @var string
  */
  protected $version = '1.1.0';
  
  /**
  * Command execute method
  *
  * @return \Longman\TelegramBot\Entities\ServerResponse
  * @throws \Longman\TelegramBot\Exception\TelegramException
  */
  public function execute()
  {
    $message = $this->getMessage();
    $chat_id = $message->getChat()->getId();
    /*$text    = trim($message->getText(true));
    
    if ($text === '') {
    $text = 'Command usage: ' . $this->getUsage();
  }*/
  // Step 1
  /*$cSession = curl_init(); 
  // Step 2
  curl_setopt($cSession,CURLOPT_URL,"https://koinex.in/api/ticker");
  curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($cSession,CURLOPT_HEADER, false); 
  // Step 3
  $result=curl_exec($cSession);
  // Step 4
  curl_close($cSession);*/
  // Step 5
  $result = exec("curl https://koinex.in/api/ticker");
  if(!isset($result)) {
    $reply_message = "We are unable to fetch the data right now.";
  } else {
    $bond_data = $result;
    $bond_data = json_decode($bond_data,true);
    if($bond_data['prices'] == "na") {
      $reply_message = "We are unable to fetch the data right now.";
    } else {
      //$reply_message = $result;
      $reply_message = "BTC price is ₹".$bond_data['prices']['BTC']."\n";
      $reply_message .= "ETH price is ₹".$bond_data['prices']['ETH']."\n";
      $reply_message .= "BCH price is ₹".$bond_data['prices']['BCH']."\n";
      $reply_message .= "LTC price is ₹".$bond_data['prices']['LTC']."\n";
      $reply_message .= "XRP price is ₹".$bond_data['prices']['XRP']."\n";
    }
  }
  
  $data = [
    'chat_id' => $chat_id,
    'text'    => $reply_message,
  ];
  
  return Request::sendMessage($data);
}
}