<?php
// BotHandler.php

class BotHandler {
    private $update;
    private $admins;

    public function __construct($update, $admins) {
        $this->update = $update;
        $this->admins = $admins;
    }

    public function handle() {
        if (isset($this->update['message'])) {
            $this->handleMessage($this->update['message']);
        } elseif (isset($this->update['callback_query'])) {
            $this->handleCallback($this->update['callback_query']);
        }
    }

    private function handleMessage($message) {
        $chat_id = $message['chat']['id'];
        $user_id = $message['from']['id'];
        $text = $message['text'] ?? '';

        // Example: Only allow messages from admins
        if (!in_array($user_id, $this->admins)) {
            $this->sendMessage($chat_id, "You are not authorized.");
            return;
        }

        if ($text === "/start") {
            $this->sendMessage($chat_id, "Bot is running and protecting the group.");
        }
    }

    private function handleCallback($callback) {
        // Optional: Handle button clicks, etc.
    }

    private function sendMessage($chat_id, $text) {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => $text
        ]);
    }
}
