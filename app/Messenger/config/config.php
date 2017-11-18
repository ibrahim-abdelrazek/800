<?php
return [
    'user_model' => App\User::class,
    'message_model' => App\Messenger\Models\Message::class,
    'participant_model' => App\Messenger\Models\Participant::class,
    'thread_model' => App\Messenger\Models\Thread::class,
    /**
     * Define custom database table names - without prefixes.
     */
    'messages_table' => null,
    'participants_table' => null,
    'threads_table' => null,
];

