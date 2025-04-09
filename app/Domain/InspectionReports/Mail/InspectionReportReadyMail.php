<?php

namespace App\Domain\InspectionReports\Mail;

use App\Domain\InspectionReports\Models\InspectionReport;
use App\Domain\InspectionReports\ViewModels\InspectionReportViewModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InspectionReportReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public InspectionReportViewModel $viewModel;

    public string $representativeName;

    public string $propertyAddress;
    public string $inspectionId;

    /**
     * Create a new message instance.
     */
    public function __construct(
        InspectionReportViewModel $viewModel,
        string $representativeName,
        string $propertyAddress
    ) {
        $this->viewModel = $viewModel;
        $this->representativeName = $representativeName;
        $this->propertyAddress = $propertyAddress;
		$this->inspectionId = InspectionReport::where('nockee_id', $viewModel->id)->first()->id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre état des lieux est disponible.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.inspection-report.index',
            with: [
				'tenants' => $this->viewModel->getTenants,
                'representative' => $this->representativeName,
                'property' => $this->propertyAddress,
                'url' => route('inspection-report.download', $this->inspectionId),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
