<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf {
    public function generate($html, $filename='', $paper = 'A4', $orientation = 'portrait')
    {
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('isHtml5ParserEnabled', TRUE);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        
        if ($filename) {
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0)); // 0 = Preview, 1 = Download
        } else {
            return $dompdf->output();
        }
    }
}