<?php

namespace Iziedev\Signer;

use Exception;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Signer
{
    protected $signerPluginPath = __DIR__ . '/plugins/jsignpdf-1.6.4/JSignPdf.jar';
    protected $counterPluginPath = __DIR__ . '/plugins/jsignpdf-1.6.4/SignatureCounter.jar';
    protected $verifierPluginPath = __DIR__ . '/plugins/jsignpdf-1.6.4/Verifier.jar';

    protected $inputPath;
    protected $passphrase;
    protected $outputPath;
    protected $certificatePath;

    protected function checkJavaInstalled()
    {
        $process = new Process(['java', '--version']);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            throw new Exception('Java is not installed on this computer, please install JDK', 1);
        }
    }

    protected function checkSignerPath()
    {
        if (!file_exists($this->signerPluginPath)) {
            throw new Exception("File not exists {$this->signerPluginPath}", 2);
        }
    }

    protected function checkCounterPath()
    {
        if (!file_exists($this->counterPluginPath)) {
            throw new Exception("File not exists {$this->counterPluginPath}", 3);
        }
    }

    protected function checkVerifierPath()
    {
        if (!file_exists($this->verifierPluginPath)) {
            throw new Exception("File not exists {$this->verifierPluginPath}", 4);
        }
    }

    public function input($pdfPath)
    {
        if (!file_exists($pdfPath)) {
            throw new Exception("File pdf not found {$pdfPath}", 5);
        }
        $this->inputPath = $pdfPath;
        return $this;
    }

    public function certificate($certificatePath)
    {
        if (!file_exists($certificatePath)) {
            throw new Exception("Certificate not found {$certificatePath}", 6);
        }
        $this->certificatePath = $certificatePath;
        return $this;
    }

    public function passphrase($passphrase)
    {
        $this->passphrase = $passphrase;
        return $this;
    }

    public function output($outputPath)
    {
        $this->outputPath = $outputPath;
        return $this;
    }

    public function process()
    {
        $this->checkJavaInstalled();
        $this->checkSignerPath();
    }
}
