<?php

namespace Iziedev\Signer;

use Exception;
use Iziedev\Signer\Exceptions\CounterPluginNotExistsException;
use Iziedev\Signer\Exceptions\FailedOpenPKCS12KeystoreException;
use Iziedev\Signer\Exceptions\InputPdfFileNotFoundException;
use Iziedev\Signer\Exceptions\JavaNotInstalledException;
use Iziedev\Signer\Exceptions\KeystoreFileNotFoundException;
use Iziedev\Signer\Exceptions\KeystoreNotLoadedException;
use Iziedev\Signer\Exceptions\PropertyRequiredException;
use Iziedev\Signer\Exceptions\PropertyValueNotAvailableException;
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
        if (!openssl_pkcs12_read($source, $info, $this->config['keystore_password'])) {
            throw new FailedOpenPKCS12KeystoreException();
        }
    }

    /**
     * Generate plugin signer command with config
     * 
     * @return string
     */
    protected function generateCommand()
    {
        $commands = [
            'java',
            '-jar ' . $this->signerPluginPath,
            implode(' ', $this->inputPath),
            $this->config['append'] ? '--append' : '',
            $this->config['bg_path'] ? '--bg-path ' . $this->config['bg_path'] : '',
            $this->config['bg_scale'] ? '--bg-scale ' . $this->config['bg_scale'] : '',
            $this->config['certification_level'] ? '--certification-level ' . $this->config['certification_level'] : '',
            $this->config['crl'] ? '--crl' : '',
            $this->config['contact'] ? '--contact ' . $this->config['contact'] : '',
            $this->config['disable_acrobat6_layer_mode'] ? '--disable-acrobat6-layer-mode' : '',
            $this->config['disable_assembly'] ? '--disable-assembly' : '',
            $this->config['disable_copy'] ? '--disable-copy' : '',
            $this->config['disable_fill'] ? '--disable-fill' : '',
            $this->config['disable_modify_annotations'] ? '--disable-modify-annotations' : '',
            $this->config['disable_modify_content'] ? '--disable-modify-content' : '',
            $this->config['disable_screen_readers'] ? '--disable-screen-readers' : '',
            $this->config['encryption'] ? '--encryption ' . $this->config['encryption'] : '',
            $this->config['encryption_certificate'] ? '--encryption-certificate ' . $this->config['encryption_certificate'] : '',
            $this->config['font_size'] ? '--font-size ' . $this->config['font_size'] : '',
            $this->config['hash_algorithm'] ? '--hash-algorithm ' . $this->config['hash_algorithm'] : '',
            $this->config['img_path'] ? '--img-path ' . $this->config['img_path'] : '',
            $this->config['keystore_type'] ? '--keystore-type ' . $this->config['keystore_type'] : '',
            $this->config['keystore_file'] ? '--keystore-file ' . $this->config['keystore_file'] : '',
            $this->config['keystore_password'] ? '--keystore-password ' . $this->config['keystore_password'] : '',
            $this->config['key_alias'] ? '--key-alias ' . $this->config['key_alias'] : '',
            $this->config['key_index'] ? '--key-index' . $this->config['key_index'] : '',
            $this->config['l2_text'] ? '--l2-text ' . $this->config['l2_text'] : '',
            $this->config['l4_text'] ? '--l4-text ' . $this->config['l4_text'] : '',
            $this->config['location'] ? '--location ' . $this->config['location'] : '',
            $this->config['lly'] ? '--lly ' . $this->config['lly'] : '',
            $this->config['llx'] ? '--llx ' . $this->config['llx'] : '',
            $this->config['output_directory'] ? '-d ' . $this->config['output_directory'] : '',
            $this->config['output_prefix'] ? '-op ' . $this->config['output_prefix'] : '',
            $this->config['output_suffix'] ? '-os ' . $this->config['output_suffix'] : '',
            $this->config['ocsp'] ? '--ocsp' : '',
            $this->config['ocsp_server_url'] ? '--ocsp-server-url ' . $this->config['ocsp_server_url'] : '',
            $this->config['owner_password'] ? '--owner-password ' . $this->config['owner_password'] : '',
            $this->config['page'] ? '--page ' . $this->config['page'] : '',
            $this->config['print_right'] ? '--print-right ' . $this->config['print_right'] : '',
            $this->config['proxy_host'] ? '--proxy-host ' . $this->config['print_right'] : '',
            $this->config['proxy_port'] ? '--proxy-port ' . $this->config['proxy_port'] : '',
            $this->config['proxy_type'] ? '--proxy-type ' . $this->config['proxy_type'] : '',
            $this->config['render_mode'] ? '--render-mode ' . $this->config['render_mode'] : '',
            $this->config['reason'] ? '--reason ' . $this->config['reason'] : '',
            $this->config['tsa_authentication'] ? '--tsa-authentication ' . $this->config['tsa_authentication'] : '',
            $this->config['tsa_server_url'] ? '--tsa-server-url ' . $this->config['tsa_server_url'] : '',
            $this->config['tsa_hash_algorithm'] ? '--tsa-hash-algorithm ' . $this->config['tsa_hash_algorithm'] : '',
            $this->config['tsa_user'] ? '--tsa-user ' . $this->config['tsa_user'] : '',
            $this->config['tsa_password'] ? '--tsa_password ' . $this->config['tsa_password'] : '',
            $this->config['tsa_policy_oid'] ? '--tsa-policy-oid ' . $this->config['tsa_policy_oid'] : '',
            $this->config['tsa_cert_file'] ? '--tsa-cert-file ' . $this->config['tsa_cert_file'] : '',
            $this->config['tsa_cert_password'] ? '--tsa-cert-password ' . $this->config['tsa_cert_password'] : '',
            $this->config['tsa_cert_file_type'] ? '--tsa-cert-file-type ' . $this->config['tsa_cert_file_type'] : '',
            $this->config['user_password'] ? '--user-password ' . $this->config['user_password'] : '',
            $this->config['urx'] ? '--urx ' .  $this->config['urx'] : '',
            $this->config['ury'] ? '--ury ' . $this->config['ury'] : '',
            $this->config['visible_signature'] ? '--visible-signature' : ''
        ];

        $encryptionAvailable = ['NONE', 'CERTIFICATE', 'PASSWORD'];
        if ($this->config['encryption'] && !in_array($this->config['encryption'], $encryptionAvailable)) {
            throw new PropertyValueNotAvailableException('encryption', $this->config['encryption'], $encryptionAvailable);
        }

        if ($this->config['encryption'] == 'CERTIFICATE') {
            if (!$this->config['encryption_certificate']) {
                throw new PropertyRequiredException('encryption_certificate', 'encryption = CERTIFICATE');
            }
        }

        if ($this->config['encryption'] == 'PASSWORD') {
            if (!$this->config['user_password']) {
                throw new PropertyRequiredException('user_password', 'encryption = PASSWORD');
            }

            if (!$this->config['owner_password']) {
                throw new PropertyRequiredException('owner_password', 'encryption = PASSWORD');
            }
        }

        $hashAlgorithmAvailable = ['SHA1', 'SHA256', 'SHA348', 'SHA512', 'RIPEMD160'];
        if (!in_array($this->config['hash_algorithm'], $hashAlgorithmAvailable)) {
            throw new PropertyValueNotAvailableException('hash_algorithm', $this->config['hash_algorithm'], $hashAlgorithmAvailable);
        }

        $keystoreTypeAvailable = ['BCPKCS12', 'BKS', 'BKS-V1', 'BOUNCYCASTLE', 'CASEEXACTJKS', 'CloudFoxy', 'DKS', 'JCEKS', 'JKS', 'KEYCHAINSTORE', 'PKCS12', 'PKCS12-3DES-40RC2', 'PKCS12-DEF', 'PKCS12-DEF-3DES-3DES', 'PKCS12-DEF-3DES-40RC2'];
        if ($this->config['keystore_type'] && !in_array($this->config['keystore_type'], $keystoreTypeAvailable)) {
            throw new PropertyValueNotAvailableException('keystore_type', $this->config['keystore_type'], $keystoreTypeAvailable);
        }

        //This statement currentyl disable
        if ($this->config['visible_signature'] && false) {
            if (!$this->config['llx']) {
                throw new PropertyRequiredException('llx', 'visible_signature');
            }

            if (!$this->config['lly']) {
                throw new PropertyRequiredException('lly', 'visible_signature');
            }

            if (!$this->config['urx']) {
                throw new PropertyRequiredException('urx', 'visible_signature');
            }

            if (!$this->config['ury']) {
                throw new PropertyRequiredException('ury', 'visible_signature');
            }
        }

        if ($this->config['ocsp']) {
            if (!$this->config['ocsp_server_url']) {
                throw new PropertyRequiredException('ocsp_server_url', 'ocsp');
            }
        }

        $printRightAvailable = ['ALLOW_PRINTING', 'DISALLOW_PRINTING', 'ALLOW_DEGRADED_PRINTING'];
        if (!in_array($this->config['print_right'], $printRightAvailable)) {
            throw new PropertyValueNotAvailableException('print_right', $this->config['print_right'], $printRightAvailable);
        }

        $proxyTypeAvailable = ['DIRECT', 'HTTP', 'SOCKS'];
        if (!in_array($this->config['proxy_type'], $proxyTypeAvailable)) {
            throw new PropertyValueNotAvailableException('proxy_type', $this->config['proxy_type'], $proxyTypeAvailable);
        }

        $renderModeAvailable = ['DESCRIPTION_ONLY', 'GRAPHIC_AND_DESCRIPTION', 'SIGNAME_AND_DESCRIPTION'];
        if (!in_array($this->config['render_mode'], $renderModeAvailable)) {
            throw new PropertyValueNotAvailableException('render_mode', $this->config['render_mode'], $renderModeAvailable);
        }


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
        $this->config['keystore_password'] = $passphrase;
        return $this;
    }

    /**
     * Set visible sign
     * 
     * @return \Iziedev\Signer\Signer
     */
    public function visible()
    {
        $this->config['visible_signature'] = true;
        return $this;
    }

    /**
     * Lower Left Corner X Axis
     * 
     * @param int $position
     * @return \Iziedev\Signer\Signer;
     */
    public function llx(int $position)
    {
        $this->config['llx'] = $position;
        return $this;
    }

    /**
     * Lower Left Corner Y Axis
     * 
     * @param int $position
     * @return \Iziedev\Signer\Signer
     */
    public function lly(int $position)
    {
        $this->config['lly'] = $position;
        return $this;
    }

    /**
     * Upper Right Corner X Axis
     * 
     * @param int $position
     * @return \Iziedev\Signer\Signer
     */
    public function urx(int $position)
    {
        $this->config['urx'] = $position;
        return $this;
    }

    /**
     * Upper Right Corner Y Axis
     * 
     * @param int $position
     * @return \Iziedev\Signer\Signer
     */
    public function ury(int $position)
    {
        $this->config['ury'] = $position;
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
