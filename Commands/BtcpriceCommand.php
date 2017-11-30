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
class BtcpriceCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'btcprice';

    /**
     * @var string
     */
    protected $description = 'Get the current BTC price in USD.';

    /**
     * @var string
     */
    protected $usage = '/btcprice';

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
        if(!$bond_data = file_get_contents("https://bondonblockchain.com/app/telegramAPI.php?q=btc")) {
          $reply_message = "We are unable to fetch the data right now.";
        } else {
          $bond_data = json_decode($bond_data,true);
          if($bond_data['price'] == "na") {
            $reply_message = "We are unable to fetch the data right nows.";
          } else {
            $reply_message = "Current BTC price is $".$bond_data['price'];
          }
        }
        
        $data = [
            'chat_id' => $chat_id,
            'text'    => $reply_message,
        ];

        return Request::sendMessage($data);
    }
}