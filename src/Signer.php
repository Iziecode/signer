<?php

namespace Iziedev\Signer;

use Exception;
use Iziedev\Signer\Exceptions\CounterPluginNotExistsException;
use Iziedev\Signer\Exceptions\FailedOpenPKCS12KeystoreException;
use Iziedev\Signer\Exceptions\InputPdfFileNotFoundException;
use Iziedev\Signer\Exceptions\JavaNotInstalledException;
use Iziedev\Signer\Exceptions\KeystoreFileNotFoundException;
use Iziedev\Signer\Exceptions\KeystoreNotLoadedException;
use Iziedev\Signer\Exceptions\SignerPluginNotExistsException;
use Iziedev\Signer\Exceptions\VerifierPluginNotExistsException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Base class signer
 * 
 * This class provide basic command using JSignPdf
 * 
 * @package     Iziedev
 * @subpackage  Signer
 * @author      pandeptwidyaop <widya.oktapratama@gmail.com>
 */
class Signer
{
    /**
     * Constant signer type
     * 
     */
    const SIGNER = 1;
    const VERIFIER = 2;
    const COUNTER = 3;

    /**
     * Signer plugin path
     * 
     * @var string
     */
    protected $signerPluginPath = __DIR__ . '/../plugins/jsignpdf-1.6.4/JSignPdf.jar';

    /**
     * Counter plugin path
     * 
     * @var string
     */
    protected $counterPluginPath = __DIR__ . '/../plugins/jsignpdf-1.6.4/SignatureCounter.jar';

    /**
     * Pdf signer verification plugin
     * 
     * @var string
     */
    protected $verifierPluginPath = __DIR__ . '/../plugins/jsignpdf-1.6.4/Verifier.jar';

    /**
     * All configure signing
     * 
     * @var array
     */
    protected $config = [];

    /**
     * Pdf's path will signing
     * 
     * @var array
     */
    protected $inputPath = [];

    /**
     * Class constructor
     * 
     */
    public function __construct()
    {
        $this->config = config('signer');
    }

    /**
     * Validate java installed on machine
     * 
     * @return void
     * @throws \Iziedev\Signer\Exceptions\JavaNotInstalledException
     */
    protected function checkJavaInstalled()
    {
        $process = new Process(['java', '--version']);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            throw new JavaNotInstalledException();
        }
    }

    /**
     * Validate signer plugins path is valid
     * 
     * @return void
     * @throws Exception If plugins not available on given path
     */
    protected function checkSignerPath()
    {
        if (!file_exists($this->signerPluginPath)) {
            throw new SignerPluginNotExistsException();
        }
    }

    /**
     * Validate counter plugins path is valid
     * 
     * @return void
     * @throws Exception If plugins not available on given path
     */
    protected function checkCounterPath()
    {
        if (!file_exists($this->counterPluginPath)) {
            throw new CounterPluginNotExistsException();
        }
    }

    /**
     * Validate verifier plugins path is valid
     * 
     * @return void
     * @throws Exception If plugins not available on given path
     */
    protected function checkVerifierPath()
    {
        if (!file_exists($this->verifierPluginPath)) {
            throw new VerifierPluginNotExistsException();
        }
    }

    /**
     * Validate keystore is available and passphrase is right
     * 
     * @return void
     * @throws Exception If cannot keystore file cannot oppened and keystore can't openned
     */
    protected function checkCertificate()
    {
        $info = [];
        if (!file_exists($this->config['keystore_file'])) {
            throw new KeystoreFileNotFoundException($this->config['keystore_file']);
        }

        $source = file_get_contents($this->config['keystore_file']);
        if (!$source) {
            throw new KeystoreNotLoadedException();
        }

        //TODO: Add statement for other keystore type
        if (!openssl_pkcs12_read($source, $info, $this->config['keystore_passphrase'])) {
            throw new FailedOpenPKCS12KeystoreException();
        }
    }

    /**
     * Generate plugin signer command with config
     * 
     * @return string`
     */
    protected function generateCommand()
    {
        $commands = [
            'java',
            '-jar ' . $this->signerPluginPath,
            implode(' ', $this->inputPath),
            "-kst PKCS12",
            '-ksf ' . $this->config['keystore_file'],
            '-ksp ' . $this->config['keystore_passphrase'],
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

        return implode(' ', array_filter($commands));
    }


    /**
     * ----------------------------------------------------------------------------------
     * Public Access
     * ----------------------------------------------------------------------------------
     */

    /**
     * Raw configure for signing pdf file
     * 
     * @param array $config
     * @return \Iziedev\Signer\Signer
     */
    public function config(array $config)
    {
        $this->config = array_replace($this->config, $config);
        return $this;
    }

    /**
     * Input path of pdf file will be signing
     * 
     * @param string $pdfPath
     * @return \Iziedev\Signer\Signer
     */
    public function input($pdfPath)
    {
        if (!file_exists($pdfPath)) {
            throw new InputPdfFileNotFoundException($pdfPath);
        }
        $this->inputPath[] = $pdfPath;
        return $this;
    }

    /**
     * Path of certificate or keystore
     * 
     * @param string $certificatePath
     * @return Iziedev\Signer\Signer
     */
    public function certificate($certificatePath)
    {
        if (!file_exists($certificatePath)) {
            throw new KeystoreFileNotFoundException($certificatePath);
        }
        $this->config['keystore_file'] = $certificatePath;
        return $this;
    }

    /**
     * Password / passphrase of keystore file
     * 
     * @param string $passphrase
     * @return \Iziedev\Signer\Signer
     */
    public function passphrase($passphrase)
    {
        $this->config['keystore_passphrase'] = $passphrase;
        return $this;
    }

    /**
     * Set of pdf signed pdf will ne output
     * 
     * @param string $dir
     * @return \Iziedev\Signer\Signer
     */
    public function outputDirectory($dir)
    {
        $this->config['output_directory'] = $dir;
        return $this;
    }

    /**
     * Process signing pdf
     * 
     * @return boolean
     */
    public function process()
    {
        $this->checkJavaInstalled();
        $this->checkSignerPath();
        $this->checkCertificate();
        $command = $this->generateCommand();
        exec($command, $output, $return);
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
        $command = [
            'java',
            '-jar',
            $this->counterPluginPath,
            $pathFile
        ];
        $output = null;
        exec(implode(' ', $command), $output, $re);
        dd($output);
    }

    /**
     * Run direct command to signing plugin
     * 
     * @param array $commands
     * @param int $plugin
     * @return array
     */
    public function command(array $commands, $plugin = self::SIGNER)
    {
        $choosePlugin = $this->signerPluginPath;
        if ($plugin == 2) {
            $choosePlugin = $this->verifierPluginPath;
        } else if ($plugin == 3) {
            $choosePlugin = $this->counterPluginPath;
        }

        $stringCommand = "java -jar {$choosePlugin} " . implode(' ', array_filter($commands));
        $output = null;
        exec($stringCommand, $output);
        return $output;
    }
}
