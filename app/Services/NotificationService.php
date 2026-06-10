<?php

namespace App\Services;

use App\Models\NotificationLog;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Throwable;

class NotificationService
{
    public function __construct(private ActivityLogger $activityLogger)
    {
    }

    /**
     * Send an email/SMS notification and store the full attempt in notification_logs.
     *
     * @param array<string, mixed> $data
     */
    public function send(array $data): NotificationLog
    {
        $user = isset($data['user_id']) ? User::find($data['user_id']) : null;
        $channel = $data['channel'];
        $recipient = $this->resolveRecipient($channel, $data['recipient'] ?? null, $user);

        $log = NotificationLog::create([
            'user_id' => $user?->id,
            'channel' => $channel,
            'recipient' => $recipient,
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
            'status' => 'pending',
            'meta' => [
                'sent_by' => auth()->id(),
            ],
        ]);

        try {
            if (! $recipient) {
                throw new \RuntimeException('No valid recipient was found for this notification.');
            }

            if ($channel === 'email') {
                $this->sendEmail($recipient, $data['subject'] ?? 'Club Notification', $data['message']);
            }

            if ($channel === 'sms') {
                $this->sendSmsPlaceholder($recipient, $data['message']);
            }

            $log->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error_message' => null,
                'meta' => array_merge($log->meta ?? [], [
                    'placeholder' => $channel === 'sms',
                ]),
            ]);
        } catch (Throwable $exception) {
            $log->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);
        }

        $log = $log->fresh();

        $this->activityLogger->log(
            'send',
            'notification',
            "Sent {$channel} notification attempt to {$recipient} with status {$log->status}.",
            $log,
            null,
            $log->toArray()
        );

        return $log;
    }

    private function resolveRecipient(string $channel, ?string $recipient, ?User $user): ?string
    {
        if ($recipient) {
            return $recipient;
        }

        return match ($channel) {
            'email' => $user?->email,
            'sms' => $user?->phone,
            default => null,
        };
    }

    private function sendEmail(string $recipient, string $subject, string $message): void
    {
        Mail::raw($message, function ($mail) use ($recipient, $subject): void {
            $mail->to($recipient)->subject($subject);
        });
    }

    private function sendSmsPlaceholder(string $recipient, string $message): void
    {
        logger()->info('SMS placeholder notification', [
            'recipient' => $recipient,
            'message' => $message,
        ]);
    }
}
