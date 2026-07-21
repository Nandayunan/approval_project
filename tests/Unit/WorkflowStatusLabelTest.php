<?php

namespace Tests\Unit;

use App\Models\PackagingForm;
use PHPUnit\Framework\TestCase;

class WorkflowStatusLabelTest extends TestCase
{
    public function test_export_import_status_label_matches_new_workflow(): void
    {
        $form = new PackagingForm([
            'status' => 'menunggu_persetujuan_export_import',
        ]);

        $this->assertSame('Menunggu Persetujuan Export-Import', $form->status_label);
    }
}
