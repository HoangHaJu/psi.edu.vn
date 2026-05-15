<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeacherReviewNotification extends Mailable
{
    use Queueable, SerializesModels;

    public array $review;
    public $student;

    public function __construct(array $review, $student)
    {
        $this->review = $review;
        $this->student = $student;
    }

    public function build()
    {
        return $this->subject('Teacher\'s Review')
            ->view('mails.teacher_review')
            ->with(['review' => $this->review, 'student' => $this->student]);
    }
}
