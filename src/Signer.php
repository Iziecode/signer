<?php

namespace Iziedev\Signer;

use Exception;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Signer
{
    protected $signerPluginPath = __DIR__ . '/plugins/jsignpdf-1.6.4/JSignPdf.jar';
    protected $counterPluginPath = __DIR__ . '/plugins/jsignpdf-1.6.4/SignatureCounter.jar';
    protected $verifierPluginPath = __DIR__ . '/plugins/jsignpdf-1.6.4/Verifier.jar';

    protected $config = [];

    protected $inputPath;
    protected $passphrase;
    protected $outputPath;
    protected $certificatePath;

    public function __construct()
    {
        $this->config = config('signer');
    }

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

    public function checkCertificate()
    {
        $info = [];
        $source = file_get_contents($this->config['keystore_file']);
        if (!$source) {
            throw new Exception("Cannot read file certificate {$this->certificatePath}", 7);
        }
        if (!openssl_pkcs12_read($source, $info, $this->config['keystore_passphrase'])) {
            throw new Exception("Cannot open file certificate, maybe wrong passhrase", 8);
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
        $this->config['keystore_file'] = $certificatePath;
        return $this;
    }

    public function passphrase($passphrase)
    {
        $this->config['keystore_passphrase'] = $passphrase;
        return $this;
    }

    public function outputDirectory($dir)
    {
        $this->config['output_directory'] = $dir;
        return $this;
    }

    public function process()
    {
        $this->checkJavaInstalled();
        $this->checkSignerPath();
        $this->checkCertificate();
        $command = [
            'java',
            '-jar ' . $this->signerPluginPath,
            $this->inputPath,
            "-kst " . $this->config['keystore_type'],
            '-ksf "' . $this->config['keystore_file'] . '"',
            '-ksp "' . $this->config['keystore_passphrase'] . '"',
            '-ha ' . $this->config['hash_algorithm'],
            $this->config['output_directory'] ? '-d ' . $this->config['output_directory'] : '',
            $this->config['output_prefix'] ? '-op ' . $this->config['output_prefix'] : '',
            $this->config['output_suffix'] ? '-os ' . $this->config['output_suffix'] : '',
            $this->config['disable_acrobat6_layer_mode'] ? '--disable-acrobat6-layer-mode' : '',
            $this->config['disable_assembly'] ? '--disable-assembly' : '',
            $this->config['disable_copy'] ? '--disable-copy' : '',
            $this->config['disable_fill'] ? '--disable-fill' : '',
            $this->config['disable_modify_annotations'] ? '--disable-modify-annotations' : '',
            $this->config['disable_modify_content'] ? '--disable-modify-content' : '',
            $this->config['disable_screen_readers'] ? '--disable-screen-readers' : ''
        ];
        $output = null;
        $cmd = implode(' ', array_filter($command));
        exec($cmd, $output, $return);
        dd($output);
    }

    public function info($pathFile)
    {
        $command = [
            'java',
            '-jar',
            $this->verifierPluginPath,
            $pathFile
        ];

        $output = null;
        exec(implode(' ', $command), $output, $re);
        dd($output);
    }

    public function counterInfo($pathFile)
    {
    }
}
