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
class BondpriceCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'bondprice';

    /**
     * @var string
     */
    protected $description = 'Get the current Bond price.';

    /**
     * @var string
     */
    protected $usage = '/bondprice';

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
        if(!$bond_data = file_get_contents("https://bondonblockchain.com/app/telegramAPI.php?q=bond")) {
          $reply_message = "We are unable to fetch the data right now.";
        } else {
          $bond_data = json_decode($bond_data,true);
          $reply_message = "Current Bond price is $".$bond_data['price'];
          if($bond_data['change'] < 0) {
            $reply_message .= " ".(-1*$bond_data['change'])."% ▼";
          } else {
            $reply_message .= " ".$bond_data['change']."% ▲";
          }
        }
        
        $data = [
            'chat_id' => $chat_id,
            'text'    => $reply_message,
        ];

        return Request::sendMessage($data);
    }
}